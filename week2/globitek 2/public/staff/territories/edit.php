<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to('index.php');
}
$territories_result = find_territory_by_id($_GET['id']);
// No loop, only one result
$territory = db_fetch_assoc($territories_result);
$state_id = $territory['state_id'];
// Set default values for all variables the page needs.
$errors = array();
//after the form has been submitted.

if(is_post_request()) {
  // Confirm that values are present before accessing them.
  if(isset($_POST['name'])) { $territory['name'] = h($_POST['name']); }
  if(isset($_POST['position'])) { $territory['position'] = h($_POST['position']); }

  $result = update_territory($territory);
  
  if($result === true) {
    redirect_to('show.php?id=' . u($territory['id']));
  } else {
    $errors = $result;
  }
}

?>


<?php $page_title = 'Staff: Edit Territory ' . $territory['name']; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <a href="../states/show.php?id=<?php echo $state_id ;?>">Back to State Details</a><br />

  <h1>Edit Territory: <?php echo $territory['name']; ?></h1>

  <?php echo display_errors($errors); ?>
  <!-- TODO add form -->
  <form action="edit.php?id=<?php echo $territory['id'] ;?>" method="post">
    Name:<br />
    <input type="text" name="name" value="<?php echo $territory['name']; ?>" /><br />
    Position:<br />
    <input type="text" name="position" value="<?php echo $territory['position']; ?>" /><br />
    
    <input type="submit" name="submit" value="Update"  />
  </form>

  <br>
  <a href="show.php?id=<?php echo $territory['id']; ?>" > Cancel </a>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
