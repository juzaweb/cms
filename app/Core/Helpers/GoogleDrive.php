<?php

namespace App\Core\Helpers;

class GoogleDrive {
    private $cache_path;
    
    public function __construct() {
        $this->cache_path = \Storage::disk('local')->path('_cache');
    }
    
    public function cache_path($id){
		if (!file_exists($this->cache_path)) {
			mkdir($this->cache_path, 0777);
		}
		
		if (strlen($id) == 33) {
			return $this->cache_path . '/' . hash('sha256', $id, false);
		} else {
			return $this->cache_path . '/' . $id;
		}
	}
	
	public function read_data($id){
		$fpath = $this->cache_path($id);
		if ($fhandle = @fopen($fpath,'r')) {
			$content = fread($fhandle,filesize($fpath));
			fclose($fhandle);
			return json_decode($content,true);
		} else {
			return null;
		}
	}
	
	public function write_data($id){
		$fpath = $this->cache_path($id);
		if ($fhandle = fopen($fpath,'w')) {
			
			$sources_list = array();
			$ar_list = array();
			
			// Check whenever file was available or not
			$ch = curl_init('https://drive.google.com/get_video_info?docid=' . $id);
			curl_setopt_array($ch,array(
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_RETURNTRANSFER => 1
			));
			$x = curl_exec($ch);
			parse_str($x,$x);
			if ($x['status'] == 'fail') {
				return null;
			}
			curl_close($ch);
			
			// Fetch Google Drive File
			$ch = curl_init('https://drive.google.com/get_video_info?docid=' . $id);
			curl_setopt_array($ch,array(
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HEADER => 1
			));
			$result = curl_exec($ch);
			curl_close($ch);
			
			// Get Cookies
			preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
			$cookies = array();
			foreach($matches[1] as $item) {
				parse_str($item, $cookie);
				$cookies = array_merge($cookies, $cookie);
			}
			
			// Parse Resolution
			parse_str($result,$data);
			$sources = explode(',',$data['fmt_stream_map']);
			
			foreach($sources as $source){
				
				switch ((int)substr($source, 0, 2)) {
					case 18:
						$resolution = '360p';
						break;
					case 59:
						$resolution = '480p';
						break;
					case 22:
						$resolution = '720p';
						break;
					case 37:
						$resolution = '1080p';
						break;
				}
				
				$x = substr($source, strpos($source, "|") + 1);
				
				// Get Content-Length of sources
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => substr($source, strpos($source, "|") + 1),
					CURLOPT_HEADER => true,
					CURLOPT_CONNECTTIMEOUT => 0,
					CURLOPT_TIMEOUT => 1000,
					CURLOPT_FRESH_CONNECT => true,
					CURLOPT_SSL_VERIFYPEER => 0,
					CURLOPT_NOBODY => true,
					CURLOPT_VERBOSE => 1,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTPHEADER => array(
						'Connection: keep-alive',
						'Cookie: DRIVE_STREAM=' . $cookies['DRIVE_STREAM']
					)
				));
				
				curl_exec($curl);
				$content_length = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
				curl_close($curl);
				
				array_push($sources_list, array(
						'resolution' => $resolution,
						'src' => $x,
						'content-length' => $content_length)
				);
				
				array_push($ar_list, $resolution);
				
			}
			
			// Get thumbnail Image
			$ch = curl_init('https://drive.google.com/thumbnail?authuser=0&sz=w9999&id=' . $id);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			if (preg_match('~Location: (.*)~i', $result, $match)) {
				$thumbnail = trim($match[1]);
			} else {
				$thumbnail = '';
			}
			
			// Write to file
			fwrite($fhandle, json_encode(array(
				'thumbnail' => $thumbnail,
				'cookies' => $cookies,
				'sources' => $sources_list,
				'id' => $id,
			)));
			fclose($fhandle);
			
			$qualities = [];
			if (in_array('1080p', $ar_list)) {
				$qualities[] = '1080p';
			}
			
			if (in_array('720p', $ar_list)) {
				$qualities[] = '720p';
			}
			
			if (in_array('480p', $ar_list)) {
				$qualities[] = '480p';
			}
			
			if (in_array('360p', $ar_list)) {
				$qualities[] = '360p';
			}
			
