<?php
require_once('database.php');
require_once('image_util.php');

$contactID = filter_input(INPUT_POST, 'contactID', FILTER_VALIDATE_INT);

// Get the contact
$query = 'SELECT * FROM contacts WHERE contactID = :contactID';
$statement = $db->prepare($query);
$statement->bindValue(':contactID', $contactID);
$statement->execute();
$contact = $statement->fetch();
$statement->closeCursor();

// Get contact types for the dropdown
$queryTypes = 'SELECT * FROM contactTypes';
$typeStatement = $db->prepare($queryTypes);
$typeStatement->execute();
$types = $typeStatement->fetchAll();
$typeStatement->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
<head>  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Manager - Update Contact</title>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php include 'header.php'; ?>
<main>
  <h2>Update Contact</h2>
  <form action="update_contact.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="contactID" value="<?php echo $contact['contactID']; ?>">

    <label>First Name:</label>
    <input type="text" name="firstName" value="<?php echo $contact['firstName']; ?>" required><br>

    <label>Last Name:</label>
    <input type="text" name="lastName" value="<?php echo $contact['lastName']; ?>" required><br>

    <label>Email Address:</label>
    <input type="email" name="emailAddress" value="<?php echo $contact['emailAddress']; ?>" required><br>

    <label>Phone Number:</label>
    <input type="tel" name="phoneNumber" value="<?php echo $contact['phoneNumber']; ?>"><br>

    <label>Status:</label>
    <input type="radio" name="status" value="member" <?php echo ($contact['status'] == 'member') ? 'checked' : ''; ?>>Member
    <input type="radio" name="status" value="nonmember" <?php echo ($contact['status'] == 'nonmember') ? 'checked' : ''; ?>>Non-Member<br>

    <label>Date of Birth:</label>
    <input type="date" name="dob" value="<?php echo $contact['dob']; ?>"><br>

    <label>Contact Type:</label>
    <select name="typeID" required>
      <?php foreach ($types as $type): ?>
        <option value="<?php echo $type['typeID']; ?>" <?php if ($type['typeID'] == $contact['typeID']) echo 'selected'; ?>>
          <?php echo htmlspecialchars($type['typeName']); ?>
        </option>
      <?php endforeach; ?>
    </select><br>

    <label>Update Photo (optional):</label>
    <input type="file" name="image"><br>
    <small>Current: <?php echo htmlspecialchars($contact['imageName']); ?></small><br>

    <input type="submit" value="Save Contact">
  </form>
  <p><a href="index.php">Back to Contact List</a></p>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
