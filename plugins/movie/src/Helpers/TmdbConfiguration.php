<?php

namespace Juzaweb\Movie\Helpers;

class TmdbConfiguration
{
    private $apikey = '';
    private $lang = 'en';
    private $timezone = 'Europe/London';
    private $adult = false;
    private $debug = false;
    private $appender;
    
    public function __construct($cnf)
    {
        // Check if config is given and use default if not
        // Note: There is no API Key inside the default conf
        $cnf['apikey'] = get_config('tmdb_api_key');
        $cnf['lang'] = $cnf['lang'] ?? 'en';
        $cnf['timezone'] = 'Europe/Berlin';
        $cnf['adult'] = false;
        $cnf['debug'] = false;
    
        // Data Return Configuration - Manipulate if you want to tune your results
        $cnf['appender']['movie'] = array('trailers', 'images', 'credits', 'translations', 'reviews');
        $cnf['appender']['tvshow'] = array('trailers', 'images', 'credits', 'translations', 'keywords');
        $cnf['appender']['season'] = array('trailers', 'images', 'credits', 'translations');
        $cnf['appender']['episode'] = array('trailers', 'images', 'credits', 'translations');
        $cnf['appender']['person'] = array('movie_credits', 'tv_credits', 'images');
        $cnf['appender']['collection'] = array('images');
        $cnf['appender']['company'] = array('movies');
        
        $this->setAPIKey($cnf['apikey']);
        $this->setLang($cnf['lang']);
        $this->setTimeZone('timezone');
        $this->setAdult($cnf['adult']);
        $this->setDebug($cnf['debug']);
        
        foreach ($cnf['appender'] as $type => $appender) {
            $this->setAppender($appender, $type);
        }
    }
    
    public function setAPIKey($apikey)
    {
        $this->apikey = $apikey;
    }
    
    public function setLang($lang)
    {
        $this->lang = $lang;
    }
    
    public function setTimeZone($timezone)
    {
        $this->timezone = $timezone;
    }
    
    public function setAdult($adult)
    {
        $this->adult = $adult;
    }
    
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }
    
    public function setAppender($appender, $type)
    {
        $this->appender[$type] = $appender;
    }
    
    public function getAPIKey()
    {
        return $this->apikey;
    }
    
    public function getLang()
    {
        return $this->lang;
    }
    
    public function getTimeZone()
    {
        return $this->timezone;
    }
    
    public function getAdult()
    {
        return ($this->adult) ? 'true' : 'false';
    }
    
    public function getDebug()
    {
        return $this->debug;
    }
    
    public function getAppender($type)
    {
        return $this->appender[$type];
    }
}
