<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$errors = [];
$errorMessage = '';
$successMessage = '';
$siteKey = ''; // reCAPTCHA site key
$secret = ''; // reCAPTCHA secret key
#$template = "template-2/index.html";
$template = "template.html";
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
    $allErrors = join('<br/>', $errors);
    $errorMessage = "<p style='color: red;'>{$allErrors}</p>";
  } else {
    $toEmail = 'fredy.martinez@babilonia.io';
    $emailSubject = "Template ".time();

      // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        try {
            // Configure the PHPMailer instance
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'fredy.martinez@babilonia.io';
            $mail->Password = 'B@b1lionia.2023';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Set the sender, recipient, subject, and body of the message
            $mail->setFrom($email);
            $mail->addAddress($toEmail);
            $mail->Subject = $emailSubject;
            $mail->isHTML(true);
            $mail->Body = file_get_contents($template);

            // Send the message
            $mail->send();

            $successMessage = "<p style='color: green;'>Thank you for contacting us :)</p>";
        } catch (Exception $e) {
            echo "<pre>";
            print_r($e);
            echo "</pre>";
      $errorMessage = "<p style='color: red;'>Oops, something went wrong. Please try again later</p>";
    }
  }
// }

function sanitizeInput($input) {
   $input = trim($input);
   $input = stripslashes($input);
   $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
   return $input;
}

?>

<html>
  <body>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <form action="/"method="post" id="contact-form">
      <h2>Contact us</h2>
      <?php echo((!empty($errorMessage)) ? $errorMessage : '') ?>
      <?php echo((!empty($successMessage)) ? $successMessage : '') ?>
      <p>
        <label>First Name:</label>
        <input name="name" type="text" required />
      </p>
      <p>
        <label>Email Address:</label>
        <input style="cursor: pointer;" name="email" type="email" required />
      </p>
      <p>
        <label>Message:</label>
        <textarea name="message" required></textarea>
      </p>
      <p>
        <button
        class="g-recaptcha"
        type="submit"
        data-sitekey="<?php echo $siteKey ?>"
        data-callback='onRecaptchaSuccess'
        >
          Submit
        </button>
      </p>
    </form>

    <script>
    function onRecaptchaSuccess() {
      document.getElementById('contact-form').submit();
    }
    </script>
  </body>
</html>