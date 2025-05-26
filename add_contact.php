<?php
  session_start();

  //get data from the form
  $firstName = filter_input(INPUT_POST, 'firstName');
  $lastName = filter_input(INPUT_POST, 'lastName');
  $emailAddress = filter_input(INPUT_POST, 'emailAddress');
  $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
  $status = filter_input(INPUT_POST, 'status');
  $dob = filter_input(INPUT_POST, 'dob');

  //alternative way to get data from the form
  // $firstName = $_POST['firstName'];
  // $lastName = $_POST['lastName'];
  // $emailAddress = $_POST['emailAddress'];
  // $phoneNumber = $_POST['phoneNumber'];
  // $status = $_POST['status'];
  // $dob = $_POST['dob'];

  require_once('database.php');
  //insert data into the database
  $query = 'INSERT INTO contacts
               (firstName, lastName, emailAddress, phoneNumber, status, dob)
            VALUES
               (:firstName, :lastName, :emailAddress, :phoneNumber, :status, :dob)';
  $statement = $db->prepare($query);
  $statement->bindValue(':firstName', $firstName);
  $statement->bindValue(':lastName', $lastName);
  $statement->bindValue(':emailAddress', $emailAddress);
  $statement->bindValue(':phoneNumber', $phoneNumber);
  $statement->bindValue(':status', $status);
  $statement->bindValue(':dob', $dob);
  $statement->execute();
  $statement->closeCursor();
  
  $_SESSION['fullName'] = $firstName . ' ' . $lastName;
  //redirect to the confirmation page
  header('Location: confirmation.php');
  die();
?>