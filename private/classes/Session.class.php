<?php

class Session {

  private $admin_id;
  public  $customer_id;
  public  $user_id;
  public  $username;
  // public  $credit_email;
  // public  $walkin_email;
  // public  $prepaid_email;
  // public  $customer_cat;
  public  $email;
  public  $clientcat;
  private $last_login;
  private $client = 'ifex_logl_';

  const MAX_LOGIN_AGE = 60*60*24; // 1 day

  public function __construct() {
    session_start();
    $this->check_stored_login();
    // $this->check_customer_stored_login();
  }

  public function login($admin, $clientcat='', $user='') {
    if($admin) {

      //this first part is general saved session for admin,customers and riders
      // prevent session fixation attacks
      session_regenerate_id();
      $this->admin_id = $_SESSION[$this->client . 'admin_id'] = $admin->id;
      $this->last_login = $_SESSION[$this->client . 'last_login'] = date('Y-m-d H:i:s');
      
      if ($clientcat) { //this part for the customer login saved session

        $this->customer_id = $_SESSION[$this->client . 'customer_id'] = $admin->id;
        $this->clientcat = $_SESSION[$this->client . 'clientcat']  = $clientcat;
        
        switch ($clientcat) {

          case 'credit':
            $this->email = $_SESSION[$this->client . 'email'] = $admin->client_email;
            break;
          
          case 'prepaid':
            $this->email = $_SESSION[$this->client . 'email'] = $admin->client_email;
            break;
          
          default:
            $this->email = $_SESSION[$this->client . 'email'] = $admin->client_email;
            break;
        }

      } elseif ($user === true) { //this part for the rider login saved session

        $this->user_id = $_SESSION[$this->client . 'user_id'] = $admin->id;
        $this->last_login = $_SESSION[$this->client . 'last_login'] = time();

      } else { //this part for the admin login saved session

        $this->username = $_SESSION[$this->client . 'username'] = $admin->username;
      
      }

    }
    return true;
  }

  public function is_logged_in() {
    // return isset($this->admin_id);
    return isset($this->admin_id) && $this->last_login_is_recent();
  }

  // public function is_customer_logged_in() {
    
  //   return isset($this->customer_id) && $this->last_customer_login_is_recent();
  // }

  public function logout($clientcat='',$user='') {
    unset($_SESSION[$this->client . 'admin_id']);
    unset($_SESSION[$this->client . 'last_login']);
    unset($this->admin_id);
    unset($this->last_login);
    if ($clientcat) {
      unset($_SESSION[$this->client . 'email']);
      unset($_SESSION[$this->client . 'customer_id']);
      unset($_SESSION[$this->client . 'clientcat']);
      unset($this->email);
      unset($this->customer_id);
      unset($this->clientcat);
    }elseif ($user) {
      unset($_SESSION[$this->client . 'user_id']);
      unset($this->user_id);
    } else {
      unset($_SESSION[$this->client . 'username']);
      unset($this->username);
    }
    
    return true;
  }

  private function check_stored_login() {

    if(isset($_SESSION[$this->client . 'admin_id'])) {

      $this->admin_id = $_SESSION[$this->client . 'admin_id'];
      $this->last_login = $_SESSION[$this->client . 'last_login'];

      if (isset($_SESSION[$this->client . 'clientcat'])) {

        $this->customer_id = $_SESSION[$this->client . 'customer_id'];
        $this->clientcat = $_SESSION[$this->client . 'clientcat'];
        
        switch ($_SESSION[$this->client . 'clientcat']) {
          case 'credit':
            $this->email = $_SESSION[$this->client . 'email'];
            break;
          
          case 'prepaid':
            $this->email = $_SESSION[$this->client . 'email'];
            break;
          
          default:
            $this->email = $_SESSION[$this->client . 'email'];
            break;
        }

      }elseif (isset($_SESSION[$this->client . 'user_id'])) {

        $this->user_id = $_SESSION[$this->client . 'user_id'];

      }else{

        // $this->username = $_SESSION[$this->client . 'username'];
      
      }

    }

  }


  private function last_login_is_recent() {
    if(!isset($this->last_login)) {
      return false;
    } elseif(($this->last_login + self::MAX_LOGIN_AGE) < time()) {
      return false;
    } else {
      return true;
    }
  }


  public function message($msg="") {
    if(!empty($msg)) {
      // Then this is a "set" message
      $_SESSION[$this->client . 'message'] = $msg;
      return true;
    } else {
      // Then this is a "get" message
      return $_SESSION[$this->client . 'message'] ?? '';
    }
  }

  public function clear_message() {
    unset($_SESSION[$this->client . 'message']);
  }
}

?>
