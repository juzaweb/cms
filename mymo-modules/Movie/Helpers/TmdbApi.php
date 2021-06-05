<?php

namespace Modules\Movie\Helpers;

class TmdbApi
{
    const _API_URL_ = "http://api.themoviedb.org/3/";
    const VERSION = '0.5';
    private $config;
    private $_apiconfiguration;
    
    public function __construct($config = null) {
        
        $this->setConfig($config);
        
        if (! $this->_loadConfig()){
            echo _("Unable to read configuration, verify that the API key is valid");
            exit;
        }
    }
    
    private function setConfig($config) {
        $this->config = new TmdbConfiguration($config);
    }
    
    private function getConfig() {
        return $this->config;
    }
    
    public function setAPIKey($apikey) {
        $this->getConfig()->setAPIKey($apikey);
    }

    public function setLang($lang = 'en') {
        $this->getConfig()->setLang($lang);
    }
    
    public function getLang() {
        return $this->getConfig()->getLang();
    }

    public function setTimeZone($timezone = 'Europe/London') {
        $this->getConfig()->setTimeZone($timezone);
    }
    
    public function getTimeZone() {
        return $this->getConfig()->getTimeZone();
    }

    public function setAdult($adult = false) {
        $this->getConfig()->setAdult($adult);
    }
    
    public function getAdult() {
        return $this->getConfig()->getAdult();
    }
    
    public function setDebug($debug = false) {
        $this->getConfig()->setDebug($debug);
    }
    
    public function getDebug() {
        return $this->getConfig()->getDebug();
    }
    
    private function _loadConfig() {
        $this->_apiconfiguration = new TmdbConfiguration($this->_call('configuration'));
        return ! empty($this->_apiconfiguration);
    }
    
    public function getAPIConfig() {
        return $this->_apiconfiguration;
    }
    
    public function getImageURL($size = 'original') {
        return $this->_apiconfiguration->getImageBaseURL().$size;
    }
    
    public function getDiscoverMovies($page = 1) {
        $movies = [];
        $result = $this->_call('discover/movie', '&page='. $page);
        foreach($result['results'] as $data){
            $movies[] = $data;
        }
        
        return $movies;
    }
    
    public function getDiscoverTVShows($page = 1) {
        $tvShows = [];
        $result = $this->_call('discover/tv', '&page='. $page);
        foreach($result['results'] as $data){
            $tvShows[] = $data;
        }
        
        return $tvShows;
    }
    
    public function getDiscoverMovie($page = 1) {
        $movies = array();
        $result = $this->_call('discover/movie', 'page='. $page);
        foreach($result['results'] as $data){
            $movies[] = $data;
        }
        return $movies;
    }
    
    public function getLatestMovie() {
        return $this->_call('movie/latest');
    }
    
    public function getNowPlayingMovies($page = 1) {
        $movies = array();
        $result = $this->_call('movie/now_playing', '&page='. $page);
        foreach ($result['results'] as $data){
            $movies[] = $data;
        }
        return $movies;
    }
    
    public function getPopularMovies($page = 1) {
        
        $movies = array();
        
        $result = $this->_call('movie/popular', '&page='. $page);
        
        foreach($result['results'] as $data){
            $movies[] = $data;
        }
        
        return $movies;
    }
    
    public function getTopRatedMovies($page = 1) {
        
        $movies = array();
        
        $result = $this->_call('movie/top_rated', '&page='. $page);
        
        foreach($result['results'] as $data){
            $movies[] = $data;
        }
        
        return $movies;
    }
    
    public function getUpcomingMovies($page = 1) {
        
        $movies = array();
        
        $result = $this->_call('movie/upcoming', '&page='. $page);
        
        foreach($result['results'] as $data){
            $movies[] = $data;
        }
        
        return $movies;
    }
    
    public function getLatestTVShow() {
        return $this->_call('tv/latest');
    }
    
    public function getOnTheAirTVShows($page = 1) {
        
        $tvShows = array();
        
        $result = $this->_call('tv/on_the_air', '&page='. $page);
        
        foreach($result['results'] as $data){
            $tvShows[] = $data;
        }
        
        return $tvShows;
    }

    public function getAiringTodayTVShows($page = 1, $timeZone = null) {
        $timeZone = (isset($timeZone)) ? $timeZone : $this->getConfig()->getTimeZone();
        $tvShows = array();
        
        $result = $this->_call('tv/airing_today', '&page='. $page);
        
        foreach($result['results'] as $data){
            $tvShows[] = $data;
        }
        
        return $tvShows;
    }

    public function getTopRatedTVShows($page = 1) {
        $tvShows = [];
        $result = $this->_call('tv/top_rated', '&page='. $page);
        foreach($result['results'] as $data){
            $tvShows[] = $data;
        }
        return $tvShows;
    }

    public function getPopularTVShows($page = 1) {
        $tvShows = [];
        $result = $this->_call('tv/popular', '&page='. $page);
        foreach($result['results'] as $data){
            $tvShows[] = $data;
        }
        return $tvShows;
    }

    public function getLatestPerson() {
        return $this->_call('person/latest');
    }

    public function getPopularPersons($page = 1) {
        $persons = array();
        
        $result = $this->_call('person/popular', '&page='. $page);
        
        foreach($result['results'] as $data){
            $persons[] = $data;
        }
        
        return $persons;
    }

