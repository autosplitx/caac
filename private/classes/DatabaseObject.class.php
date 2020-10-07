<?php

class DatabaseObject {

  static protected $database;
  static protected $table_name = "";
  static protected $columns = [];
  public $errors = [];

  static public function set_database($database) {
    self::$database = $database;
  }

  static public function find_by_sql($sql) {
    $result = self::$database->query($sql);
    if(!$result) {
      // echo $sql;
      exit("Database query failed.");
    }

    // results into objects
    $object_array = [];
    while($record = $result->fetch_assoc()) {
      $object_array[] = static::instantiate($record);
    }

    $result->free();

    return $object_array;
  }

  static public function find_all() {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "ORDER BY id DESC ";
    return static::find_by_sql($sql);
  }

  static public function count_all() {
    $sql = "SELECT COUNT(*) FROM " . static::$table_name;
    $result_set = self::$database->query($sql);
    $row = $result_set->fetch_array();
    return array_shift($row);
  }

  static public function find_by_id($id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($id) . "'";
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

  static public function find_by_email($email) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE client_email='" . self::$database->escape_string($email) . "'";
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

  static protected function instantiate($record) {
    $object = new static;
    // Could manually assign values to properties
    // but automatically assignment is easier and re-usable
    foreach($record as $property => $value) {
      if(property_exists($object, $property)) {
        $object->$property = $value;
      }
    }
    return $object;
  }

  protected function validate() {
    // $this->errors = [];

    // Add custom validations

    return $this->errors;
  }

  protected function create() {
    $this->validate();
    if(!empty($this->errors)) { return false; }

    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO " . static::$table_name . " (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
    
    // echo $sql;
    
    $result = self::$database->query($sql);
    if($result) {
      $this->id = self::$database->insert_id;
    }
    return $result;
  }

  protected function update() {
    $this->validate();
    if(!empty($this->errors)) { return false; }

    $attributes = $this->sanitized_attributes();
    $attribute_pairs = [];
    foreach($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }

    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(', ', $attribute_pairs);
    $sql .= " WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";

    // echo $sql;
    $result = self::$database->query($sql);
    return $result;
  }

  public function save() {
    // A new record will not have an ID yet
    if(isset($this->id)) {
      return $this->update();
    } else {
      return $this->create();
    }
  }

  public function merge_attributes($args=[]) {
    foreach($args as $key => $value) {
      if(property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }

  // Properties which have database columns, excluding ID
  public function attributes() {
    $attributes = [];
    foreach(static::$db_columns as $column) {
      if($column == 'id') { continue; }
      $attributes[$column] = $this->$column;
    }
    return $attributes;
  }

  protected function sanitized_attributes() {
    $sanitized = [];
    foreach($this->attributes() as $key => $value) {
      $sanitized[$key] = self::$database->escape_string($value);
    }
    return $sanitized;
  }

  public function delete() {
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;

    // After deleting, the instance of the object will still
    // exist, even though the database record does not.
    // This can be useful, as in:
    //   echo $user->first_name . " was deleted.";
    // but, for example, we can't call $user->update() after
    // calling $user->delete().
  }

  static public function count_status_by_clientcat($clientcat, $clientId, $status=[]){
    static::$A = count($status);

    $sql = "SELECT COUNT(*) FROM " . static::$table_name. " ";
    $sql .= "WHERE clientcat='".self::$database->escape_string($clientcat)."'";
    $sql .= " AND clientId='".self::$database->escape_string($clientId)."' ";
    if(static::$A > 1) {
     
     $sql .="AND (";
     for($i = 0; $i < static::$A ; ++$i){
         
          $sql .= "status='" . self::$database->escape_string($status[$i]) . "'";
          
          if($i == (static::$A-1)){  
             
             $sql .=")";
            continue; }

          $sql .= " OR ";
      
     }


    } else {

      $sql .="AND status='" . self::$database->escape_string($status[0]) . "'";
    }

     // echo $sql.'<br>';
    $result_set = self::$database->query($sql);
    $row = $result_set->fetch_array();
    return array_shift($row);
       
  }

    // Abdulghafar's Query Start from here
    // To remove record from the UI without deleting it from the database
  
    static public function deleted($id) {
      $sql = "UPDATE " . static::$table_name . " SET ";
      $sql .= "deleted = 1 ";
      $sql .= " WHERE id='" . self::$database->escape_string($id) . "' ";
      $sql .= "LIMIT 1";
      $result = self::$database->query($sql);
      return $result;
    }

    static public function find_all_deleted() {
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE deleted = 1 ";
      return static::find_by_sql($sql);
    }

    static public function find_by_undeleted() {
      $sql = "SELECT * FROM " . static::$table_name . " ";
    //   $sql .= "WHERE deleted = 0 ";
    $sql .= " WHERE (deleted IS NULL OR deleted = 0 OR deleted = '') ";
    $sql .= " ORDER BY id DESC ";
      return static::find_by_sql($sql);
    }
    


    // Abdulghafar's Query end here

}

// INSERT INTO trackers (product_id, riders_id, assign_date) VALUES ('429', '1', '2019-07-29 17:24:37')INSERT INTO trans_manifest (trans_id, seal, source_manifest_no, destination_manifest_no, source_rider_id, destination_rider_id, time_uploaded, airline, source, destination, hubnspoke, m_route) VALUES ('429', '', '20190729172437024', '20190729172437024', '1', '1', '2019-07-29 17:24:37', '0', '25', '25', '0', 'JIBOWU, HEAD OFFICE --> N/A')INSERT INTO trans_track (trans_id, status, time, rider_id, receiver_name, phone, comments, airline, source, destination, updated_by) VALUES ('429', '6', '2019-07-29 17:24:37', '1', '', '', '', ' 0', '25', '25', '24')

?>
