<?php
namespace App\Helpers;

class WebBrowserForm
{
    public $info, $fields;
    
    public function __construct()
    {
        $this->info = array();
        $this->fields = array();
    }
    
    public function FindFormFields($name = false, $value = false, $type = false)
    {
        $fields = array();
        foreach ($this->fields as $num => $field)
        {
            if (($type === false || $field["type"] === $type) && ($name === false || $field["name"] === $name) && ($value === false || $field["value"] === $value))
            {
                $fields[] = $field;
            }
        }
        
        return $fields;
    }
    
    public function GetHintMap()
    {
        $result = array();
        foreach ($this->fields as $num => $field)
        {
            if (isset($field["hint"]))  $result[$field["hint"]] = $field["name"];
        }
        
        return $result;
    }
    
    public function GetVisibleFields($submit)
    {
        $result = array();
        foreach ($this->fields as $num => $field)
        {
            if ($field["type"] == "input.hidden" || (!$submit && ($field["type"] == "input.submit" || $field["type"] == "input.image" || $field["type"] == "input.button" || substr($field["type"], 0, 7) == "button.")))  continue;
            
            $result[$num] = $field;
        }
        
        return $result;
    }
    
    public function GetFormValue($name, $checkval = false, $type = false)
    {
        $val = false;
        foreach ($this->fields as $field)
        {
            if (($type === false || $field["type"] === $type) && $field["name"] === $name)
            {
                if (is_string($checkval))
                {
                    if ($checkval === $field["value"])
                    {
                        if ($field["type"] == "input.radio" || $field["type"] == "input.checkbox")  $val = $field["checked"];
                        else  $val = $field["value"];
                    }
                }
                else if (($field["type"] != "input.radio" && $field["type"] != "input.checkbox") || $field["checked"])
                {
                    $val = $field["value"];
                }
            }
        }
        
        return $val;
    }
    
    public function SetFormValue($name, $value, $checked = false, $type = false, $create = false)
    {
        $result = false;
        foreach ($this->fields as $num => $field)
        {
            if (($type === false || $field["type"] === $type) && $field["name"] === $name)
            {
                if ($field["type"] == "input.radio")
                {
                    $this->fields[$num]["checked"] = ($field["value"] === $value ? $checked : false);
                    $result = true;
                }
                else if ($field["type"] == "input.checkbox")
                {
                    if ($field["value"] === $value)  $this->fields[$num]["checked"] = $checked;
                    $result = true;
                }
                else if ($field["type"] != "select" || !isset($field["options"]) || isset($field["options"][$value]))
                {
                    $this->fields[$num]["value"] = $value;
                    $result = true;
                }
            }
        }
        
        // Add the field if it doesn't exist.
        if (!$result && $create)
        {
            $this->fields[] = array(
                "id" => false,
                "type" => ($type !== false ? $type : "input.text"),
                "name" => $name,
                "value" => $value,
                "checked" => $checked
            );
        }
        
        return $result;
    }
    
    public function GenerateFormRequest($submitname = false, $submitvalue = false)
    {
        $method = $this->info["method"];
        $fields = array();
        $files = array();
        foreach ($this->fields as $field)
        {
            if ($field["type"] == "input.file")
            {
                if (is_array($field["value"]))
                {
                    $field["value"]["name"] = $field["name"];
                    $files[] = $field["value"];
                    $method = "post";
                }
            }
            else if ($field["type"] == "input.reset" || $field["type"] == "button.reset")
            {
            }
            else if ($field["type"] == "input.submit" || $field["type"] == "input.image" || $field["type"] == "button.submit")
            {
                if (($submitname === false || $field["name"] === $submitname) && ($submitvalue === false || $field["value"] === $submitvalue))
                {
                    if ($submitname !== "")
                    {
                        if (!isset($fields[$field["name"]]))  $fields[$field["name"]] = array();
                        $fields[$field["name"]][] = $field["value"];
                    }
                    
                    if ($field["type"] == "input.image")
                    {
                        if (!isset($fields["x"]))  $fields["x"] = array();
                        $fields["x"][] = "1";
                        
                        if (!isset($fields["y"]))  $fields["y"] = array();
                        $fields["y"][] = "1";
                    }
                }
            }
            else if (($field["type"] != "input.radio" && $field["type"] != "input.checkbox") || $field["checked"])
            {
                if (!isset($fields[$field["name"]]))  $fields[$field["name"]] = array();
                $fields[$field["name"]][] = $field["value"];
            }
        }
        
        if ($method == "get")
        {
            $url = HTTP::ExtractURL($this->info["action"]);
            unset($url["query"]);
            $url["queryvars"] = $fields;
            $result = array(
                "url" => HTTP::CondenseURL($url),
                "options" => array()
            );
        }
        else
        {
            $result = array(
                "url" => $this->info["action"],
                "options" => array(
                    "postvars" => $fields,
                    "files" => $files
                )
            );
        }
        
        return $result;
    }
}