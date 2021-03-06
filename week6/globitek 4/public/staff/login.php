<?php
//ini_set('display_errors',1); 
require_once('../../private/initialize.php');

// Until we learn about encryption, we will use an unencrypted
// master password as a stand-in. It should go without saying
// that this should *never* be done in real production code.
$master_password = 'secret';

// Set default values for all variables the page needs.
$errors = array();
$username = '';
$attempted_password = '';

if(is_post_request() && request_is_same_domain()) {
  ensure_csrf_token_valid();

  // Confirm that values are present before accessing them.
  if(isset($_POST['username'])) { $username = $_POST['username']; }
  if(isset($_POST['password'])) { $attempted_password = $_POST['password']; }

  // Validations
  if (is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if (is_blank($attempted_password)) {
    $errors[] = "Password cannot be blank.";
  }
  
  $time_elapsed = throttle_time($username);
  if($time_elapsed){
    $errors[] = "Too many failed logins for this ". h($username) ." .You will need to wait ". h(ceil($time_elapsed/60)) ." minutes before attempting another login.";
  } 

  // If there were no errors, submit data to database
  if (empty($errors)) {

    $users_result = find_users_by_username($username);
    // No loop, only one result
    $user = db_fetch_assoc($users_result);

    if($user) {
      $is_match = password_verify($attempted_password, $user['hashed_password']);
      if($is_match){
        // Username found, password matches
        log_in_user($user);
        reset_failed_login($username);
        // Redirect to the staff menu after login
        redirect_to('index.php');
      } else {
        // Username found, but password does not match.
        $recorded = record_failed_login($username);
        if($recorded)
          $errors[] = "Log in was not successful.";
      }
    } else {
      // No username found
      $recorded = record_failed_login($username);
      if($recorded)
        $errors[] ="Log in was not successful.";
    }
  }
}

?>
<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>
<div id="menu">
  <ul>
    <li><a href="../index.php">Public Site</a></li>
  </ul>
</div>

<div id="main-content">
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    <?php echo csrf_token_tag(); ?>
    Username:<br />
    <input type="text" name="username" value="<?php echo h($username); ?>" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" name="submit" value="Submit"  />
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
