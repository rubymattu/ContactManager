<?php
  require_once('database.php');
  session_start();
  // Get the contactID from the form submission
  $contactID = filter_input(INPUT_POST, 'contactID', FILTER_VALIDATE_INT);
  if ($contactID != false) {
    // Prepare the SQL statement to delete the contact
    $query = 'DELETE FROM contacts WHERE contactID = :contactID';
    $statement = $db->prepare($query);
    $statement->bindValue(':contactID', $contactID);
    $statement->execute();
    $statement->closeCursor();
    // Redirect to the main page after deletion
    header('Location: index.php');
  }
  // reload the index page
  header('Location: index.php');  
  die();

?>