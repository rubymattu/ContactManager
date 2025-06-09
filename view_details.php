<?php
require_once('database.php');

$contactID = filter_input(INPUT_POST, 'contactID', FILTER_VALIDATE_INT);

if (!$contactID) {
    echo $contactID ? "Invalid contact ID." : "Contact ID is required.";
    exit();
}

$query = 'SELECT * FROM contacts WHERE contactID = :contactID';
$statement = $db->prepare($query);
$statement->bindValue(':contactID', $contactID);
$statement->execute();
$contact = $statement->fetch();
$statement->closeCursor();

if (!$contact) {
    echo "Contact not found.";
    exit();
}

// Get _400 image version
$imageName = $contact['imageName'];
$image_400 = str_replace('_100', '_400', $imageName);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Details</title>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php include 'header.php'; ?>
<main style="width: 60%;">
  <h2>Contact Details</h2>
<div class="contact-details-container">
  <div class="contact-image">
    <?php
    // Convert _100 image name to _400 version
    $imageName400 = str_replace('_100', '_400', $contact['imageName']);
    ?>
    <img src="images/<?php echo $imageName400; ?>" alt="Contact Photo">
  </div>
  <div class="contact-info">
    <h2><?php echo htmlspecialchars($contact['firstName'] . ' ' . $contact['lastName']); ?></h2>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($contact['emailAddress']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($contact['phoneNumber']); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($contact['status']); ?></p>
    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($contact['dob']); ?></p>
    <p><strong>Contact Type:</strong> <?php echo htmlspecialchars($contact['typeName']); ?></p>
    <a href="index.php">← Back to Contact List</a>
  </div>
</div>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
