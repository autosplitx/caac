<?php

class Country extends DatabaseObject {

  static protected $table_name = "country";
  static protected $db_columns = ['id', 'iso', 'name', 'nicename', 'iso3', 'numcode', 'phonecode'];
 
  public $id;
  public $iso;
  public $name;
  public $nicename;
  public $iso3;
  public $numcode;
  public $phonecode;

  public function __construct($args=[]) {
    $this->bg_color = $args['name'] ?? '';
  }

  static public function get_region_id($country_id){
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($country_id) . "'";
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      $result = array_shift($obj_array);
      return $result->region_id;
    } else {
      return false;
    }
  }
 
  static public function find_by_name($country_name){
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE name='" . self::$database->escape_string($country_name) . "'";
    $obj_array = static::find_by_sql($sql);

    if(!empty($obj_array)) {
      $result = array_shift($obj_array);
      return $result;
    } else {
      return false;
    }

  }

  static public function get_country($user){
    $user_region = static::get_region_id($user->state);
    switch ($user->admin_level) {
      case '1': $allStates = static::find_all(); break;
      case '2': $allStates = static::find_states_by_zone($user_region); break;
      case '3': $allStates = static::find_states_by_region($user_region); break;      
      default: $allStates = [static::find_by_id($user->state)];  break;
    }
    return $allStates;
  }

  static public function get_states_array($user, $options=''){

    $user_region = static::get_region_id($user->state);
    switch ($user->admin_level) {
      case '1': $countrys = static::find_all(); break;
      case '2': $countrys = static::find_states_by_zone($user_region); break;
      case '3': $countrys = static::find_states_by_region($user_region); break;      
      default: $countrys = [static::find_by_id($user->state)];  break;
    }

    $countrys_array = [];

    switch ($options) {
      case 'name': foreach ($countrys as $allState) { $countrys_array[] = $allState->name; }; break;
      default: foreach ($countrys as $allState) { $countrys_array[] = $allState->id; }; break;
    }
    return $countrys_array;
  }

  static public function find_states_by_region($region_id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE region_id='" . self::$database->escape_string($region_id) . "'";
    $obj_array = static::find_by_sql($sql);

    return $obj_array;
  }

  static public function find_states_by_zone($region_id) {
    
    if (in_array($region_id, [1,2,3])) {
      $region_ids = [1,2,3];
    } elseif(in_array($region_id, [4,5,6])) {
      $region_ids = [4,5,6];
    }
    
    $region_id = join("', '", $region_ids);

    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE region_id IN('$region_id')";
    $obj_array = static::find_by_sql($sql);

    return $obj_array;
  }

}

?>
