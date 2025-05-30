<?php
  session_start();
  $contactID = filter_input(INPUT_POST, 'contactID', FILTER_VALIDATE_INT);
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

  $queryContacts = 'SELECT * FROM contacts';
  $statement1 = $db->prepare($queryContacts);
  $statement1->execute();
  $contacts = $statement1->fetchAll();
  $statement1->closeCursor();

  foreach ($contacts as $contact) {
      if ($emailAddress == $contact['emailAddress'] &&  $contactID != $contact['contactID']) {
          //set an error message in the session
          $_SESSION['error'] = 'Email address already exists.';
          header('Location: error.php');
          die();
      }
  }
  //validate the data
  if ($firstName == null || $lastName == null || $emailAddress == null || 
      $phoneNumber == null || $status == null || $dob == null) {
      //set an error message in the session
      session_start();
      //redirect to the error page
      $_SESSION['error'] = 'Please fill in all required fields.';
      header('Location: error.php');
      die();
  } else {
      require_once('database.php');
      //update data in the database
      $query = 'UPDATE contacts
                SET firstName = :firstName, lastName = :lastName, 
                    emailAddress = :emailAddress, phoneNumber = :phoneNumber, 
                    status = :status, dob = :dob
                WHERE contactID = :contactID';
      $statement = $db->prepare($query);
      $statement->bindValue(':firstName', $firstName);
      $statement->bindValue(':lastName', $lastName);
      $statement->bindValue(':emailAddress', $emailAddress);
      $statement->bindValue(':phoneNumber', $phoneNumber);    
      $statement->bindValue(':status', $status);
      $statement->bindValue(':dob', $dob);
      $statement->bindValue(':contactID', $contactID);
      $statement->execute();
      $statement->closeCursor();
  }
  
  $_SESSION['fullName'] = $firstName . ' ' . $lastName;
  //redirect to the confirmation page
  header('Location: update_confirmation.php');
  die();
?>