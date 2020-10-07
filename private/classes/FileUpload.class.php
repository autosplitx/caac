<?php
class FileUpload extends DatabaseObject {
 
  static protected $table_name = "file_uploads";
  static protected $db_columns = ['id', 'user_id', 'customer_id', 'caption', 'file_name', 'created_at', 'deleted'];

  public $id;
  public $user_id;
  public $customer_id;
  public $caption;
  public $file_name;
  public $created_at;
  public $deleted;

  public function __construct($args=[]) {
    $this->user_id = $args['user_id'] ?? '';
    $this->customer_id = $args['customer_id'] ?? '';
    $this->caption = $args['caption'] ?? '';
    $this->file_name = $args['file_name'] ?? '';
    $this->created_at = $args['created_at'] ?? date('Y-m-d H:i:s');
    $this->deleted = $args['deleted'] ?? '';
  }

  protected function validate() {
    $this->errors = [];

    if(is_blank($this->caption)) {
      $this->errors[] = "File caption is required.";
    } elseif (!has_length($this->caption, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "File caption must be between 2 and 255 characters.";
    }

    return $this->errors;
  }

  static public function find_by_user($user_id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE user_id='" . self::$database->escape_string($user_id) . "'";
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }
 
  static public function find_by_customer($customer_id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE customer_id='" . self::$database->escape_string($customer_id) . "'";
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

  
}

?>
