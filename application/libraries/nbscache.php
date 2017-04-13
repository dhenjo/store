<?php
class Nbscache
{
  private $cacheDir = 'application/cache';
//  private $expiryInterval = 2592000; //30*24*60*60;

  public function setCacheDir($val) {  $this->cacheDir = $val; }
//  public function setExpiryInterval($val) {  $this->expiryInterval = $val; }

  public function exists($key)
  {
    $filename_cache = $this->cacheDir . '/' . $key . '.php'; //Cache filename
//    $filename_info = $this->cacheDir . '/' . $key . '.info'; //Cache info

//    if (file_exists($filename_cache) && file_exists($filename_info))
    if (file_exists($filename_cache))
    {
//      $cache_time = file_get_contents ($filename_info) + (int)$this->expiryInterval; //Last update time of the cache file
//      $time = time(); //Current Time

//      $expiry_time = (int)$time; //Expiry time for the cache

//      if ((int)$cache_time >= (int)$expiry_time) //Compare last updated and current time
//      {
        return true;
//      }
    }

    return false;
  }

  public function get_explode($key, $param){
    $hasil = $this->get($key);
    //print_r($hasil);
    return explode("[".$param."]", $hasil);
  }

  public function get($key)
  {
    $filename_cache = $this->cacheDir . '/' . $key . '.php'; //Cache filename
//    $filename_info = $this->cacheDir . '/' . $key . '.info'; //Cache info
    if (file_exists($filename_cache))
//    if (file_exists($filename_cache) && file_exists($filename_info))
    {
//      $cache_time = file_get_contents ($filename_info) + (int)$this->expiryInterval; //Last update time of the cache file
//      $time = time(); //Current Time

//      $expiry_time = (int)$time; //Expiry time for the cache

//      if ((int)$cache_time >= (int)$expiry_time) //Compare last updated and current time
//      {
        return file_get_contents ($filename_cache);   //Get contents from file
//      }
    }

    return null;
  }
  
  public function get_self($key)
  {
    $data = $this->get($key);
    $return = explode('['.IPREMOTE.']', $this->get($key));
    return $return[1];
  }


  public function clear($key, $type, $privilege = 0, $content = ""){
    if($privilege == 0){
      $data = explode("[{$type}]", $this->get($key));
      $data_baru = $data[0].'['.$type.']['.$type.']'.$data[2];
      if (! file_exists($this->cacheDir))
        mkdir($this->cacheDir);

      $filename_cache = $this->cacheDir . '/' . $key . '.php'; //Cache filename

      file_put_contents ($filename_cache ,  $data_baru); // save the content
    }
    else{
      $data = explode("[{$type}]", $this->get($key));
      $data[1] = str_replace(";".$privilege."|".$content.";", "", $data[1]);
      $data_baru = $data[0].'['.$type.']'.$data[1].'['.$type.']'.$data[2];
      if (! file_exists($this->cacheDir))
        mkdir($this->cacheDir);

      $filename_cache = $this->cacheDir . '/' . $key . '.php'; //Cache filename

      file_put_contents ($filename_cache ,  $data_baru); // save the content
    }
  }
  public function put($key, $type, $privilege, $content)
  {
    $data = explode("[{$type}]", $this->get($key));
    if(strpos($data[1], ";".$privilege."|".$content.";") === FALSE){
//    if(strpos($this->get($key), $privilege."|".$content.";") === FALSE){
      $data[1] .= ";".$privilege."|".$content.";";
      $data_baru = $data[0].'['.$type.']'.$data[1].'['.$type.']'.$data[2];
      if (! file_exists($this->cacheDir))
        mkdir($this->cacheDir);

      $filename_cache = $this->cacheDir . '/' . $key . '.php'; //Cache filename

      file_put_contents ($filename_cache ,  $data_baru); // save the content
    }
//    else{
//      print $this->get($key)."<br>";
//      print $privilege."|".$content.";";
//      die('sasa');
//    }
  }
  public function put_tunggal($key, $privilege, $content)
  {
      $data = explode("[{$privilege}]", $this->get($key));
      $data[1] = $content;
      $data_baru = $data[0].'['.$privilege.']'.$data[1].'['.$privilege.']'.$data[2];
      if (! file_exists($this->cacheDir))
        mkdir($this->cacheDir);

      $filename_cache = $this->cacheDir . '/' . $key . '.php'; //Cache filename

      file_put_contents ($filename_cache ,  $data_baru); // save the content
  }
  public function get_olahan($file, $id_privilege, $privilege, $type){
//    print $id_privilege."|".$privilege.";";die;
    $data = explode("[{$type}]", $this->get($file));
    return strpos($data[1], ";".$id_privilege."|".$privilege.";");
  }
}
?>
