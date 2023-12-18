<?php

require 'vendor/autoload.php';

use App\Controllers\Mail;

Mustache_Autoloader::register();

  $newMail = new Mail();
  $newMail->index("campaign-1", [
    "name" => "Fredy",
    "email" => "fredy.martinez@babilonia.io",
    "subject" => "Campaña navideña"
  ]);
?>