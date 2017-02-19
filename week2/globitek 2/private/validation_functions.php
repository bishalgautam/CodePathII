<?php

  // is_blank('abcd')
  function is_blank($value='') {
    return !isset($value) || trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    $length = strlen($value);
    if(isset($options['max']) && ($length > $options['max'])) {
      return false;
    } elseif(isset($options['min']) && ($length < $options['min'])) {
      return false;
    } elseif(isset($options['exact']) && ($length != $options['exact'])) {
      return false;
    } else {
      return true;
    }
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    // Function can be improved later to check for
    // more than just '@'.
    return strpos($value, '@') !== false;

  }
  
// check for valid phone numbers
  function has_valid_phoneNumber($value){
    if(preg_match('/\A[0-9\s\-\(\)]+\Z/', $value) == 1){
       return true;
    }
      
    return false;
  }

// My custom validations...

// has valid email address 
  function has_valid_email($value){
    if(filter_var($value, FILTER_VALIDATE_EMAIL))
        return true;
    return false;
  }

// check for numbers.
  function has_valid_number_format($value){
    if(preg_match('/\A[0-9]+\Z/', $value) == 1){
       return true;
    }   
    return false;
  }

  // has valid name (Man Mohan); contiains alphabets and spaces
  function has_valid_names($value){
    if(preg_match('/\A[A-Za-z\s]+\Z/', $value)){
        return true;
    }
    return false;
  }

// has valid username starting with an alphabet
  function has_valid_username($value){
    if (preg_match('/\A[A-Za-z][A-Za-z0-9\_]+\Z/', $value) == 1)
      return true;
    return false;
  }

// has valid 10 digits phone number
 function has_valid_phone_number_length($value){
  if (strlen(preg_replace('/[^0-9]/','', trim($value))) == 10) 
      return true;
  return false; 
 }

 //has valid code 'KT'

 function has_valid_code($value){
    if(preg_match('/\A[A-Z]+\Z/', $value)){
        return true;
    }
    return false;
 }

?>
