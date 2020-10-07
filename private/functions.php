<?php

function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string="") {
  return urlencode($string);
}

function raw_u($string="") {
  return rawurlencode($string);
}

function h($string="") {
  return htmlspecialchars($string);
}

function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}

function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
} 

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

// PHP on Windows does not have a money_format() function.
// This is a super-simple replacement.
if(!function_exists('money_format')) {
  function money_format($format, $number) {
    return '$' . number_format($number, 2);
  }
}

//this function is used format the track number to this format EAGLE/LAG/2018/0023
function createTrackNo($val1, $val2){

  $trackNo = "EAGLE/" . strtoupper(substr($val1, 0, 3)) . "/" . date('Y') . "/" . str_pad($val2, 4, "0", STR_PAD_LEFT);

  return $trackNo;

}
 
// this is used to get the id from 
function getIdFromTrackNo($value){
  $return_value = explode("/", $value);
  $totalArray = count($return_value);
  $return_id = $return_value[$totalArray - 1];
  settype($return_id, 'integer');

  return $return_id;
}
 
function display_message($msg='') {
  if(isset($msg) && $msg != '') {
    return "<div id='message'> $msg </div>";
  }else{
    $msg = "";
    return "<div id='message'> $msg </div>";
  }
}

function get_duration_span($value){
  $today = date('Y-m-d');
  switch ($value) {
    case 'year':
      $value = [date('Y-01-01'), $today];
      break;

    case 'week':
      $todayD = date('Y-m-d-w');
      $diff = explode('-', $todayD);
      if ($diff[3] === 0) {
        $startwk = $today;
      }else{
        $startwk = date('Y-m-d', strtotime($today) - 60*60*24*$diff[3]);
      }
      $value = [$startwk, $today];
      break;

    case 'month':
      $value = [date('Y-m-01'), $today];
      break;
  
    default:
      $value = [$today, $today];
      break;
  }
  return $value;
}

// This part is for the text messages

//Function to connect to SMS sending server using HTTP GET
function useHTTPGet($url, $username, $apikey, $flash, $sendername, $messagetext, $recipients) {
    $query_str = http_build_query(array('username' => $username, 'apikey' => $apikey, 'sender' => $sendername, 'messagetext' => $messagetext, 'flash' => $flash, 'recipients' => $recipients));
    return file_get_contents("{$url}?{$query_str}");
}

//For logging of actions on the App
function log_action($action, $message="", $logtype="") {
    
    switch ($logtype) {
        case 'login':
            $logfile = PRIVATE_PATH . '/logins.txt';
            break;
    
        case 'admin':
            $logfile = PRIVATE_PATH . '/admin.txt';
            break;
        
        default:
            $logfile = PRIVATE_PATH . '/trans.txt';
            break;
    }
  
  $new = file_exists($logfile) ? false : true;
  
  if($handle = fopen($logfile, 'a')) { // append
  
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
    $content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    
    if($new) { chmod($logfile, 0755); }
    
  } else {
    echo "Could not open log file for writing.";
  }
  
}

function findClient($cat, $id){
  switch ($cat) {
    case 'credit':
      $client = CreditClient::find_by_id($id);
      break;
    case 'prepaid':
      $client = PrepaidClient::find_by_id($id);
      break;
    default:
      $client = WalkInClient::find_by_id($id);
      break;
  }

  return $client;
}

function updateClientPwd($cat,$id,$newpwd){
  $hashedpwd = password_hash($newpwd, PASSWORD_BCRYPT);
  switch ($cat) {
    case 'credit':
      $result = DB::query('UPDATE credit_client SET hashed_password = :hashed_password WHERE id = :id', [':id'=>$id, ':hashed_password'=>$hashedpwd]);
      break;
    case 'prepaid':
      $result = DB::query('UPDATE prepaid_client SET hashed_password = :hashed_password WHERE id = :id', [':id'=>$id, ':hashed_password'=>$hashedpwd]);
      break;
    default:
      $result = DB::query('UPDATE walk_in_client SET hashed_password = :hashed_password WHERE id = :id', [':id'=>$id, ':hashed_password'=>$hashedpwd]);
      break;
  }

  return $result;
}

