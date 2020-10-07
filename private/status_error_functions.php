<?php

function require_login() {
  global $session;
  if(!$session->is_logged_in()) {
    redirect_to(url_for('/index.php'));
  } elseif ($session->is_logged_in() && !empty($session->user_id)) {
    redirect_to(url_for('/index.php')); //to redirects riders from admin pages
  }elseif ($session->is_logged_in() && !empty($session->clientcat)) {
    redirect_to(url_for('/index.php')); //to redirects customers from admin page
  }
}

function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class=\"errors wow flash infinite text-danger animated\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach($errors as $error) {
      if (is_array($error)) {
        foreach ($error as $err) {
          $output .= "<li>" . h($err) . "</li>";
        }
      }else{
        $output .= "<li>" . h($error) . "</li>";
      }
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function display_session_message() {
  global $session;
  $msg = $session->message();
  if(isset($msg) && $msg != '') {
    $session->clear_message();
    return '<div class="alert alert-success alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>' . h($msg) . '</strong></div>';
  }
}

function require_login_user() {
  global $session;
  if(!$session->is_logged_in()) {
    redirect_to(url_for('/login.php'));
  } elseif ($session->is_logged_in() && empty($session->user_id)) {
    redirect_to(url_for('/login.php')); //to redirects other users from riders pages
  }
}

function require_login_customer() {
  global $session;
  if(!$session->is_logged_in()) {
    redirect_to(url_for('/customer/login.php'));
  } elseif ($session->is_logged_in() && !empty($session->user_id)) {
    redirect_to(url_for('/customer/login.php')); //to redirects riders from customers page
  }
}

?>
