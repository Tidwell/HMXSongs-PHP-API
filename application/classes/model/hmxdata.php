<?php defined('SYSPATH') or die('No direct script access.');
class Model_HMXData extends Model {
  public function __construct() {
    
  }
  
  public function getAllSongs($recache = false) {
    if ($recache || !self::cacheExists()) {
      //get the raw JSON
      $url = 'http://rockband.com/services.php/music/all-songs.json';
      $curl_handle=curl_init();
      curl_setopt($curl_handle,CURLOPT_URL,$url);
      curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
      curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
      curl_setopt($curl_handle,CURLOPT_ENCODING , "gzip");
      $result = curl_exec($curl_handle);
      curl_close($curl_handle);
    
      //decode it
      
      //store the data
      self::storeCache($result);
    }
    else {
      $result = self::restoreCache();
    }
    $decoded_data = json_decode($result);
    return $decoded_data;
  }
  
  //checks if a cache file exists
  private function cacheExists() {
    $file = $this->getCacheFileName();
    if (file_exists($file)) {
      return true;
    }
    return false;
  }
  
  //stores data in a file by serializing the data
  private function storeCache($data) {
    $file = $this->getCacheFileName();
    $fp = fopen($file, 'w')  or die("can't open file");
    fwrite($fp, $data);
    fclose($fp);
	}
  
  //reads the serialized data from a file, unserializes it, and returns
  private function restoreCache() {
    $file = $this->getCacheFileName();
    if (file_exists($file)) {
      $handle = fopen($file, "r");
      $data = fread($handle, filesize($file));
      return $data;
    }
    return false;
  }
  
  //gets the name of the function that called the function that called this function (lols)
  private function getCacheFileName() {
    $bt = debug_backtrace();
    return APPPATH.'cache/'.$bt[2]['function'].date('mdy').'.txt';   
  }
}