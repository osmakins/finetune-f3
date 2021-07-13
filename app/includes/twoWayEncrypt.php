<?php

class twoWayEncrypt {
  private $privatekey;
  private $iv;
  private $ivSize; 
  private $method;
  function __construct($authKey)
  {
      //$this->method = "AES-256-GCM";
      $this->method = "AES-256-CBC";
      $this->ivSize = openssl_cipher_iv_length($this->method);
      $this->iv = openssl_random_pseudo_bytes($this->ivSize);
      $this->privatekey = hash('sha256', $authKey, TRUE);
      
  }
  function encrypt($input)
  {
      return base64_encode($this->iv.openssl_encrypt($input, $this->method, $this->privatekey, OPENSSL_RAW_DATA, $this->iv));
  }
  function decrypt($input)
  {
      return openssl_decrypt(substr(base64_decode($input), $this->ivSize), $this->method, $this->privatekey, OPENSSL_RAW_DATA, substr(base64_decode($input), 0, $this->ivSize));
  }
}