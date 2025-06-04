<?php
  session_start();

  $contactID = filter_input(INPUT_POST, 'contactID', FILTER_VALIDATE_INT);
  $firstName = filter_input(INPUT_POST, 'firstName');
  $lastName = filter_input(INPUT_POST, 'lastName');
  $emailAddress = filter_input(INPUT_POST, 'emailAddress');
  $phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
  $status = filter_input(INPUT_POST, 'status');
  $dob = filter_input(INPUT_POST, 'dob');
  $typeID = filter_input(INPUT_POST, 'typeID', FILTER_VALIDATE_INT);

  require_once('database.php');

  $queryContacts = 'SELECT * FROM contacts';
  $statement1 = $db->prepare($queryContacts);
  $statement1->execute();
  $contacts = $statement1->fetchAll();
  $statement1->closeCursor();

  foreach ($contacts as $contact) {
      if ($emailAddress == $contact['emailAddress'] &&  $contactID != $contact['contactID']) {
          $_SESSION['error'] = 'Email address already exists.';
          header('Location: error.php');
          die();
      }
  }

  if ($firstName == null || $lastName == null || $emailAddress == null || 
      $phoneNumber == null || $status == null || $dob == null || $typeID == null) {
      $_SESSION['error'] = 'Please fill in all required fields.';
      header('Location: error.php');
      die();
  } else {
      $query = 'UPDATE contacts
                SET firstName = :firstName, lastName = :lastName, 
                    emailAddress = :emailAddress, phoneNumber = :phoneNumber, 
                    status = :status, dob = :dob, typeID = :typeID
                WHERE contactID = :contactID';
      $statement = $db->prepare($query);
      $statement->bindValue(':firstName', $firstName);
      $statement->bindValue(':lastName', $lastName);
      $statement->bindValue(':emailAddress', $emailAddress);
      $statement->bindValue(':phoneNumber', $phoneNumber);    
      $statement->bindValue(':status', $status);
      $statement->bindValue(':dob', $dob);
      $statement->bindValue(':typeID', $typeID);
      $statement->bindValue(':contactID', $contactID);
      $statement->execute();
      $statement->closeCursor();
  }

  $_SESSION['fullName'] = $firstName . ' ' . $lastName;
  header('Location: update_confirmation.php');
  die();
?>
