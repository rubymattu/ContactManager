<?php
 echo '<pre>';
print_r($_POST);
echo '</pre>';
 session_start();


  //get data from the form
//   $imageName = $_FILES['file1']['name'];
  $user_name = filter_input(INPUT_POST, 'user_name');
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
  if ($user_name === null || $password === null) {
      //redirect to the error page
      $_SESSION['error'] = 'Please fill in all required fields.' . $user_name . $password;
      header('Location: error.php');
      die();
  } else {
          //insert data into the database
      $query = 'INSERT INTO registrations
                  (userName, password)
                VALUES
                  ( :userName, :password)';
      $statement = $db->prepare($query);

      $statement->bindValue(':userName', $user_name);
      $statement->bindValue(':password', $hash);
      $statement->execute();
      $statement->closeCursor();
  }
  $_SESSION['isLoggedIn'] = 1;
  $_SESSION['userName'] = $user_name;
  //redirect to the confirmation page
  header('Location: register_confirmation.php');
  die();
?>