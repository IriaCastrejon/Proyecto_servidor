<?php
require_once('vendor/autoload.php');
$stripe = array(
    'secret_key' => 'sk_test_51Hb84DE5jBI4r3FCqvXmntT848CiguZH8q5TXdUv0g1p6KN7ueW5NfNpCD60J8Tj3uIG28lIExqs1jqYWchY7xeG00Q2RDIhla',
    'publishable_key' => 'pk_test_51Hb84DE5jBI4r3FCphqBtyhnhLic8vWF4nWNH7r5aY4NzPo4Bwgrx2Q3L54D9tyWFbTzfbK9rrt0057sRs1x7uk400cMxViLSU',
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);

$config = [
  'site' => 'hipets',
  'title' => 'hipets',
  'content' => 'estructura  del proyecto web',
  'content_text' => 'Información sacada del config',
  'proyecto'=>'hipets',
  'user'=>'admin',
  'pass'=>'1234',
  'db_engine' => 'sqlite',
  'db_file' => 'resources/test.sqlite3',
  'img_path' => '/resources/images',
  'img_in_url' => '/images',
  'MB_2'=>2097152,
  'pagina_inicio'=>'login.php',
];

spl_autoload_register(function ($name){
  global $ROOT;
  $class_file = "$ROOT/src/$name.php";
  require($class_file);
});

function clean_input($data){
  $data=trim($data);
  $data=stripslashes($data);
  $data=htmlspecialchars($data);
  return $data;
}


function startsWith ($string, $startString) {
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function getCoordenadas($direccion) {
    $direccion = urlencode($direccion);
    $googleMapUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccion&key=AIzaSyDLzPVn1olPQjrFAQ-Jub5vMrRrybGuyYQ";
    $geocodeResponseData = file_get_contents($googleMapUrl);
    $responseData = json_decode($geocodeResponseData, true);
    if($responseData['status']=='OK') {
        $latitude = isset($responseData['results'][0]['geometry']['location']['lat']) ? $responseData['results'][0]['geometry']['location']['lat'] : "";
        $longitude = isset($responseData['results'][0]['geometry']['location']['lng']) ? $responseData['results'][0]['geometry']['location']['lng'] : "";
        $direccionFormateada = isset($responseData['results'][0]['formatted_address']) ? $responseData['results'][0]['formatted_address'] : "";
        if($latitude && $longitude && $direccionFormateada) {
            $geocodeData = array();
            array_push(
                $geocodeData,
                $longitude,
                $latitude,
                $direccionFormateada
            );
            return $geocodeData;
        } else {
            return false;
        }
    } else {
        echo "ERROR: {$responseData['status']}";
        return false;
    }
}

function validarFecha($fecha_alta){
  $fecha_actual = date("Y-m-d");

  if($fecha_alta > $fecha_actual) {
    return true;
  }else	{
    return false;
  }
}