function calcPercentage($a, $b){
  if ($b == 0) {
    $result = 0;
    return $result;
  }else{
    $result = ($a/$b) * 100;
    return ceil($result);
  }
}

function get_array_from_obj($object = [], $attr=''){
  $array = [];
  if (is_array($object)) {
    foreach ($object as $obj) {
      $array[] = $obj->$attr;
    }
    return $array;
  } else {
    $array[] = $obj->$attr;
  }
  
  return $array;
}

function waybill_format($transact){
  
  $source = Branch::find_by_id(Admin::find_by_id($transact->createdBy)->city) ? h( Branch::find_by_id(Admin::find_by_id($transact->createdBy)->city)->name) : "N/A";
  $waybill = $transact->wayBillNum;
  $dest = Branch::find_by_id($transact->branch) ? h( Branch::find_by_id($transact->branch)->name) : "N/A" ;
  
  return "{$source}-{$waybill}-{$dest}";

}

function route_format($transact){
  
//   $source = Branch::find_by_id(Admin::find_by_id($transact->createdBy)->city) ? h( Branch::find_by_id(Admin::find_by_id($transact->createdBy)->city)->long_name) : State::find_by_id($transact->AssociatedRouteOriginating)->name;

//   $dest = Branch::find_by_id($transact->branch) ? h( Branch::find_by_id($transact->branch)->long_name) : State::find_by_id($transact->AssociatedRouteDestination)->name ;
  
//   return "{$source} --> {$dest}";

  $createdBy = $transact->createdBy ?? '';
  $branch = $transact->branch ?? '';
  // $transact->createdBy = $transact->createdBy ?? '';

  $getAdminCity = Admin::find_by_id($createdBy) ? Admin::find_by_id($createdBy)->city : '';
  
  $source = Branch::find_by_id($getAdminCity) ? h( Branch::find_by_id(Admin::find_by_id($createdBy)->city)->long_name) : State::find_by_id($transact->AssociatedRouteOriginating)->name;

  $dest = Branch::find_by_id($branch) ? h( Branch::find_by_id($branch)->long_name) : State::find_by_id($transact->AssociatedRouteDestination)->name ;
  
  return "{$source} --> {$dest}";

}

function m_route_format($source, $dest){
  
  $source = Branch::find_by_id($source) ? h( Branch::find_by_id($source)->long_name) : "N/A";

  $dest = Branch::find_by_id($dest) ? h( Branch::find_by_id($dest)->long_name ) : "N/A" ;
  
  return "{$source} --> {$dest}";

}

function find_branches_from_route_format($mformat){

  $formatExplode = explode(" --> ", $mformat);
  if (count($formatExplode) == 2) {
    $source = Branch::find_by_longname($formatExplode[0]) ? Branch::find_by_longname($formatExplode[0]) : '';
    $destination = Branch::find_by_longname($formatExplode[1]) ? Branch::find_by_longname($formatExplode[1]) : '';
    if ($source && $destination) {
      return [$source, $destination];
    } else {
      return false;
    }

  } else {
    return false;
  }

}


  function split_date_for_manifest_no($manifestNo){
    $arr = str_split($manifestNo);
                         
    $mannifest_date = h($arr[0].$arr[1].$arr[2].$arr[3].'-'.$arr[4].$arr[5].'-'.$arr[6].$arr[7].' '.$arr[8].$arr[9].':'.$arr[10].$arr[11].':'.$arr[12].$arr[13]);

    return $mannifest_date;
  }

  function pre_r($array) {
    echo '<pre class="text-info">';
    $printer = print_r($array);
    echo '</pre>';
    return $printer; 
  }











  /**
 * Register our sidebars and widgetized areas.
 */
// function mdb_widgets_init() {

//   register_sidebar( array(
//     'name'          => 'Sidebar',
//     'id'            => 'sidebar',
//     'before_widget' => '',
//     'after_widget'  => '',
//     'before_title'  => '',
//     'after_title'   => '',
//   ) );

// }
// add_action( 'widgets_init', 'mdb_widgets_init' );
?>
