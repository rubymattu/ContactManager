<?php
  require './PHPMailer/PHPMailerAutoload.php';
  
  function send_email($to_address, $to_name, $from_address, $from_name, 
                      $subject, $body, $is_body_html = false) {
    if (!valid_email($to_address)) {
      throw new Exception("Invalid recipient email address:" . htmlspecialchars($to_address));
    }
    if (!valid_email($from_address)) {
      throw new Exception("Invalid recipient email address:" . htmlspecialchars($from_address));
    }
    $mail = new PHPMailer();
    // Set mailer to use SMTP according to your server configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption
    $mail->Port = 587; // TCP port to connect to
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'harnoor070695@gmail.com'; // Your SMTP username
    $mail->Password = 'hcsu tgpe kvzc qxla'; // Your SMTP password
    
    // Set From and To addresses
    $mail->setFrom($from_address, $from_name);
    $mail->addAddress($to_address, $to_name);

    // Set email subject and body
    $mail->Subject = $subject;
    $mail->Body = $body;

    // Set alternative body for non-HTML email clients
    $mail->AltBody = strip_tags($body); 

    // Set email format to HTML if specified
    if ($is_body_html) {
      $mail->isHTML(true);
    } else {
      $mail->isHTML(false);
    }

    // Send the email
    if (!$mail->send()) {
      throw new Exception("Error sending email: " . htmlspecialchars($mail->ErrorInfo));
    } else {
      return true; // Email sent successfully
    }
  } 
  
  function valid_email($email) {
      if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) 
      {
        return false;
      } 
      else 
      {
        return true;
      }
  }

?>