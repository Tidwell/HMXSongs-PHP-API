<?php defined('SYSPATH') or die('No direct script access.');
class Model_HMXData extends Model {
  public function __construct() {
    
  }
  
  public function getAllSongs() {
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
    $decoded_data = json_decode($result);
    
    return $decoded_data;
  }
  
  public function storeCache($filename, $data) {
    $fname = '/application/cache'.$filename.'.txt';
    if (file_exists($fname)) {
      $handle = fopen($fname, "r");
      $data = fread($handle, filesize($fname));
    }
  }
}