			return (object) [
				'stream_id' => hash('sha256', $id, false),
				'qualities' => $qualities,
			];
			
		} else {
			return null;
		}
	}
	
	public function fetch_video(array $data) {
		
		$content_length = $data['content-length'];
		$headers = array(
			'Connection: keep-alive',
			'Cookie: DRIVE_STREAM=' . $data['cookie']['DRIVE_STREAM']
		);
		
		if (isset($_SERVER['HTTP_RANGE'])) {
			
			$http = 1;
			preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $range);
			$initial = intval($range[1]);
			$final = $content_length - $initial - 1;
			array_push($headers,'Range: bytes=' . $initial . '-' . ($initial + $final));
			
		} else {
			$http = 0;
		}
		
		if ($http == 1) {
			
			header('HTTP/1.1 206 Partial Content');
			header('Accept-Ranges: bytes');
			header('Content-Range: bytes ' . $initial . '-' . ($initial + $final) . '/' . $data['content-length']);
			
		} else {
			
			header('Accept-Ranges: bytes');
			
		}
		
		$ch = curl_init();
		
		curl_setopt_array($ch, array(
			CURLOPT_URL => $data['src'],
			CURLOPT_CONNECTTIMEOUT => 0,
			CURLOPT_TIMEOUT => 1000,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_FRESH_CONNECT => true,
			CURLOPT_HTTPHEADER => $headers
		));
		
		curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($curl, $body) {
			echo $body;
			return strlen($body);
		});
		
		header('Content-Type: video/mp4');
		header('Content-length: ' . $content_length);
		
		curl_exec($ch);
	}
	
	public function stream($stream_id, $quality = '360p') {
		$fdata = $this->read_data($stream_id);
		
		if ($fdata !== null) {
			
			if (time()-filemtime($this->cache_path($stream_id)) > 3 * 3600) {
				
				$fres = $this->write_data($fdata['id']);
				
				if ($fres !== null) {
					$fdata = $this->read_data($fres['hash']);
					
					if ($quality == 'thumbnail') {
						
						header('Location:' . $fdata['thumbnail']);
						
					} else {
						
						foreach($fdata['sources'] as $x) {
							if ($x['resolution'] == $quality) {
								$this->fetch_video(array(
									'content-length' => $x['content-length'],
									'src' => $x['src'],
									'cookie' => $fdata['cookies']
								));
								break;
							}
						}
						
					}
				} else {
					die('Failed write data');
				}
			}
			else {
				
				if (is_array($fdata)) {
					
					if ($quality == 'thumbnail') {
						
						header('Location:' . $fdata['thumbnail']);
						
					} else {
						
						foreach($fdata['sources'] as $x) {
							if ($x['resolution'] == $quality) {
								$this->fetch_video(array(
									'content-length' => $x['content-length'],
									'src' => $x['src'],
									'cookie' => $fdata['cookies']
								));
								break;
							}
						}
					}
					
				} else {
					unlink($this->cache_path($stream_id));
					die('File was corrupt, please re-generate file.');
				}
			}
			
		} else {
			
			die('Invalid file.');
			
		}
		
	}
	
	public static function link_stream($gdrive_id) {
		$gdrive = new GoogleDrive();
		$fdata = $gdrive->read_data($gdrive_id);
		
		if ($fdata !== null) {
			
			header('Content-Type: application/json');
			$ar_list = array();
			
			foreach($fdata['sources'] as $x) {
				array_push($ar_list, $x['resolution']);
			}
			
			$qualities = [];
			if (in_array('1080p', $ar_list)) {
				$qualities[] = '1080p';
			}
			
			if (in_array('720p', $ar_list)) {
				$qualities[] = '720p';
			}
			
			if (in_array('480p', $ar_list)) {
				$qualities[] = '480p';
			}
			
			if (in_array('360p', $ar_list)) {
				$qualities[] = '360p';
			}
			
			if (empty($qualities)) {
				$qualities[] = '360p';
			}
			
			return (object) [
				'stream_id' => hash('sha256', $gdrive_id, false),
				'qualities' => $qualities,
			];
			
		} else {
			$fres = $gdrive->write_data($gdrive_id);
			if ($fres !== null) {
				return $fres;
			} else {
				return false;
			}
		}
	}
}