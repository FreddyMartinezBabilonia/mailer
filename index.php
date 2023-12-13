<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$errors = [];
$errorMessage = '';
$successMessage = '';
$siteKey = ''; // reCAPTCHA site key
$secret = ''; // reCAPTCHA secret key
$template = "template-3/index.html";
#$template = "template-2/index.html";
#$template = "template.html";
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']??'Fredy');
    $email = sanitizeInput($_POST['email']??"ivan.rivas@babilonia.io");
    $message = sanitizeInput($_POST['message']??'Hola mundo');
    //$recaptchaResponse = sanitizeInput($_POST['g-recaptcha-response']);

  if (empty($name)) {
    $errors[] = 'Name is empty';
  }
  if (empty($email)) {
    $errors[] = 'Email is empty';
  }  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email is invalid';
  }
  if (empty($message)) {
    $errors[] = 'Message is empty';
  }

  if (!empty($errors)) {
    $allErrors = join('|', $errors);
    $errorMessage = "$allErrors";
  } else {
    $toEmail = 'fredy.martinez@babilonia.io';
    #$toEmail = 'julio.lopez@babilonia.io';
    #$toEmail = 'tex.97@hotmail.com';
    $emailSubject = "Babilonia ".time();

      // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        try {
            // Configure the PHPMailer instance
            $mail->isSMTP();
            $mail->CharSet = "UTF-8";
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'fredy.martinez@babilonia.io';
            $mail->Password = 'B@b1lionia.2023';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Set the sender, recipient, subject, and body of the message
            $mail->setFrom($email, "Babilonia");
            $mail->addAddress($toEmail);
            $mail->Subject = $emailSubject;
            $mail->AddEmbeddedImage('./assets/images/home.png', 'home', 'home.png');
            $mail->AddEmbeddedImage('./assets/images/etiqueta.png', 'etiqueta', 'etiqueta.png');
            $mail->AddEmbeddedImage('./assets/images/pointer.png', 'pointer', 'pointer.png');
            $mail->AddEmbeddedImage('./assets/images/dollar.png', 'dollar', 'dollar.png');
            $mail->AddEmbeddedImage('./assets/images/departamento.jpg', 'departamento', 'departamento.png');
            $mail->AddEmbeddedImage('./assets/images/promotion.png', 'promotion', 'promotion.png');
            $mail->AddEmbeddedImage('./assets/images/logo.png', 'logo', 'logo.png');
            $mail->AddEmbeddedImage('./assets/images/facebook.png', 'facebook', 'facebook.png');
            $mail->AddEmbeddedImage('./assets/images/instagram.png', 'instagram', 'instagram.png');
            $mail->AddEmbeddedImage('./assets/images/website.png', 'website', 'website.png');
            $mail->isHTML(true);
            $mail->Body = file_get_contents($template);

            // Send the message
            $mail->send();

            $successMessage = "Thank you for contacting us :)";
        } catch (Exception $e) {
          print_r($e);
          $errorMessage = "Oops, something went wrong. Please try again later";
    }
  }
// }

function sanitizeInput($input) {
   $input = trim($input);
   $input = stripslashes($input);
   $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
   return $input;
}

echo((!empty($errorMessage)) ? $errorMessage : '');
echo((!empty($successMessage)) ? $successMessage : '');
?>