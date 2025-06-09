<?php
session_start();

require_once('database.php');
require_once('image_util.php');

// Get form inputs (aligned with form field names)
$contactID = filter_input(INPUT_POST, 'contactID', FILTER_VALIDATE_INT);
$firstName = filter_input(INPUT_POST, 'firstName');
$lastName = filter_input(INPUT_POST, 'lastName');
$emailAddress = filter_input(INPUT_POST, 'emailAddress');
$phoneNumber = filter_input(INPUT_POST, 'phoneNumber');
$status = filter_input(INPUT_POST, 'status');
$dob = filter_input(INPUT_POST, 'dob');
$typeID = filter_input(INPUT_POST, 'typeID', FILTER_VALIDATE_INT);
$image = $_FILES['image'] ?? null; // changed from 'file1' to 'image'

$image_dir = 'images/';
$image_dir_path = getcwd() . DIRECTORY_SEPARATOR . $image_dir;

// Get current contact to retrieve old image name
$query = 'SELECT * FROM contacts WHERE contactID = :contactID';
$statement = $db->prepare($query);
$statement->bindValue(':contactID', $contactID);
$statement->execute();
$contact = $statement->fetch();
$statement->closeCursor();

$oldImageName = $contact['imageName'];
$imageName = $oldImageName;

// Check for duplicate email
$queryContacts = 'SELECT * FROM contacts';
$statement1 = $db->prepare($queryContacts);
$statement1->execute();
$contacts = $statement1->fetchAll();
$statement1->closeCursor();

foreach ($contacts as $c) {
    if ($emailAddress == $c["emailAddress"] && $contactID != $c["contactID"]) {
        $_SESSION["error"] = "Duplicate Email Address. Try again.";
        header("Location: error.php");
        exit();
    }
}

// Validate required fields
if (
    empty($firstName) || empty($lastName) || empty($emailAddress) ||
    empty($phoneNumber) || empty($dob) || !$typeID
) {
    $_SESSION["error"] = "Please fill in all required fields.";
    header("Location: error.php");
    exit();
}

// Handle new image upload
if ($image && $image['error'] === UPLOAD_ERR_OK) {
    $filename = basename($image['name']);
    $target = $image_dir_path . $filename;
    move_uploaded_file($image['tmp_name'], $target);

    // Process image
    process_image($image_dir_path, $filename);

    // Generate _100 name
    $dot = strrpos($filename, '.');
    $imageName100 = substr($filename, 0, $dot) . '_100' . substr($filename, $dot);
    $imageName = $imageName100;

    // Delete old images if not placeholder
    if ($oldImageName !== 'placeholder_100.jpg') {
        $base = substr($oldImageName, 0, strrpos($oldImageName, '_100'));
        $ext = substr($oldImageName, strrpos($oldImageName, '.'));
        $filesToDelete = [
            $base . $ext,
            $base . '_100' . $ext,
            $base . '_400' . $ext
        ];

        foreach ($filesToDelete as $file) {
            $path = $image_dir_path . DIRECTORY_SEPARATOR . $file;
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}

// Update contact
$update_query = '
    UPDATE contacts
    SET firstName = :firstName,
        lastName = :lastName,
        emailAddress = :emailAddress,
        phoneNumber = :phoneNumber,
        status = :status,
        dob = :dob,
        typeID = :typeID,
        imageName = :imageName
    WHERE contactID = :contactID';

$statement = $db->prepare($update_query);
$statement->bindValue(':firstName', $firstName);
$statement->bindValue(':lastName', $lastName);
$statement->bindValue(':emailAddress', $emailAddress);
$statement->bindValue(':phoneNumber', $phoneNumber);
$statement->bindValue(':status', $status);
$statement->bindValue(':dob', $dob);
$statement->bindValue(':typeID', $typeID);
$statement->bindValue(':imageName', $imageName);
$statement->bindValue(':contactID', $contactID);
$statement->execute();
$statement->closeCursor();

// Confirmation
$_SESSION["fullName"] = $firstName . " " . $lastName;
header("Location: update_confirmation.php");
exit();
?>
