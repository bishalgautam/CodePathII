<?php

// Symmetric Encryption

// Cipher method to use for symmetric encryption
const CIPHER_METHOD = 'AES-256-CBC';

function key_encrypt($string, $key, $cipher_method=CIPHER_METHOD) {
  
 // const CIPHER_METHOD = 'AES-256-CBC';
  $plaintext = $string;

  // Needs a key of length 32 (256-bit)
  $key = str_pad($key, 32, '*');

  // Create an initialization vector which randomizes the
  // initial settings of the algorithm, making it harder to decrypt.
  // Start by finding the correct size of an initialization vector 
  // for this cipher method.
  $iv_length = openssl_cipher_iv_length(CIPHER_METHOD);
  $iv = openssl_random_pseudo_bytes($iv_length);

  // Encrypt
  $encrypted = openssl_encrypt($plaintext, CIPHER_METHOD, $key, OPENSSL_RAW_DATA, $iv);

  // Return $iv at front of string, need it for decoding
  $message = $iv . $encrypted;
  
  // Encode just ensures encrypted characters are viewable/savable
   return base64_encode($message);
 // return "D4RK SH4D0W RUL3Z";
}

function key_decrypt($string, $key, $cipher_method=CIPHER_METHOD) {
  
  //const CIPHER_METHOD = 'AES-256-CBC';

  $message = $string;

  // Needs a key of length 32 (256-bit)
  $key = str_pad($key, 32, '*');

  // Base64 decode before decrypting
  $iv_with_ciphertext = base64_decode($message);
  
  // Separate initialization vector and encrypted string
  $iv_length = openssl_cipher_iv_length(CIPHER_METHOD);
  $iv = substr($iv_with_ciphertext, 0, $iv_length);

  $ciphertext = substr($iv_with_ciphertext, $iv_length);

  // Decrypt
  $plaintext = openssl_decrypt($ciphertext, CIPHER_METHOD, $key, OPENSSL_RAW_DATA, $iv);

  return $plaintext;
  // This is a secret.
  
  //return "PWNED YOU!";
}


// Asymmetric Encryption / Public-Key Cryptography

// Cipher configuration to use for asymmetric encryption
const PUBLIC_KEY_CONFIG = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

function generate_keys($config=PUBLIC_KEY_CONFIG) {
  
  $resource = openssl_pkey_new(PUBLIC_KEY_CONFIG);

  // Extract private key from the pair
  openssl_pkey_export($resource, $private_key);

  // Extract public key from the pair
  $key_details = openssl_pkey_get_details($resource);
  $public_key = $key_details["key"];

  // $private_key = 'Ha ha!';
  // $public_key = 'Ho ho!';

  return array('private' => $private_key, 'public' => $public_key);
}

function pkey_encrypt($string, $public_key) {

  $plaintext = $string;

  openssl_public_encrypt($plaintext, $encrypted, $public_key);

  // Use base64_encode to make contents viewable/sharable
  $message = base64_encode($encrypted);
  
  return $message;
}

function pkey_decrypt($string, $private_key) {
  
  // Decode from base64 to get raw data
  $ciphertext = base64_decode($string);
  
  openssl_private_decrypt($ciphertext, $decrypted, $private_key);

  return  $decrypted;
}


// Digital signatures using public/private keys

function create_signature($data, $private_key) {

  openssl_sign($data, $raw_signature, $private_key);
  
  // Use base64_encode to make contents viewable/sharable
  $signature = base64_encode($raw_signature);
  return $signature;
}

function verify_signature($data, $signature, $public_key) {
  // Vigenère
  $raw_signature = base64_decode($signature);
  $result = openssl_verify($data, $raw_signature, $public_key);
  //echo $result;
  // returns 1 if data and signature match
  
  // $modified_data = $data . "extra content";
  // $result = openssl_verify($modified_data, $signature, $public_key);
  // echo $result;
  // return 'RK, pym oays onicvr. Iuw bkzhvbw uedf pke conll rt ZV nzxbhz.';
  return $result;
}

?>