    private function _call($action, $appendToResponse = '') {
    
        $url = self::_API_URL_ . $action . '?api_key=' . $this->getConfig()->getAPIKey() . '&language=' . $this->getConfig()->getLang() . '&append_to_response=' . implode(',', (array)$appendToResponse) . '&include_adult=' . $this->getConfig()->getAdult();
        
        if ($this->getConfig()->getDebug()) {
            echo '<pre><a href="' . $url . '">check request</a></pre>';
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        
        $results = curl_exec($ch);
        
        curl_close($ch);
        
        return (array) json_decode(($results), true);
    }

    public function getMovie($idMovie, $appendToResponse = null) {
        $appendToResponse = (isset($appendToResponse)) ? $appendToResponse : $this->getConfig()->getAppender('movie');
        
        return $this->_call('movie/' . $idMovie, $appendToResponse);
    }
    
    public function getTVShow($idTVShow, $appendToResponse = null) {
        $appendToResponse = (isset($appendToResponse)) ? $appendToResponse : $this->getConfig()->getAppender('tvshow');
        
        return $this->_call('tv/' . $idTVShow, $appendToResponse);
    }
    
    public function getPerson($idPerson, $appendToResponse = null) {
        $appendToResponse = (isset($appendToResponse)) ? $appendToResponse : $this->getConfig()->getAppender('person');
        
        return $this->_call('person/' . $idPerson, $appendToResponse);
    }

    public function getCollection($idCollection, $appendToResponse = null) {
        $appendToResponse = (isset($appendToResponse)) ? $appendToResponse : $this->getConfig()->getAppender('collection');
        
        return $this->_call('collection/' . $idCollection, $appendToResponse);
    }

    public function getCompany($idCompany, $appendToResponse = null) {
        $appendToResponse = (isset($appendToResponse)) ? $appendToResponse : $this->getConfig()->getAppender('company');
        
        return $this->_call('company/' . $idCompany, $appendToResponse);
    }

    public function multiSearch($searchQuery)
    {
        $searchResults = array(
            'movies' => array(),
            'tv_shows' => array(),
            'persons' => array(),
        );
        
        $result = $this->_call('search/multi', '&query=' . urlencode($searchQuery));
        
        if(!array_key_exists('results', $result)){
            return $searchResults;
        }
        
        foreach ($result['results'] as $data) {
            if ($data['media_type'] === Movie::MEDIA_TYPE_MOVIE) {
                $searchResults[Movie::MEDIA_TYPE_MOVIE][] = $data;
            } elseif ($data['media_type']  === TVShow::MEDIA_TYPE_TV) {
                $searchResults[TVShow::MEDIA_TYPE_TV][] = new TvShow($data);
            } elseif ($data['media_type']  === Person::MEDIA_TYPE_PERSON) {
                $searchResults[Person::MEDIA_TYPE_PERSON][] = new Person($data);
            }
        }
        
        return $searchResults;
    }

    public function searchMovie($movieTitle){
        
        $movies = array();
        
        $result = $this->_call('search/movie', '&query='. urlencode($movieTitle));
        
        foreach($result['results'] as $data){
            $movies[] = $data;
        }
        
        return $movies;
    }

    public function searchTVShow($tvShowTitle){
        
        $tvShows = array();
        
        $result = $this->_call('search/tv', '&query='. urlencode($tvShowTitle));
        
        foreach($result['results'] as $data){
            $tvShows[] = $data;
        }
        
        return $tvShows;
    }

    public function searchPerson($personName){
        
        $persons = array();
        
        $result = $this->_call('search/person', '&query='. urlencode($personName));
        
        foreach($result['results'] as $data){
            $persons[] = $data;
        }
        
        return $persons;
    }

    public function searchCollection($collectionName){
        
        $collections = array();
        
        $result = $this->_call('search/collection', '&query='. urlencode($collectionName));
        
        foreach($result['results'] as $data){
            $collections[] = $data;
        }
        
        return $collections;
    }

    public function searchCompany($companyName){
        
        $companies = array();
        
        $result = $this->_call('search/company', '&query='. urlencode($companyName));
        
        foreach($result['results'] as $data){
            $companies[] = $data;
        }
        
        return $companies;
    }

    public function find($id, $external_source = 'imdb_id'){
        
        $found = array();
        
        $result = $this->_call('find/'.$id, '&external_source='. urlencode($external_source));
        
        foreach($result['movie_results'] as $data){
            $found['movies'][] = $data;
        }
        foreach($result['person_results'] as $data){
            $found['persons'][] = $data;
        }
        foreach($result['tv_results'] as $data){
            $found['tvshows'][] = $data;
        }
        foreach($result['tv_season_results'] as $data){
            $found['seasons'][] = $data;
        }
        foreach($result['tv_episode_results'] as $data){
            $found['episodes'][] = $data;
        }
        
        return $found;
    }

    public function getTimezones() {
        return $this->_call('timezones/list');
    }

    public function getJobs() {
        return $this->_call('job/list');
    }

    public function getMovieGenres() {
        $genres = [];
        $result = $this->_call('genre/movie/list');
        foreach($result['genres'] as $data){
            $genres[] = $data;
        }
        
        return $genres;
    }

    public function getTVGenres() {
        $genres = [];
        $result = $this->_call('genre/tv/list');
        foreach($result['genres'] as $data){
            $genres[] = $data;
        }
        return $genres;
    }

    public function getMoviesByGenre($idGenre, $page = 1) {
        
        $movies = [];
        $result = $this->_call('genre/'. $idGenre .'/movies', '&page='. $page);
        foreach($result['results'] as $data){
            $movies[] = $data;
        }
        
        return $movies;
    }
}