<?php

namespace App\Helpers;

class OpenDriveApi
{
    private $web;
    public $sessionid;
    public $access_token;
    public $folder_upload;
    
    const FOLDER_MODE_PRIVATE = 0;
    const FOLDER_MODE_PUBLIC = 1;
    const FOLDER_MODE_HIDDEN = 2;
    const URL_API = 'https://dev.opendrive.com/api/v1/';
    const URL_DL = 'https://download.mydrive.vn';
    
    public function __construct()
    {
        $this->web = new WebBrowser();
        $this->sessionid = false;
        $this->access_token = false;
        $this->folder_upload = false;
    }
    
    public function Login($username, $password, $partner_id = "")
    {
        $options = array(
            "username" => (string) $username,
            "passwd" => (string) $password,
            "version" => "10",
            "partner_id" => $partner_id
        );
        
        $result = $this->RunAPI("POST", "session/login.json", $options);
        if (!$result["success"]) {
            return $result;
        }
        
        $this->sessionid = $result["body"]["SessionID"];
        
        return $result;
    }
    
    public function Login2($username, $password, $partner_id = "")
    {
        $options = array(
            "username" => (string) $username,
            "password" => (string) $password,
            "client_id" => $partner_id,
            "grant_type" => 'password',
        );
        
        $result = $this->RunAPI("POST", "oauth2/grant.json", $options);
        if (!$result["success"]) {
            return $result;
        }
        
        $this->access_token = $result["body"]["access_token"];
        
        return $result;
    }
    
