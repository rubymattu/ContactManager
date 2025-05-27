<?php
  session_start();
  require('database.php');
  $queryContacts = 'SELECT * FROM contacts';
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
  <?php
  // Include the header file
  include 'header.php';
  ?>
  <main>
    <h2>Contact List</h2>
    <table>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email Address</th>
          <th>Phone Number</th>
          <th>Status</th>
          <th>Birth Date</th>
          <th>&nbsp;</th> <!--  for the edit button -->
          <th>&nbsp;</th> <!--  for the delete button -->
        </tr>
        <?php foreach ($contacts as $contact) : ?>
          <tr>
            <td><?php echo $contact['firstName']; ?></td>
            <td><?php echo $contact['lastName']; ?></td>
            <td><?php echo $contact['emailAddress']; ?></td>
            <td><?php echo $contact['phoneNumber']; ?></td>
            <td><?php echo $contact['status']; ?></td>
            <td><?php echo $contact['dob']; ?></td>
            <td>
              <form action='contact_update_form.php' method='post'>
                <input type='hidden' name='contactID' value='<?php echo $contact['contactID']; ?>'/>
                <input type='submit' value='Update'/>
              </form>
            </td><!-- Edit button -->
            <td>
              <form action='delete_contact.php' method='post'>
                <input type='hidden' name='contactID' value='<?php echo $contact['contactID']; ?>'/>
                <input type='submit' value='Delete'/>
              </form>
            </td><!-- Delete button -->
          </tr>
          <?php endforeach; ?>
      </table>
      <p><a href='add_contact_form.php'>Add New Contact</a></p>
  </main>
  <?php
  // Include the footer file
  include 'footer.php';
  ?>
</body>
</html>