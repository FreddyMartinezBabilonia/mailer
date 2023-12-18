<?php

require 'vendor/autoload.php';

use App\Controllers\Mail;

Mustache_Autoloader::register();

  $newMail = new Mail();
  $newMail->index("campaign-1", [
    "name" => "Fredy",
    "email" => "fredy.martinez@babilonia.io",
    "subject" => "Campaña navideña",
    "imagenes" => [
      ['./assets/images/home.png', 'home', 'home.png'],
      ['./assets/images/etiqueta.png', 'etiqueta', 'etiqueta.png'],
      ['./assets/images/pointer.png', 'pointer', 'pointer.png'],
      ['./assets/images/dollar.png', 'dollar', 'dollar.png'],
      ['./assets/images/departamento.jpg', 'departamento', 'departamento.png'],
      ['./assets/images/promotion.png', 'promotion', 'promotion.png'],
      ['./assets/images/logo.png', 'logo', 'logo.png'],
      ['./assets/images/facebook.png', 'facebook', 'facebook.png'],
      ['./assets/images/instagram.png', 'instagram', 'instagram.png'],
      ['./assets/images/website.png', 'website', 'website.png'],
    ],
    "templateParams"=>[
      "pretexto" => "Estimado cliente,

      En estas fiestas, queremos agradecerle por confiar en nosotros para encontrar su hogar ideal. Sabemos que este año ha sido difícil para todos, pero también lleno de oportunidades.
      
      Por eso, le ofrecemos una oferta especial de navidad: si compra o reserva un inmueble con nosotros antes del 31 de diciembre, le regalamos un bono de descuento de 10% para la escritura, el impuesto o la mudanza.
      
      No deje pasar esta oportunidad de cumplir su sueño de tener una casa propia, con las mejores condiciones y el mejor servicio. Contáctenos hoy mismo y le mostraremos las opciones que tenemos para usted.
      
      ¡Feliz navidad y próspero año nuevo!
      
      Atentamente,
      Su equipo de Babilonia",      
      ]
  ]);
?>