    public function GetFolderList($folderid = "0")
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        return $this->RunAPI("GET", "folder/list.json/" . $this->sessionid . "/" . $folderid);
    }
    
    public function GetObjectIDByName($folderid, $name)
    {
        $result = $this->GetFolderList($folderid);
        if (!$result["success"])  return $result;
        
        $info = false;
        
        if (isset($result["body"]["Folders"]))
        {
            foreach ($result["body"]["Folders"] as $info2)
            {
                if ($info2["Name"] === $name)  $info = $info2;
            }
        }
        
        if (isset($result["body"]["Files"]))
        {
            foreach ($result["body"]["Files"] as $info2)
            {
                if ($info2["Name"] === $name)  $info = $info2;
            }
        }
        
        return array("success" => true, "info" => $info);
    }
    
    public function CreateFolder($folderid, $name, $description = "", $mode = self::FOLDER_MODE_PRIVATE, $publicupload = false, $publicdisplay = false, $publicdownload = true)
    {
        if ($this->sessionid === false) {
            return [
                "success" => false,
                "error" => self::OD_Translate("Not logged into Drive."),
                "errorcode" => "no_login"
            ];
        }
        
        $options = array(
            "session_id" => $this->sessionid,
            "folder_name" => (string)$name,
            "folder_sub_parent" => (string)$folderid,
            "folder_is_public" => (string)$mode,
            "folder_public_upl" => (string)(int)$publicupload,
            "folder_public_display" => (string)(int)$publicdisplay,
            "folder_public_dnl" => (string)(int)$publicdownload,
            "folder_description" => (string)$description,
        );
    
        $result = $this->RunAPI("POST", "folder.json", $options);
        if (!$result["success"]) {
            return $result;
        }
    
        return $result["body"]["FolderID"];
    }
    
    public function CopyFolder($srcid, $destid)
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        $options = array(
            "session_id" => $this->sessionid,
            "folder_id" => (string)$srcid,
            "dst_folder_id" => (string)$destid,
            "move" => "false"
        );
        
        return $this->RunAPI("POST", "folder/move_copy.json", $options);
    }
    
    public function MoveFolder($srcid, $destid)
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        $options = array(
            "session_id" => $this->sessionid,
            "folder_id" => (string)$srcid,
            "dst_folder_id" => (string)$destid,
            "move" => "true"
        );
        
        return $this->RunAPI("POST", "folder/move_copy.json", $options);
    }
    
    public function RenameFolder($id, $newname)
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        $options = array(
            "session_id" => $this->sessionid,
            "folder_id" => (string)$id,
            "folder_name" => (string)$newname
        );
        
        return $this->RunAPI("POST", "folder/rename.json", $options);
    }
    
    public function RemoveTrashedFolder($id)
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        $options = array(
            "session_id" => $this->sessionid,
            "folder_id" => (string)$id
        );
        
        return $this->RunAPI("POST", "folder/remove.json", $options);
    }
    
    public function TrashFolder($id, $remove = false)
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        $options = array(
            "session_id" => $this->sessionid,
            "folder_id" => (string)$id
        );
        
        $result = $this->RunAPI("POST", "folder/trash.json", $options);
        if (!$result["success"])  return $result;
        
        if ($remove)  $result = $this->RemoveTrashedFolder($id);
        
        return $result;
    }
    
    public function RestoreTrashedFolder($id)
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        $options = array(
            "session_id" => $this->sessionid,
            "folder_id" => (string)$id
        );
        
        return $this->RunAPI("POST", "folder/restore.json", $options);
    }
    
    public function UploadFile($folderid, $filename, $dataorfp, $size = false, $fileid = false, $callback = false)
    {
        if ($this->sessionid === false) {
            return [
                "success" => false,
                "error" => self::OD_Translate("Not logged into Drive."),
                "errorcode" => "no_login"
            ];
        }
    
        $chunk = 2097152;
        $dataorfp = fopen($dataorfp, 'r');
        if ($size === false) {
            $size = (is_resource($dataorfp) ? self::RawFileSize($dataorfp) : strlen($dataorfp));
        }
        
        if (is_resource($dataorfp))
        {
            @fseek($dataorfp, 0, SEEK_SET);
            $data = @fread($dataorfp, $chunk);
        }
        else
        {
            if ($size > strlen($dataorfp))  $size = strlen($dataorfp);
            $data = substr($dataorfp, 0, $size);
            $dataorfp = "";
        }
        
        if ($fileid === false)
        {
            $options = array(
                "session_id" => $this->sessionid,
                "folder_id" => (string) $folderid,
                "file_name" => (string) $filename,
                "file_size" => (string) $size,
                "access_folder_id" => ""
            );
            
            $result = $this->RunAPI("POST", "upload/create_file.json", $options);
            if ($result["success"]) {
                $fileid = $result["body"]["FileId"];
            }
            else
            {
                if (!isset($result["info"]) || !isset($result["info"]["response"]) || $result["info"]["response"]["code"] != 409) {
                    return $result;
                }
                
                $result2 = $this->GetObjectIDByName($folderid, $filename);
                if (!$result2["success"]) {
                    return $result2;
                }
                if ($result2["info"] === false || !isset($result2["info"]["FileId"]))  return $result;
                
                $fileid = $result2["info"]["FileId"];
            }
        }
        
        $options = array(
            "session_id" => $this->sessionid,
            "file_id" => (string) $fileid,
            "file_size" => (string) $size
        );
        
        $result = $this->RunAPI("POST", "upload/open_file_upload.json", $options);
        if (!$result["success"]) {
            return $result;
        }
        
        $templocation = $result["body"]["TempLocation"];
        $pos = 0;
        while ($data !== false && $data !== "")
        {
            echo "Up Time: " . date("Y-m-d H:i:s") . "\n";
            $options = array(
                "postvars" => array(
                    "session_id" => $this->sessionid,
                    "file_id" => (string) $fileid,
                    "temp_location" => (string) $templocation,
                    "chunk_offset" => $pos,
                    "chunk_size" => strlen($data)
                ),
                "files" => array(
                    array(
                        "name" => "file_data",
                        "filename" => $filename,
                        "type" => "application/octet-stream",
                        "data" => $data
                    )
                )
            );
            
            $result = $this->RunAPI("POST", "upload/upload_file_chunk.json", $options, 200, false);
            if (!$result["success"]) {
                return $result;
            }
            
            if (is_callable($callback)) {
                call_user_func_array($callback, array($fileid, $pos, strlen($data), $size));
            }
            
            $pos += strlen($data);
            
            if (is_resource($dataorfp)) {
                $data = @fread($dataorfp, $chunk);
            }
            else {
                $data = "";
            }
            
            echo "End Time: " . date("Y-m-d H:i:s") . "\n";
        }
        
        $options = array(
            "session_id" => $this->sessionid,
            "file_id" => (string)$fileid,
            "temp_location" => (string)$templocation,
            "file_size" => (string)$size,
            "file_time" => (string)time(),
            "access_folder_id" => ""
        );
        
        $result = $this->RunAPI("POST", "upload/close_file_upload.json", $options);
        if (!$result["success"]) {
            return $result;
        }
        
        $result["file_id"] = $fileid;
        $result["file_size"] = $size;
        
        return $result;
    }
    
    public function DownloadFile__Internal($response, $body, &$opts)
    {
        fwrite($opts["fp"], $body);
        
        if (is_callable($opts["callback"])) {
            call_user_func_array($opts["callback"], array(&$opts));
        }
        
        return true;
    }
    
    // Callback option only used when destination is a file.
    public function DownloadFile($destfileorfp, $fileid, $callback = false)
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        if ($destfileorfp === false)  $options = array();
        else
        {
            $fp = (is_resource($destfileorfp) ? $destfileorfp : fopen($destfileorfp, "wb"));
            if ($fp === false)  return array("success" => false, "error" => self::OD_Translate("Invalid destination filename or handle."), "errorcode" => "invalid_filename_or_handle");
            
            $options = array(
                "read_body_callback" => array($this, "DownloadFile__Internal"),
                "read_body_callback_opts" => array("fp" => $fp, "fileid" => $fileid, "callback" => $callback)
            );
        }
        
        $result = $this->RunAPI("GET", "download/file.json/" . urlencode($fileid) . "?session_id=" . $this->sessionid, $options, 200, true, false);
        
        if ($destfileorfp !== false && !is_resource($destfileorfp))  fclose($fp);
        
        return $result;
    }
    
    public function GetThumbnail($file_id)
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        return $this->RunAPI("GET", "file/thumb.json/" . urlencode($file_id) . "?session_id=" . $this->sessionid, array(), 200, true, false);
    }
    
    public function CopyFileToFolder($srcfileid, $destfolderid, $overwrite = true)
    {
        if ($this->sessionid === false) {
            return [
                "success" => false,
                "error" => self::OD_Translate("Not logged into Drive."),
                "errorcode" => "no_login"
            ];
        }
        
        $options = array(
            "session_id" => $this->sessionid,
            "src_file_id" => (string)$srcfileid,
            "dst_folder_id" => (string)$destfolderid,
            "move" => "false",
            "overwrite_if_exists" => ($overwrite ? "true" : "false"),
            "src_access_folder_id" => "",
            "dst_access_folder_id" => "",
        );
        
        return $this->RunAPI("POST", "file/move_copy.json", $options);
    }
    
    public function MoveFileToFolder($srcfileid, $destfolderid, $overwrite = true)
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        $options = array(
            "session_id" => $this->sessionid,
            "src_file_id" => (string)$srcfileid,
            "dst_folder_id" => (string)$destfolderid,
            "move" => "true",
            "overwrite_if_exists" => ($overwrite ? "true" : "false"),
            "src_access_folder_id" => "",
            "dst_access_folder_id" => "",
        );
        
        return $this->RunAPI("POST", "file/move_copy.json", $options);
    }
    
    public function RenameFile($id, $newname)
    {
        if ($this->sessionid === false) {
            return [
                "success" => false,
                "error" => self::OD_Translate("Not logged into Drive."),
                "errorcode" => "no_login"
            ];
        }
        
        $options = array(
            "session_id" => $this->sessionid,
            "file_id" => (string)$id,
            "new_file_name" => (string)$newname,
            "access_folder_id" => ""
        );
        
        return $this->RunAPI("POST", "file/rename.json", $options);
    }
    
    public function RemoveTrashedFile($id)
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        return $this->RunAPI("DELETE", "file.json/" . $this->sessionid . "/" . $id);
    }
    
    public function TrashFile($id, $remove = false)
    {
        if ($this->sessionid === false)  return array("success" => false, "error" => self::OD_Translate("Not logged into Drive."), "errorcode" => "no_login");
        
        $options = array(
            "session_id" => $this->sessionid,
            "file_id" => (string)$id,
            "access_folder_id" => ""
        );
        
        $result = $this->RunAPI("POST", "file/trash.json", $options);
        if (!$result["success"])  return $result;
        
        if ($remove)  $result = $this->RemoveTrashedFile($id);
        
        return $result;
    }
    
    public function RestoreTrashedFile($id)
    {
        if ($this->sessionid === false) {
            return [
                "success" => false,
                "error" => self::OD_Translate("Not logged into Drive."),
                "errorcode" => "no_login"
            ];
        }
        
        $options = array(
            "session_id" => $this->sessionid,
            "file_id" => (string)$id
        );
        
        return $this->RunAPI("POST", "file/restore.json", $options);
    }
    
    public function GetFolderByPath($path) {
        if ($this->sessionid === false) {
            return [
                "success" => false,
                "error" => self::OD_Translate("Not logged into Drive."),
                "errorcode" => "no_login"
            ];
        }
    
        $options = array(
            "session_id" => $this->sessionid,
            "path" => (string) $path
        );
    
        $result = $this->RunAPI("POST", "folder/idbypath.json", $options);
        if (@$result['body']['FolderId']) {
            return $result['body']['FolderId'];
        }
        return false;
    }
    
    public function GetLinkDownload($fileid, $access_token = false) {
        $access_token = empty($access_token) ? $this->access_token : $access_token;
        if ($access_token) {
            return self::URL_DL . '/download/'. $access_token .'/' . $fileid;
        }
        
        return false;
    }
    
    public function GetLinkStream($fileid, $access_token = false) {
        $access_token = empty($access_token) ? $this->access_token : $access_token;
        if ($access_token) {
            return self::URL_DL . '/stream/'. $access_token .'/' . $fileid;
        }
    
        return false;
    }
    
    public static function RawFileSize($fp)
    {
        $pos = 0;
        $size = 1073741824;
        fseek($fp, 0, SEEK_SET);
        while ($size > 1)
        {
            fseek($fp, $size, SEEK_CUR);
            
            if (fgetc($fp) === false)
            {
                fseek($fp, -$size, SEEK_CUR);
                $size = (int)($size / 2);
            }
            else
            {
                fseek($fp, -1, SEEK_CUR);
                $pos += $size;
            }
        }
        
        while (fgetc($fp) !== false)  $pos++;
        
        return $pos;
    }
    
    private static function OD_Translate()
    {
        $args = func_get_args();
        if (!count($args))  return "";
        
        return call_user_func_array((defined("CS_TRANSLATE_FUNC") && function_exists(CS_TRANSLATE_FUNC) ? CS_TRANSLATE_FUNC : "sprintf"), $args);
    }
    
    private function RunAPI($method, $apipath, $options = array(), $expected = 200, $encodejson = true, $decodebody = true)
    {
        $options2 = array(
            "method" => $method
        );
        
        if ($method === "GET")
        {
            foreach ($options as $key => $val) {
                $options2[$key] = $val;
            }
        }
        else
        {
            if ($encodejson)
            {
                $options2["headers"] = [
                    "Content-Type" => "application/json",
                ];
                
                $options2["body"] = json_encode($options);
            }
            else
            {
                $options2 = array_merge($options2, $options);
            }
        }
        
        $retries = 3;
        do
        {
            $result = $this->web->Process(self::URL_API . $apipath, $options2);
            
            if (!$result["success"]) {
                sleep(1);
            }
            
            $retries--;
        } while (!$result["success"] && $retries > 0);
        
        if (!$result["success"]) {
            return $result;
        }
        
        if ($result["response"]["code"] != $expected) {
            return [
                "success" => false,
                "error" => self::OD_Translate("Expected a %d response from Drive.  Received '%s'.", $expected, $result["response"]["line"]),
                "errorcode" => "unexpected_drive_response",
                "info" => $result
            ];
        }
        
        if ($decodebody) {
            $result["body"] = json_decode($result["body"], true);
        }
        
        return $result;
    }
}