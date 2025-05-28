
<!DOCTYPE html>
<html lang="en">
<head>  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Manager - Add Contact</title>
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
    <h2>Add New Contact</h2>
    <form action="add_contact.php" method="post" id="addContactForm" enctype="multipart/form-data">
      
    <div id="formData">
      <label for="firstName">First Name:</label>
      <input type="text" name="firstName" required><br>

      <label for="lastName">Last Name:</label>
      <input type="text" name="lastName" required><br>

      <label for="emailAddress">Email Address:</label>
      <input type="email" id="emailAddress" name="emailAddress" required><br>

      <label for="phoneNumber">Phone Number:</label>
      <input type="tel" name="phoneNumber"><br>

      <label for="status">Status:</label>
      <input type="radio" name="status" value="member" />Member
      <input type="radio" name="status" value="nonmember" />Non-Member<br />


      <label for="dob">Birth Date:</label>
      <input type="date" name="dob"><br>
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