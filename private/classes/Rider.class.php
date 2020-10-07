<?php

class Rider extends Admin {

  static protected $table_name = "riders";
  static protected $db_columns = ['id', 'first_name', 'last_name', 'email', 'phone', 'username', 'hashed_password', 'home_address', 'route_id' , 'city', 'lga', 'state', 'creator', 'created_date', 'category'];
 
  public $id;
  public $first_name;
  public $last_name;
  public $email;
  public $phone;
  public $username;
  protected $hashed_password;
  public $password;
  public $confirm_password;
  public $home_address;
  public $city;
  public $state;
  public $creator;
  public $created_date;
  public $route_id;
  public $lga;
  public $category;
  protected $password_required = true;

  const DISPATCH_TYPE = ['rider'=>'Motorbike Rider', 'luxirous'=>'Luxirious Bus Driver', 'hummer'=>'Hummer Bus Driver', 'shuttle'=>'Shuttle Driver', 'private'=>'Private Car Driver', 'truck'=>'Truck Driver'];

  public function __construct($args=[]) {
    $this->first_name = $args['first_name'] ?? '';
    $this->last_name = $args['last_name'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->phone = $args['phone'] ?? '';
    $this->username = $args['username'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->confirm_password = $args['confirm_password'] ?? '';
    $this->home_address = $args['home_address'] ?? '';
    // $this->route_id = intval($args['route_id']) ?? '';
    $this->route_id = $args['route_id'] ?? 0;
    $this->city = $args['city'] ?? '';
    $this->state = $args['state'] ?? '';
    $this->lga = $args['lga'] ?? '';
    $this->creator = $args['creator'] ?? '';
    $this->category = $args['category'] ?? '';
    $this->created_date = $args['created_date'] ?? date('Y-m-d H:i:s');
  }

  public function full_name() {
    return $this->first_name . " " . $this->last_name;
  }

  // protected function set_hashed_password() {
  //   $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
  // }

  // public function verify_password($password) {
  //   return password_verify($password, $this->hashed_password);
  // }

  // protected function create() {
  //   $this->set_hashed_password();
  //   return parent::create();
  // }

  // protected function update() {
  //   if($this->password != '') {
  //     $this->set_hashed_password();
  //     // validate password
  //   } else {
  //     // password not being updated, skip hashing and validation
  //     $this->password_required = false;
  //   }
  //   return parent::update();
  // }

  protected function validate() {
    $this->errors = [];

    if(is_blank($this->first_name)) {
      $this->errors[] = "First name cannot be blank.";
    } elseif (!has_length($this->first_name, array('min' => 3, 'max' => 255))) {
      $this->errors[] = "First name must be between 3 and 255 characters.";
    }

    if(is_blank($this->last_name)) {
      $this->errors[] = "Last name cannot be blank.";
    } elseif (!has_length($this->last_name, array('min' => 3, 'max' => 255))) {
      $this->errors[] = "Last name must be between 3 and 255 characters.";
    }

    if(is_blank($this->state)) {
      $this->errors[] = "Kindly select deployed State";
    }

    // if(is_blank($this->email)) {
    //   $this->errors[] = "Email cannot be blank.";
    // } elseif (!has_length($this->email, array('max' => 255))) {
    //   $this->errors[] = "Last name must be less than 255 characters.";
    // } elseif (!has_valid_email_format($this->email)) {
    //   $this->errors[] = "Email must be a valid format.";
    // }

    if(is_blank($this->username)) {
      $this->errors[] = "Username cannot be blank.";
    } elseif (!has_length($this->username, array('min' => 3, 'max' => 255))) {
      $this->errors[] = "Username must be between 3 and 255 characters.";
    } elseif (!has_unique_username($this->username, $this->id ?? 0)) {
      $this->errors[] = "Username not allowed. Try another.";
    }

    if($this->password_required) {

      if(is_blank($this->password)) {
        $this->errors[] = "Password cannot be blank.";
      } elseif (!has_length($this->password, array('min' => 8))) {
        $this->errors[] = "Password must contain 8 or more characters";
      } elseif (!preg_match('/[A-Z]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 symbol";
      }

      if(is_blank($this->confirm_password)) {
        $this->errors[] = "Confirm password cannot be blank.";
      } elseif ($this->password !== $this->confirm_password) {
        $this->errors[] = "Password and confirm password must match.";
      }

      /* -------- Validation for phone, home_address and city not done yet ------- */
    }

    return $this->errors;
  }

  static public function find_by_username($username) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE username='" . self::$database->escape_string($username) . "'";
    
    $sql .= " AND (deleted IS NULL OR deleted = 0 OR deleted = '') "; //newly added for removing deleted
    
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

  static public function find_rider_by_name($name) {

    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE ( `first_name` LIKE '%". self::$database->escape_string($name) ."%' ";
    $sql .= "OR `last_name` LIKE '%". self::$database->escape_string($name) ."%' ";
    $sql .= "OR `username` LIKE '%". self::$database->escape_string($name) ."%' ) ";
    
    $sql .= " AND (deleted IS NULL OR deleted = 0 OR deleted = '') "; //newly added for removing deleted

    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }

  }

  static public function find_all_drivers_and_state_riders($state='',$options=[]){

    $direction = $options['direction'] ?? false;

    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE category != 'rider' ";
    // $sql .= "UNION ";

    if($direction == 'Inbound'){

      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE state IN('" . $state . "') ";
      $sql .= "AND category = 'rider' ";
    
    }

    $sql .= " AND (deleted IS NULL OR deleted = 0 OR deleted = '') "; //newly added for removing deleted
    
    $sql .= "ORDER BY id DESC ";
     
    $obj_array = static::find_by_sql($sql);
    return $obj_array;
  }
  
  static public function find_by_state($state) {
     $sql = "SELECT * FROM " . static::$table_name . " ";
     $sql .= "WHERE state IN('" . $state . "') ";
     
     $sql .= " AND (deleted IS NULL OR deleted = 0 OR deleted = '') "; //newly added for removing deleted
     
     $sql .= "ORDER BY id DESC ";
     
     $obj_array = static::find_by_sql($sql);
    //  if(!empty($obj_array)) {
       return $obj_array;
    //  } else {
    //   return false;
    //  }
   }

}

?>
