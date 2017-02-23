<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.
   $errors = [];
  if(is_post_request()){
    $first_name =  isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name =  isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    
  if( (is_blank($first_name)) || !has_length($first_name ,['min'=> 2 , 'max' => 255]) || (is_blank($last_name)) || !has_length($last_name ,['min'=> 2 , 'max' => 255]) 
    || (is_blank($email)) || !has_length($email,['max' => 255]) || !has_valid_email_format($email) || (is_blank($username)) || !has_length($username,['max' => 255, 'min'=>8])){

  if (is_blank($first_name)) {
    $errors[] = h("First name cannot be blank.");
    //echo "blank";
  } elseif (!has_length($first_name, ['min' => 2, 'max' => 255])) {
    $errors[] = h("First name must be between 2 and 255 characters.");
  }
  if (is_blank($last_name)) {
    $errors[] =h("Last name cannot be blank.");
  } elseif (!has_length($last_name, ['min' => 2, 'max' => 255])) {
    $errors[] = h("Last name must be between 2 and 255 characters.");
  } 
  if (is_blank($email)){
    $errors[] = h("Email cannot be blank");
  } elseif(!has_length($email,['max'=>255])){
    $errors[] = h("Email must be less than 255 characters.");
  } elseif(!has_valid_email_format($email)){
    $errors[] = h("Email must contains @");
  }
  if (is_blank($username)){
    $errors [] = h("Username cannot be blank.");
  }elseif (!has_length($username, ['max'=>255, 'min'=> 8])) {
    $errors[] = h("Username must be between 8 and 255 characters.");
  }

  }else{

    //if there were no errors, submit data to database
        $datetime = date("Y-m-d H:i:s");

      //Write SQL INSERT statement
        $sql = "INSERT INTO users VALUES('NULL','$first_name', '$last_name', '$email', '$username', '$datetime')";

      //For INSERT statments, $result is just true/false
        $result = db_query($db, $sql);
        if($result) {
          redirect_to("registration_success.php");
         db_close($db);
      // TODO redirect user to success page

          } else {
        // The SQL INSERT statement failed.
        // Just show the error, not the form
          echo db_error($db);
          db_close($db);
         exit;
      }

}
  
}
    

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

  <div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>
  
  <?php 
   // TODO: display any form errors here
  //// Hint: private/functions.php can help
    //print_r($errors);
    echo display_errors($errors);  
  ?>

  
  <!-- TODO: HTML form goes here -->
  <form id="register" action="register.php" method="POST"> 
    first_name : <input type= "text" id="first_name" name="first_name" value="<?php if (is_post_request()) echo($first_name);?>"><br>
    last_name : <input type = "text" id="last_name" name="last_name" value="<?php if (is_post_request()) echo($last_name);?>"><br>
    email : <input type="text" id="email" name="email" value="<?php if (is_post_request()) echo($email);?>"><br>
    username : <input type="text" id="username" name="username" value="<?php if (is_post_request()) echo($username);?>"><br>
    <input  name = "submit" type="submit" value="submit">
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
