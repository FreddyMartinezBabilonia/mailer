<?php

require 'vendor/autoload.php';

use App\Controllers\Mail;

Mustache_Autoloader::register();



  $imagenes = [
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
  ];

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://services.babilonia.io/public/listing/listings?page=1&per_page=6&sort=created_at&direction=desc&price_start=0&price_end=999999999',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
  ));

  $response = curl_exec($curl);
  $response = json_decode($response, true);
  $response = $response["data"]["records"];
  
  curl_close($curl);

  $avisos = [];

  if(count($response) > 0){
    foreach($response as $key => $item){
      $url = $item["url"]["main"]??'';
      $price = $item["price"]??'';
      $imagen = $item["images"][0]["photo"]["url_min"]??'';
      
      $array = explode("/", $imagen)??[];      
      $imagen_id = end($array);
      
      $rowClose = (($key+1) % 2 == 0) ? true : false;
      $BodyClose = (($key+1) == count($response)) ? true : false;

      $nombreImagen = save_image($imagen);
      $nombre_imagen_sin_extension = pathinfo($nombreImagen, PATHINFO_FILENAME);

      array_push($avisos, [
        "url" => env("APP_MAIL_REMOTE_URL"). $url,
        "price" => $price,
        "imagen" => $nombreImagen,
        "imagenID" => $nombre_imagen_sin_extension,
        "rowClose" => $rowClose,
        "BodyClose" => $BodyClose,
      ]);

      array_push($imagenes, [
        URL_ROOT. "temp/$nombreImagen",
        $nombre_imagen_sin_extension,
        $nombre_imagen_sin_extension
      ]);
    }
  }

  $newMail = new Mail();
  $newMail->index("campaign-1", [
    "name" => "Fredy",
    "email" => "fredy.martinez@babilonia.io",
    "subject" => "Campaña navideña",
    "imagenes" => $imagenes,
    "templateParams"=>[
      "pretexto" => "Estimado cliente,

      En estas fiestas, queremos agradecerle por confiar en nosotros para encontrar su hogar ideal. Sabemos que este año ha sido difícil para todos, pero también lleno de oportunidades.
      
      Por eso, le ofrecemos una oferta especial de navidad: si compra o reserva un inmueble con nosotros antes del 31 de diciembre, le regalamos un bono de descuento de 10% para la escritura, el impuesto o la mudanza.
      
      No deje pasar esta oportunidad de cumplir su sueño de tener una casa propia, con las mejores condiciones y el mejor servicio. Contáctenos hoy mismo y le mostraremos las opciones que tenemos para usted.
      
      ¡Feliz navidad y próspero año nuevo!
      
      Atentamente,
      Su equipo de Babilonia",      
      "avisos"=>$avisos
    ],
  ]);
?>