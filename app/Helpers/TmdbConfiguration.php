<?php

namespace App\Helpers;

class TmdbConfiguration
{
    private $apikey = '';
    private $lang = 'en';
    private $timezone = 'Europe/London';
    private $adult = false;
    private $debug = false;
    private $appender;
    
    public function __construct($cnf) {
        // Check if config is given and use default if not
        // Note: There is no API Key inside the default conf
        if(!isset($cnf)) {
            require_once( dirname(__FILE__) . "/../../../configuration/default.php");
        }
        
        $this->setAPIKey($cnf['apikey']);
        $this->setLang($cnf['lang']);
        $this->setTimeZone('timezone');
        $this->setAdult($cnf['adult']);
        $this->setDebug($cnf['debug']);
        
        foreach($cnf['appender'] as $type => $appender) {
            $this->setAppender($appender, $type);
        }
    }
    
    public function setAPIKey($apikey){
        $this->apikey = $apikey;
    }
    
    public function setLang($lang){
        $this->lang = $lang;
    }
    
    public function setTimeZone($timezone){
        $this->timezone = $timezone;
    }
    
    public function setAdult($adult){
        $this->adult = $adult;
    }
    
    public function setDebug($debug){
        $this->debug = $debug;
    }
    
    public function setAppender($appender, $type){
        $this->appender[$type] = $appender;
    }
    
    public function getAPIKey(){
        return $this->apikey;
    }
    
    public function getLang(){
        return $this->lang;
    }
    
    public function getTimeZone(){
        return $this->timezone;
    }
    
    public function getAdult(){
        return ($this->adult) ? 'true' : 'false';
    }
    
    public function getDebug(){
        return $this->debug;
    }
    
    public function getAppender($type){
        return $this->appender[$type];
    }
}