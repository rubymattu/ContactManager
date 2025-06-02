
<!DOCTYPE html>
<html lang="en">
<head>  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Manager - Login Form</title>
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
    <h2>Login</h2>
    <form action="login.php" method="post" id="loginForm" enctype="multipart/form-data">
      
    <div id="formData">

      <label for="firstName">Username:</label>
      <input type="text" name="user_name" required><br>

      <label for="lastName">Password:</label>
      <input type="text" name="password" required><br>
      </div> 

      <div id="buttons">
        <label for="submit">&nbsp;</label>
        <input type="submit" value="Login" id="submit">
      </div>

    </form>
    <p id='registerLink'>Not registered yet?<a href='register_contact_form.php'>Register</a></p>

  </main>
  <?php
  // Include the footer file
  include 'footer.php';
  ?>
</body>
</html>