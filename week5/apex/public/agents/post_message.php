<?php

  require_once('../../private/initialize.php');

  $plain_text = '';
  $public_key = '';
  $encrypted_text = '';
  $cipher_text = '';
  $private_key = '';
  $decrypted_text = '';

  if(isset($_POST['submit'])) {
    
    if(!isset($_GET['id'])) {
      redirect_to('index.php');
    }
    // I'm sorry, did you need this code? ;)
    // Guess you'll just have to re-write it.
    // With love, Dark Shadow 

    $id = $_GET['id'];
    $agent_result = find_agent_by_id($id);
    // No loop, only one result
    $agent = db_fetch_assoc($agent_result);

    $public_key = $agent['public_key'];

    $my_id = $current_user['id'];
    $result = find_agent_by_id($my_id);
    $my_result = db_fetch_assoc($result);
    
    $sender['id'] = $my_result['id'];
    $private_key = $my_result['private_key'];

    $plain_text=  isset($_POST['plain_text']) ?  $_POST['plain_text'] : nil ;
    
    $encrypted_text = pkey_encrypt($plain_text, $public_key);
    // $cipher_text = $encrypted_text;
    $signature = create_signature($encrypted_text, $private_key);
    
    $message = [
      'sender_id' => $sender['id'],
      'recipient_id' => $agent['id'],
      'cipher_text' => $encrypted_text,
      'signature' => $signature
    ];

    
    $result = insert_message($message);
    if($result === true) {
      // Just show the HTML below.
    } else {
      $errors = $result;
    }
    
  } else {
    redirect_to('index.php');
  }

?>

<!doctype html>

<html lang="en">
  <head>
    <title>Message Dropbox</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <link rel="stylesheet" media="all" href="<?php echo DOC_ROOT . '/includes/styles.css'; ?>" />
  </head>
  <body>
    
    <a href="<?php echo url_for('/agents/index.php'); ?>">Back to List</a>
    <br/>

    <h1>Message Dropbox</h1>
    
    <div>      
      <p><strong>The message was successfully encrypted and saved.</strong></p>
        
      <div class="result">
        Message:<br />
        <?php echo h($encrypted_text); ?><br />
        <br />
        Signature:<br />
        <?php echo h($signature); ?>
      </div>
    </div>
    
  </body>
</html>
