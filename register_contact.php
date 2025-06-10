<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();
  require_once('message.php');

  //get data from the form
//   $imageName = $_FILES['file1']['name'];
  $user_name = filter_input(INPUT_POST, 'user_name');
  $emailAddress = filter_input(INPUT_POST, 'emailAddress');
  $password = filter_input(INPUT_POST, 'password');
  $hash = password_hash($password, PASSWORD_DEFAULT);

  //alternative way to get data from the form
  // $firstName = $_POST['firstName'];
  // $lastName = $_POST['lastName'];
  // $emailAddress = $_POST['emailAddress'];
  // $phoneNumber = $_POST['phoneNumber'];
  // $status = $_POST['status'];
  // $dob = $_POST['dob'];


  require_once('database.php');

  $queryRegistrations = 'SELECT * FROM registrations';
  $statement1 = $db->prepare($queryRegistrations);
  $statement1->execute();
  $registrations = $statement1->fetchAll();
  $statement1->closeCursor();

  foreach ($registrations as $registration) {
      if ($registration['userName'] == $user_name) {
          $_SESSION['error'] = 'Username already exists.';
          header('Location: error.php');
          die();
      }
  }
  //validate the data
  if ($user_name === null || $emailAddress === null || $password === null) {
      //redirect to the error page
      $_SESSION['error'] = 'Please fill in all required fields.';
      header('Location: error.php');
      die();
  } else {
          //insert data into the database
      $query = 'INSERT INTO registrations
                  (userName, password, emailAddress)
                VALUES
                  ( :userName, :password, :emailAddress)';
      $statement = $db->prepare($query);

      $statement->bindValue(':userName', $user_name);
      $statement->bindValue(':emailAddress', $emailAddress);
      $statement->bindValue(':password', $hash);
      $statement->execute();
      $statement->closeCursor();

  }
  $_SESSION['isLoggedIn'] = 1;
  $_SESSION['userName'] = $user_name;
  
  //send email to the user
  $to_address = $emailAddress;
  $to_name = $user_name;
  $from_address = 'harnoor070695@gmail.com';
  $from_name = 'Contact Manager';
  $subject = 'Registration Confirmation';
  $body = "<p>Dear $to_name</p>
          <p>Thank you for registering with Contact Manager.</p>
          <p>Best regards,</p>
          <p>Contact Manager Team</p>";

  $is_body_html = true;
  try {
      send_email($to_address, $to_name, $from_address, $from_name, $subject, $body, $is_body_html);
  } catch (Exception $e) {
      $_SESSION['error'] = 'Error sending email: ' . htmlspecialchars($e->getMessage());
      header('Location: error.php');
      die();
  }
  //redirect to the confirmation page
  header('Location: register_confirmation.php');
  die();
?>