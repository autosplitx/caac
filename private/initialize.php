<?php

  ob_start(); // turn on output buffering

  //this is to set the default timezone to lagos
  date_default_timezone_set("Africa/Lagos");

  // Assign file paths to PHP constants
  // __FILE__ returns the current path to this file
  // dirname() returns the path to the parent directory
  define("PRIVATE_PATH", dirname(__FILE__));
  define("PROJECT_PATH", dirname(PRIVATE_PATH));
  define("PUBLIC_PATH", PROJECT_PATH . '/public');
  define("SHARED_PATH", PRIVATE_PATH . '/shared');

  // Assign the root URL to a PHP constant
  // * Do not need to include the domain
  // * Use same document root as webserver
  // * Can set a hardcoded value:
  // define("WWW_ROOT", '/relieve/trash/myajax/public');
  define("WWW_ROOT", '/project/caac/public');
  // define("WWW_ROOT", '');
  // * Can dynamically find everything in URL up to "/public"
  // $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
  // $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  // define("WWW_ROOT", $doc_root);

  require_once('functions.php');
  require_once('status_error_functions.php'); 
  require_once('db_credentials.php');
  require_once('database_functions.php');
  require_once('validation_functions.php');

  // Load class definitions manually

  // -> Individually
  // require_once('classes/bicycle.class.php');

  // -> All classes in directory
  foreach(glob('classes/*.class.php') as $file) {
    require_once($file);
  }

  // Autoload class definitions
  function my_autoload($class) {
    if(preg_match('/\A\w+\Z/', $class)) {
      include('classes/' . $class . '.class.php');
    }
  }
  spl_autoload_register('my_autoload');

  $database = db_connect();
  DatabaseObject::set_database($database);

  $session = new Session; 

  if ($session->user_id) { //for riders session

    $loggedInAdmin = Users::find_by_id($session->user_id);
    //$accessStatesArrays = State::get_states_array($loggedInAdmin); //this fetch all access state ids
    //$accessStates = join("','", $accessStatesArrays);

  }elseif ($session->username) { //for admin session

    $loggedInAdmin = Admin::find_by_username($session->username);
    //$accessStatesArrays = State::get_states_array($loggedInAdmin); //this fetch all access state ids
    //$accessStates = join("','", $accessStatesArrays);
    // echo "<pre>";print_r($accessStates);echo "</pre>";
    //  echo $accessStates;
    
    //  echo $accessStates;
  }elseif($session->customer_id){ //for customers session

      // if($session->clientcat === 'credit'){
      //    // echo $_SESSION['clientcat'];
      //    $loggedInCustomer = CreditClient::find_by_credit_email($session->email);
      // }elseif($session->clientcat === 'walkin'){
      //    // echo $_SESSION['clientcat'];
      //    $loggedInCustomer = WalkInClient::find_by_walkin_email($session->email);
      // }elseif($session->clientcat === 'prepaid'){
      //    // echo $_SESSION['clientcat'];
      //    $loggedInCustomer = PrepaidClient::find_by_prepaid_email($session->email);
      // }

      // $arg_clientcat = $session->clientcat ?? null;
    
  }
  // $theme = Theme::find_all();
  // $company_1 = CompanyDetails::find_by_id("1");
  // $pics = CompanyLogo::find_by_id(1);
  // $bank_1 = BankDetails::find_by_id(1);
?>

