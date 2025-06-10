
<!DOCTYPE html>
<html lang="en">
<head>  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Manager - Registeration Form</title>
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
  <main id='login'>
    <h2>Register</h2>
    <form action="register_contact.php" method="post" id="register_contact_form">    
      
      <div id="formData">
        <label for="firstName">Username:</label>
        <input type="text" name="user_name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="emailAddress" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
      </div> 
      
      <div id="buttons">
        <label for="submit">&nbsp;</label>
        <input type="submit" value="Register" id="submit">
      </div>

    </form>
  </main>
  <?php
  // Include the footer file
  include 'footer.php';
  ?>
</body>
</html>