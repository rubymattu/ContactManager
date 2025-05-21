<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Manager - Database Error</title>
  <link rel="stylesheet" type="txt/css" href="css/main.css">
</head>
<body>
  <?php
  // Include the header file
  include 'header.php';
  ?>
  <main>
    <h2>Database Error</h2>
    <p>There was an error connecting to the database. Please try again later.</p>
    <p>The database must be installed.</p>
    <p>MySQL must be running.</p>
    <p>Error message: <?php echo $_SESSION['database_error']; ?></p>
    <p><a href='index.php'>View Contact List</a></p>
  </main>
  <?php
  // Include the footer file
  include 'footer.php';
  ?>
</body>
</html>