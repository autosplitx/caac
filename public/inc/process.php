<?php require_once('../../private/initialize.php'); ?>

<?php
// ========== TO SIGN UP ==========
if (isset($_POST['username']) && isset($_POST['email'])) {
  $rand = rand(1, 2);

  $args = [
    'full_name' => $_POST['full_name'],
    'username' => $_POST['username'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'qualification' => $_POST[' qualification'],
    // 'password' => $_POST['password'],
    // 'qualification' => $_POST[' qualification'],
    'gender' => $_POST['gender'],
    'profile_img' => $_POST['profile_img'] ?? 'user1.png'
  ];
  // pre_r($args);

  if ($rand == 1)
    $args['profile_img'] = 'user1.png';
  elseif ($rand == 2)
    $args['profile_img'] = 'user2.png';

  $users = new Users($args);

  // pre_r($users);

  $result = $users->save();

  if ($users->save()) {

    echo 'You have successfully registered :)';
    // redirect_to(url_for('/inventory/index.php'));
  } else {
    echo display_errors($users->errors);
  }

  exit();
}


// ========== TO LOGIN ==========
if (isset($_POST['email']) and isset($_POST['password'])) {

  $args = [
    'email'     => $_POST['email'] ?? '',
    'password'  => $_POST['password'] ?? ''
  ];

  // Validations
  if (is_blank($args['email'])) {
    $errors[] = "E-mail cannot be blank.";
  }
  if (is_blank($args['password'])) {
    $errors[] = "Password cannot be blank.";
  }

  if (empty($errors)) {
    $user = Users::find_by_email($args['email']);

    if ($user != false && $user->verify_password($args['password'])) {

      $session->logout();
      $session->logout('', true);

      if ($session->login($user, '', true)) {

        log_action('Login', "{$user->full_name} Logged in.", "login");

        // redirect_to(url_for('/staff/admins/dashboard.php'));
      }
    } else {
      echo '<b class="text-danger">Log in was unsuccessful.</b>';
    }
  }

  exit();
}
// ========== TO LOGIN END==========

// ========== FETCH RECORD FROM THE DB ========== 
if (isset($_POST['fetchData'])) {
  $sn = 1;
  foreach (Users::find_by_undeleted() as $user) { ?>
    <tr>
      <!-- <td><input type="checkbox"></td> -->
      <th style="font-weight:bold;font-size:11px;" scope="row"><?php echo $sn++; ?></th>
      <td style="font-weight:bold;font-size:11px;"><?php echo ucwords($user->full_name); ?></td>
      <td style="font-weight:bold;font-size:11px;"><?php echo ucwords($user->username); ?></td>
      <td style="font-weight:bold;font-size:11px;"><?php echo ucwords($user->email); ?></td>
      <td style="font-weight:bold;font-size:11px;"><?php echo ucwords($user->phone); ?></td>
      <td style="font-weight:bold;font-size:11px;"><?php echo date('Y-m-d', strtotime($user->created_at)); ?></td>
      <td style="font-weight:bold;font-size:11px;">
        <button class="btn btn-sm m-0 waves-effect" id="btn_edit" data-id="<?php echo $user->id; ?>" data-toggle="modal" data-target=".updateUser"><i class="fa fa-edit text-warning"></i></button>
        <button class="btn btn-sm m-0 waves-effect" id="btn_delete" data-id="<?php echo $user->id; ?>"><i class="fa fa-trash-o text-danger"></i></button>
      </td>
    </tr>
<?php }
  // echo json_encode(['status' => 'success']);
  exit();
}
// ========== FETCH RECORD FROM THE DB ========== 

// ========== UPDATE RECORD FROM THE DB ========== 

if (isset($_POST['updateData'])) {
  $id = $_POST['id'];
  $get_update = Users::find_by_id($id);
  exit(json_encode(['status' => 'success', 'response' => $get_update]));
}

if (isset($_POST['edit'])) {
  $id = $_POST['id'];
  $edit_user = Users::find_by_id($id);
  $args = [
    'full_name' => $_POST['full_name'],
    'username' => $_POST['username'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'gender' => $_POST['gender']
  ];

  $edit_user->merge_attributes($args);
  $result = $edit_user->save();

  exit(json_encode(['status' => 'success', 'response' => 'User updated successfully']));
}
// ========== UPDATE RECORD FROM THE DB ========== 






?>