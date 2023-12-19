<?php
namespace App\Controllers;

use App\Controllers\Templates;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail {

    public function __construct(){}

    public function index($template = EMAIL_TEMPLATE_DEFAULT, $params = []) {               
        $errors = [];
        $errorMessage = '';
        $successMessage = '';
        
        $name = sanitizeInput($params["name"]??'');
        $toEmail = sanitizeInput($params["email"]??'');
        $subject = sanitizeInput($params["subject"]??"Babilonia ".time());

        $imagenes = $params["imagenes"]??[];
        $templateParams = $params["templateParams"]??[];

        if (empty($name)) {
            $errors[] = 'Name is empty';
        }
        if (empty($toEmail)) {
            $errors[] = 'Email is empty';
        }  else if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is invalid';
        }
        if (empty($subject)) {
            $errors[] = 'subject is empty';
        }

        if (!empty($errors)) {
            $allErrors = join('|', $errors);
            $errorMessage = "$allErrors";
            throw new Exception("No se pudo enviar el email porque faltan algunos parametros, ".$errors[0]);
            
        } else {

            // Create a new PHPMailer instance
                $mail = new PHPMailer(true);
                try {
                    // Configure the PHPMailer instance
                    $mail->isSMTP();
                    $mail->CharSet = env("APP_MAIL_CHARSET");
                    $mail->Host = env("APP_MAIL_HOST");
                    $mail->SMTPAuth = true;
                    $mail->Username = env("APP_MAIL_USERNAME");
                    $mail->Password = env("APP_MAIL_PASSWORD");
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = env("APP_MAIL_PORT");

                    // Set the sender, recipient, subject, and body of the message
                    $mailFrom = env("APP_MAIL_MAIL_FROM", "info@babilonia.io");
                    $setFrom = env("APP_MAIL_SET_FROM", "Babilonia");                    
                    $mail->setFrom($mailFrom, $setFrom);
                    $mail->addAddress($toEmail);
                    $mail->Subject = $subject;

                    if(count($imagenes)>0){
                        foreach($imagenes as $item){

                            $item_1 = $item[0]??'';
                            $item_2 = $item[1]??'';
                            $item_3 = $item[2]??'';
                            $mail->AddEmbeddedImage($item_1, $item_2, $item_3, "base64", "application/octet-stream");
                        }
                    }

                    $mail->isHTML(true);

                    $newTemplate = new Templates();
                    $templateRender = $newTemplate->render($template, $templateParams);
                    $mail->Body = $templateRender;

                    // Send the message
                    $mail->send();

                    $successMessage = "Thank you for contacting us :)";
                } catch (Exception $e) {
                print_r($e);
                $errorMessage = "Oops, something went wrong. Please try again later";
            }
        }

        echo((!empty($errorMessage)) ? $errorMessage : '');
        echo((!empty($successMessage)) ? $successMessage : '');
    }
}