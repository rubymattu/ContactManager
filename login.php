<?php
 session_start();

  //get data from the form
//   $imageName = $_FILES['file1']['name'];
  $user_name = filter_input(INPUT_POST, 'user_name');
  $password = filter_input(INPUT_POST, 'password');
  $_SESSION['pass'] = $password;

  //alternative way to get data from the form
  // $firstName = $_POST['firstName'];
  // $lastName = $_POST['lastName'];
  // $emailAddress = $_POST['emailAddress'];
  // $phoneNumber = $_POST['phoneNumber'];
  // $status = $_POST['status'];
  // $dob = $_POST['dob'];


  require_once('database.php');

  $queryLogin = 'SELECT password FROM registrations
                  WHERE userName = :userName';
  $statement1 = $db->prepare($queryLogin);
  $statement1->bindValue(':userName', $user_name);
  $statement1->execute();
  $login = $statement1->fetch();
  $hash = $login['password'];
  $statement1->closeCursor();

  $_SESSION['isLoggedIn'] = password_verify($_SESSION['pass'], $hash);

  if ($_SESSION['isLoggedIn'] == true) {
    $_SESSION['userName'] = $user_name;
    $_SESSION['password'] = $password;
    $_SESSION['hash'] = $hash;

    // redirect to login confirmation
    header('Location: index.php');
    die();
  } elseif ($_SESSION['isLoggedIn'] == false) {
      $_SESSION = [];
      session_destroy();

      // redirect to login
      header('Location: login_form.php');
      die();
  } else {
    $_SESSION = [];
      session_destroy();

      // redirect to login
      header('Location: login_form.php');
      die();
  }
?>