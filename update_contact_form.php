
<?php
  require_once('database.php');
  // Get the contactID from the form submission
  $contactID = filter_input(INPUT_POST, 'contactID', FILTER_VALIDATE_INT);

  // select the contact from the database
  $query = 'SELECT * FROM contacts WHERE contactID = :contactID';
  $statement = $db->prepare($query);
  $statement->bindValue(':contactID', $contactID);
  $statement->execute();
  $contact = $statement->fetch();
  $statement->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
<head>  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Manager - Update Contact<</title>
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
    <h2>Update Contact</h2>
    <form action="update_contact.php" method="post" id="updateContactForm" enctype="multipart/form-data">
      <div id="formData">
      <input type="hidden" name="contactID" value="<?php echo $contact['contactID']; ?>">

      <label for="firstName">First Name:</label>
      <input type="text" name="firstName" required value="<?php echo $contact['firstName'] ?>"><br> 

      <label for="lastName">Last Name:</label>
      <input type="text" name="lastName" required value="<?php echo $contact['lastName'] ?>"><br>

      <label for="emailAddress">Email Address:</label>
      <input type="email" id="emailAddress" name="emailAddress" required value="<?php echo $contact['emailAddress'] ?>"><br>

      <label for="phoneNumber">Phone Number:</label>
      <input type="tel" name="phoneNumber" value="<?php echo $contact['phoneNumber'] ?>"><br>

      <label for="status">Status:</label>
     <input type="radio" name="status" value="member"
        <?php echo ($contact['status'] == 'member') ? 'checked' : ''; ?> />Member<br />
      <input type="radio" name="status" value="nonmember"
          <?php echo ($contact['status'] == 'nonmember') ? 'checked' : ''; ?> />Non-Member<br />
    

      <label for="dob">Birth Date:</label>
      <input type="date" name="dob" value="<?php echo $contact['dob'] ?>"><br>
      </div> 

      <div id="buttons">
        <label for="submit">&nbsp;</label>
        <input type="submit" value="Save Contact" id="submit">
      </div>

    </form>
    <p><a href='index.php'>View Contact List</a></p>

  </main>
  <?php
  // Include the footer file
  include 'footer.php';
  ?>
</body>
</html>