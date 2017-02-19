<?php

  //
  // COUNTRY QUERIES
  //

  // Find all countries, ordered by name
  function find_all_countries() {
    global $db;
    $sql = "SELECT * FROM countries ORDER BY name ASC;";
    $country_result = db_query($db, $sql);
    return $country_result;
  }

  //
  // STATE QUERIES
  //

  // Find all states, ordered by name
  function find_all_states() {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find all states, ordered by name
  function find_states_for_country_id($country_id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE country_id='" . $country_id . "' ";
    $sql .= "ORDER BY name ASC;";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  // Find state by ID
  function find_state_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM states ";
    $sql .= "WHERE id='" . $id . "';";
    $state_result = db_query($db, $sql);
    return $state_result;
  }

  function validate_state($state, $errors=array()) {
    // TODO add validations
    if(is_blank($state['name'])){
        $errors[] = h("State name cannot be blank.");
      }else if(!has_length($state['name'], ['min' => 2 , 'max' =>255])){
        $errors[] = h("State name must be between 2 and 255 characters.");
      }else if(!has_valid_names($state['name'])){
        $errors[] = h("State name must have all alpabhets.");
      }

    if(is_blank($state['code'])){
        $errors[] = h("State code cannot be blank.");
      }else if(!has_length($state['code'], ['exact'=>2])){
        $errors[] = h("Code must be 2 characters.");
      }else if(!has_valid_names($state['code'])){
        $errors[] = h("Code name must have all alphabhets.");
      }
    return $errors;
  }

  // Add a new state to the table
  // Either returns true or an array of errors
  function insert_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $state['name'] = db_escape($db, $state['name']);
    $state['code'] = db_escape($db,$state['code']);
    //$state['id'] = db_escape($db,$state['id']);

    // TODO add SQL
    $sql = "INSERT INTO states";
    $sql .= "(name, code)";
    $sql .= "VALUES (";
    $sql .= "'" . $state['name'] . "',";
    $sql .= "'" . $state['code']. "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a state record
  // Either returns true or an array of errors
  function update_state($state) {
    global $db;

    $errors = validate_state($state);
    if (!empty($errors)) {
      return $errors;
    }

    $state['name'] = db_escape($db, $state['name']);
    $state['code'] = db_escape($db,$state['code']);
    $state['id'] = db_escape($db,$state['id']);


     // TODO add SQL
    $sql = "UPDATE states SET ";
    $sql .= "name='" . $state['name'] . "', ";
    $sql .= "code='" . $state['code'] . "' ";
    $sql .= "WHERE id='" . $state['id'] . "' ";
    $sql .= "LIMIT 1;";
    // For update_state statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // TERRITORY QUERIES
  //

  // Find all territories, ordered by state_id
  function find_all_territories() {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "ORDER BY state_id ASC, position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find all territories whose state_id (foreign key) matches this id
  function find_territories_for_state_id($state_id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE state_id='" . $state_id . "' ";
    $sql .= "ORDER BY position ASC;";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  // Find territory by ID
  function find_territory_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "WHERE id='" . $id . "';";
    $territory_result = db_query($db, $sql);
    return $territory_result;
  }

  function validate_territory($territory, $errors=array()) {
    // TODO add validations
    if(is_blank($territory['name'])){
        $errors[] = h("Territory name cannot be blank.");
      }else if(!has_length($territory['name'], ['min' => 2 , 'max' =>255])){
        $errors[] = h("Territory name must be between 2 and 255 characters.");
      }else if(!has_valid_names($territory['name'])){
        $errors[] = h("Territory name must have all alpabhets.");
      }

    if(is_blank($territory['position'])){
        $errors[] = h("Territory position cannot be blank.");
      }else if(!has_valid_number_format($territory['position'])){
        $errors[] = h("Territory position name must have all numbers without spaces.");
      }else if(!has_length($territory['position'], ['min' => 1 , 'max' =>255])){
        $errors[] = h("Territory position must be between 2 and 255 characters.");
      }
    return $errors;
  }
   

  // Add a new territory to the table
  // Either returns true or an array of errors
  function insert_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $territory['name'] = db_escape($db, $territory['name']);
    $territory['state_id'] = db_escape($db,$territory['state_id']);
    $territory['position'] = db_escape($db, $territory['position']);
    $territory['id'] = db_escape($db, $territory['id']);
    // TODO add SQL
    $sql = "INSERT INTO territories";
    $sql .= "(name,state_id,position)";
    $sql .= "VALUES (";
    $sql .= "'" . $territory['name'] . "',";
    $sql .= "'" . $territory['state_id'] . "',";
    $sql .= "'" . $territory['position']. "'";
    $sql .= ");";

    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a territory record
  // Either returns true or an array of errors
  function update_territory($territory) {
    global $db;

    $errors = validate_territory($territory);
    if (!empty($errors)) {
      return $errors;
    }

    $territory['name'] = db_escape($db, $territory['name']);
    $territory['position'] = db_escape($db, $territory['position']);
    $territory['id'] = db_escape($db, $territory['id']);

    // TODO add SQL
    $sql = "UPDATE territories SET ";
    $sql .= "name='" . $territory['name'] . "', ";
    $sql .= "position='" . $territory['position'] . "' ";
    $sql .= "WHERE id='" . $territory['id'] . "' ";
    $sql .= "LIMIT 1;";
    
    // For update_territory statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE territoryment failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  //
  // SALESPERSON QUERIES
  //

  // Find all salespeople, ordered last_name, first_name
  function find_all_salespeople() {
    global $db;
    $sql = "SELECT * FROM salespeople ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // To find salespeople, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same territory ID.
  function find_salespeople_for_territory_id($territory_id=0) {
    global $db;
    $territory_id = db_escape($db, $territory_id);

    $sql = "SELECT * FROM salespeople ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (salespeople_territories.salesperson_id = salespeople.id) ";
    $sql .= "WHERE salespeople_territories.territory_id='" . $territory_id . "' ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  // Find salesperson using id
  function find_salesperson_by_id($id=0) {
    global $db;
    $id = db_escape($db, $id);

    $sql = "SELECT * FROM salespeople ";
    $sql .= "WHERE id='" . $id . "' LIMIT 1;";
    $salespeople_result = db_query($db, $sql);
    return $salespeople_result;
  }

  function validate_salesperson($salesperson, $errors=array()) {
    // TODO add validations

    if(is_blank($salesperson['first_name'])){
        $errors[] = h("First name cannot be blank.");
      }else if(!has_length($salesperson['first_name'], ['min' => 2 , 'max' =>255])){
        $errors[] = h("First name must be between 2 and 255 characters.");
      }else if(!has_valid_names($salesperson['first_name'])){
        $errors[] = h("First name must have all alpabhets.");
      }

    if(is_blank($salesperson['last_name'])){
        $errors[] = h("Last name cannot be blank.");
      }else if(!has_length($salesperson['last_name'], ['min' => 2, 'max' => 255])){
        $errors[] = h("Last name must be between 2 and 255 characters.");
      }else if(!has_valid_names($salesperson['last_name'])){
        $errors[] = h("Last name must have all alpabhets.");
      }

    if(is_blank($salesperson['phone'])){
        $errors[] = h("Phone number cannot be blank.");
    }else if(!has_valid_phoneNumber($salesperson['phone'])){
        $errors[] = h("Enter a valid phone number");
    }else if( strlen(preg_replace('/[^0-9]/','', $salesperson['phone'])) != 10){ 
        $errors[] = h("Phone number must be 10 digits");
    }

    if(is_blank($salesperson['email'])){
       $errors[] = h("Email cannot be blank."); 
    }else if(!has_valid_email_format($salesperson['email'])){
        $errors[] = h("Email address doesn't look right missing '@' ?");
    }else if(!has_valid_email($salesperson['email'])){
       $errors[] = h("Email address can only contain [A-Z], [a-z], [0-9], dot, hypen and underscore.");
    }

      
    return $errors;
  }

  // Add a new salesperson to the table
  // Either returns true or an array of errors
  function insert_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);

    if (!empty($errors)) {
      return $errors;
    }

    $salesperson['first_name'] = db_escape($db, $salesperson['first_name']);
    $salesperson['last_name'] = db_escape($db, $salesperson['last_name']);
    $salesperson['email'] = db_escape($db,$salesperson['email']);
    $salesperson['phone'] = db_escape($db,$salesperson['phone']);

    //$sql = ""; // TODO add SQL
    $sql = "INSERT INTO salespeople";
    $sql .= "(first_name, last_name, phone ,email)";
    $sql .= "VALUES (";
    $sql .= "'" . $salesperson['first_name'] . "',";
    $sql .= "'" . $salesperson['last_name'] . "',";
    $sql .= "'" . $salesperson['phone'] . "'," ;
    $sql .= "'" . $salesperson['email']. "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a salesperson record
  // Either returns true or an array of errors
  function update_salesperson($salesperson) {
    global $db;

    $errors = validate_salesperson($salesperson);
    if (!empty($errors)) {
      return $errors;
    }

    $salesperson['first_name'] = db_escape($db, $salesperson['first_name']);
    $salesperson['last_name'] = db_escape($db, $salesperson['last_name']);
    $salesperson['email'] = db_escape($db,$salesperson['email']);
    $salesperson['phone'] = db_escape($db,$salesperson['phone']);
    $salesperson['id'] = db_escape($db,$salesperson['id']);

    // TODO add SQL
    $sql = "UPDATE salespeople SET ";
    $sql .= "first_name='" . $salesperson['first_name'] . "', ";
    $sql .= "last_name='" . $salesperson['last_name'] . "', ";
    $sql .= "email='" . $salesperson['email'] . "', ";
    $sql .= "phone='" . $salesperson['phone'] . "' ";
    $sql .= "WHERE id='" . $salesperson['id'] . "' ";
    $sql .= "LIMIT 1;";
    // For update_salesperson statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // To find territories, we need to use the join table.
  // We LEFT JOIN salespeople_territories and then find results
  // in the join table which have the same salesperson ID.
  function find_territories_by_salesperson_id($id=0) {
    global $db;
    $sql = "SELECT * FROM territories ";
    $sql .= "LEFT JOIN salespeople_territories
              ON (territories.id = salespeople_territories.territory_id) ";
    $sql .= "WHERE salespeople_territories.salesperson_id='" . $id . "' ";
    $sql .= "ORDER BY territories.name ASC;";
    $territories_result = db_query($db, $sql);
    return $territories_result;
  }

  //
  // USER QUERIES
  //

  // Find all users, ordered last_name, first_name
  function find_all_users() {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "ORDER BY last_name ASC, first_name ASC;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  // Find user using id
  function find_user_by_id($id=0) {
    global $db;
    $sql = "SELECT * FROM users WHERE id='" . $id . "' LIMIT 1;";
    $users_result = db_query($db, $sql);
    return $users_result;
  }

  function validate_user($user, $errors=array()) {
    if (is_blank($user['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($user['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if (is_blank($user['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($user['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if (is_blank($user['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($user['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if (is_blank($user['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($user['username'], array('max' => 255))) {
      $errors[] = "Username must be less than 255 characters.";
    }
    return $errors;
  }

  // Add a new user to the table
  // Either returns true or an array of errors
  function insert_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $user['first_name'] = db_escape($db,$user['first_name']);
    $user['last_name'] = db_escape($db,$user['last_name']);
    $user['email'] = db_escape($db,$user['email']);
    $user['username'] = db_escape($db, $user['username']);

    $created_at = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, username, created_at) ";
    $sql .= "VALUES (";
    $sql .= "'" . $user['first_name'] . "',";
    $sql .= "'" . $user['last_name'] . "',";
    $sql .= "'" . $user['email'] . "',";
    $sql .= "'" . $user['username'] . "',";
    $sql .= "'" . $created_at . "'";
    $sql .= ");";
    // For INSERT statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

  // Edit a user record
  // Either returns true or an array of errors
  function update_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }
    $user['first_name'] = db_escape($db, $user['first_name']);
    $user['last_name'] = db_escape($db, $user['last_name']);
    $user['email'] = db_escape($db, $user['email']);
    $user['username'] = db_escape($db, $user['username']);
    $user['id'] = db_escape($db, $user['id']);

    $sql = "UPDATE users SET ";
    $sql .= "first_name='" . $user['first_name'] . "', ";
    $sql .= "last_name='" . $user['last_name'] . "', ";
    $sql .= "email='" . $user['email'] . "', ";
    $sql .= "username='" . $user['username'] . "' ";
    $sql .= "WHERE id='" . $user['id'] . "' ";
    $sql .= "LIMIT 1;";
    // For update_user statments, $result is just true/false
    $result = db_query($db, $sql);
    if($result) {
      return true;
    } else {
      // The SQL UPDATE statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }

?>
