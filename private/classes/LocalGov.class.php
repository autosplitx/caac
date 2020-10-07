<?php

class LocalGov extends DatabaseObject {

  static protected $table_name = "local_governments";
  static protected $db_columns = ['id', 'state_id', 'name'];
 
  public $id;
  public $name;
  public $state_id;

  public function __construct($args=[]) {
    $this->bg_color = $args['name'] ?? '';
    $this->bg_color = $args['state_id'] ?? '';
  }

  static public function find_by_lga($state_id){
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE state_id='" . self::$database->escape_string($state_id) . "'";
    $sql .= "ORDER BY id ASC ";
    return static::find_by_sql($sql);
  }

  static public function find_all_lga() {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "ORDER BY id ASC ";
    return static::find_by_sql($sql);
  }

}

?>
