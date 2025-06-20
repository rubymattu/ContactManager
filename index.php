<?php
session_start();

if (!isset($_SESSION['isLoggedIn'])) {
  header('Location: login_form.php');
  die();
}

require('database.php');

// Join contacts and types tables to get typeName
$queryContacts = '
  SELECT contacts.*, contactTypes.typeName
  FROM contacts
  JOIN contactTypes ON contacts.typeID = contactTypes.typeID
';
$statement1 = $db->prepare($queryContacts);
$statement1->execute();
$contacts = $statement1->fetchAll();
$statement1->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
<head>  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Manager - Home</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
  <?php include 'header.php'; ?>
  <main>
    <div id="top">
      <h2>Contact List</h2>
      <div id="topRight">
        <p>Welcome, <span id="name"><?php echo $_SESSION['userName']; ?></span></p> 
        <a href="logout.php" id="logout">Log Out</a>  
      </div>   
    </div>    
    <table>
      <tr>
        <th>Photo</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email Address</th>
        <th>Phone Number</th>
        <th>Status</th>
        <th>Birth Date</th>
        <th>Contact Type</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th> 
      </tr>
      <?php foreach ($contacts as $contact) : ?>
        <tr>
          <td><img src="<?php echo htmlspecialchars('./images/' . $contact['imageName']); ?>" alt="<?php echo htmlspecialchars($contact['imageName']); ?>"/></td>
          <td><?php echo htmlspecialchars($contact['firstName']); ?></td>
          <td><?php echo htmlspecialchars($contact['lastName']); ?></td>
          <td><?php echo htmlspecialchars($contact['emailAddress']); ?></td>
          <td><?php echo htmlspecialchars($contact['phoneNumber']); ?></td>
          <td><?php echo htmlspecialchars($contact['status']); ?></td>
          <td><?php echo htmlspecialchars($contact['dob']); ?></td>
          <td><?php echo htmlspecialchars($contact['typeName']); ?></td>
          <td>
            <form action="update_contact_form.php" method="post">
              <input type="hidden" name="contactID" value="<?php echo $contact['contactID']; ?>"/>
              <input type="submit" value="Update"/>
            </form>
          </td>
          <td>
            <form action="delete_contact.php" method="post">
              <input type="hidden" name="contactID" value="<?php echo $contact['contactID']; ?>"/>
              <input type="submit" value="Delete"/>
            </form>
          </td>
          <td>
            <form action="view_details.php" method="post">
              <input type="hidden" name="contactID" value="<?php echo $contact['contactID']; ?>"/>
              <input type="submit" value="View"/>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
    <p><a href="add_contact_form.php">Add New Contact</a></p>
  </main>
  <?php include 'footer.php'; ?>
</body>
</html>
