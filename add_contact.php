<?php
 session_start();

    require_once 'image_util.php'; // the process_image function

    $image_dir = 'images';
    $image_dir_path = getcwd() . DIRECTORY_SEPARATOR . $image_dir;

    if (isset($_FILES['file1']))
    {
        $filename = $_FILES['file1']['name'];

        if (!empty($filename))
        {
            $source = $_FILES['file1']['tmp_name'];

            $target = $image_dir_path . DIRECTORY_SEPARATOR . $filename;

            move_uploaded_file($source, $target);

            // create the '400' and '100' versions of the image
            process_image($image_dir_path, $filename);
        }
    }

  //get data from the form
//   $imageName = $_FILES['file1']['name'];
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

  $file_name = $_FILES['file1']['name'];

    // adjust the filename
    $i = strrpos($filename, '.');
    $image_name = substr($filename, 0, $i);
    $ext = substr($filename, $i);

    $image_name_100 = $image_name . '_100' . $ext;

  require_once('database.php');

  $queryContacts = 'SELECT * FROM contacts';
  $statement1 = $db->prepare($queryContacts);
  $statement1->execute();
  $contacts = $statement1->fetchAll();
  $statement1->closeCursor();

  foreach ($contacts as $contact) {
      if ($contact['emailAddress'] == $emailAddress) {
          $_SESSION['error'] = 'Email address already exists.';
          header('Location: error.php');
          die();
      }
  }
  //validate the data
  if ($firstName == null || $lastName == null || $emailAddress == null || 
      $phoneNumber == null || $status == null || $dob == null) {

      //redirect to the error page
      $_SESSION['error'] = 'Please fill in all required fields.';
      header('Location: error.php');
      die();
  } else {
          //insert data into the database
      $query = 'INSERT INTO contacts
                  (imageName, firstName, lastName, emailAddress, phoneNumber, status, dob)
                VALUES
                  (:imageName, :firstName, :lastName, :emailAddress, :phoneNumber, :status, :dob)';
      $statement = $db->prepare($query);
      $statement->bindValue(':imageName', $image_name_100);
      $statement->bindValue(':firstName', $firstName);
      $statement->bindValue(':lastName', $lastName);
      $statement->bindValue(':emailAddress', $emailAddress);
      $statement->bindValue(':phoneNumber', $phoneNumber);
      $statement->bindValue(':status', $status);
      $statement->bindValue(':dob', $dob);
      $statement->execute();
      $statement->closeCursor();
  }
  
  $_SESSION['fullName'] = $firstName . ' ' . $lastName;
  //redirect to the confirmation page
  header('Location: confirmation.php');
  die();
?>