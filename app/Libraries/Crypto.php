<?php namespace App\Libraries;
 
const METHOD = "AES-256-CBC";
const KEY = 'crestpent1p8';
const IV = 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282';

class Crypto
{
  public static function encrypt($string)
  {
    $output = false;
    // hash
    $key = hash('sha256', KEY);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', IV), 0, 16);
    $output = base64_encode(openssl_encrypt($string, METHOD, $key, 0, $iv));

    return $output;
  }

  public static function decrypt($string)
  {
    $output = false;
    // hash
    $key = hash('sha256', KEY);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', IV), 0, 16);
    $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);

    return $output;
  }

}