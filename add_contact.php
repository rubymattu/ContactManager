<?php
session_start();

require_once 'image_util.php';
require_once 'database.php';

$image_dir = 'images';
$image_dir_path = getcwd() . DIRECTORY_SEPARATOR . $image_dir;

// Handle image upload
$filename = $_FILES['file1']['name'] ?? '';
if (!empty($filename)) {
    $source = $_FILES['file1']['tmp_name'];
    $target = $image_dir_path . DIRECTORY_SEPARATOR . $filename;
    move_uploaded_file($source, $target);
    process_image($image_dir_path, $filename);
    $i = strrpos($filename, '.');
    $image_name = substr($filename, 0, $i);
    $ext = substr($filename, $i);
    $image_name_100 = $image_name . '_100' . $ext;
} else {
    $image_name_100 = ''; // Default or handle empty image case
}

// Get form data
$firstName = filter_input(INPUT_POST, 'firstName');
$lastName = filter_input(INPUT_POST, 'lastName');
$emailAddress = filter_input(INPUT_POST, 'emailAddress');
$phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
$status = filter_input(INPUT_POST, 'status');
$dob = filter_input(INPUT_POST, 'dob');
$typeID = filter_input(INPUT_POST, 'typeID', FILTER_VALIDATE_INT);

// Validate required fields
if (
    empty($firstName) || empty($lastName) || empty($emailAddress) ||
    empty($phoneNumber) || empty($status) || empty($dob) || !$typeID
) {
    $_SESSION['error'] = 'Please fill in all required fields.';
    header('Location: error.php');
    die();
}

// Check for duplicate email
$queryContacts = 'SELECT * FROM contacts WHERE emailAddress = :emailAddress';
$statement1 = $db->prepare($queryContacts);
$statement1->bindValue(':emailAddress', $emailAddress);
$statement1->execute();
$existingContact = $statement1->fetch();
$statement1->closeCursor();

if ($existingContact) {
    $_SESSION['error'] = 'Email address already exists.';
    header('Location: error.php');
    die();
}

// Insert contact into database
$query = 'INSERT INTO contacts
          (imageName, firstName, lastName, emailAddress, phoneNumber, status, dob, typeID)
          VALUES
          (:imageName, :firstName, :lastName, :emailAddress, :phoneNumber, :status, :dob, :typeID)';
$statement = $db->prepare($query);
$statement->bindValue(':imageName', $image_name_100);
$statement->bindValue(':firstName', $firstName);
$statement->bindValue(':lastName', $lastName);
$statement->bindValue(':emailAddress', $emailAddress);
$statement->bindValue(':phoneNumber', $phoneNumber);
$statement->bindValue(':status', $status);
$statement->bindValue(':dob', $dob);
$statement->bindValue(':typeID', $typeID);
$statement->execute();
$statement->closeCursor();

$_SESSION['fullName'] = $firstName . ' ' . $lastName;
header('Location: confirmation.php');
die();
?>
