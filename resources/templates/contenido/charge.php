<?php

$token = $_POST['stripeToken'];
$email = $_POST['stripeEmail'];

$valorDuracion = $_POST['amount'];
$id = $_POST['id'];
$nombre_real = $_POST['nombre_real'];
$fecha_alta = $_POST['fecha_alta'];
$fecha_baja =$_POST['fecha_baja'];
$url = $_POST['url'];


$customer = \Stripe\Customer::create([
  'email' => $email,
  'source'  => $token,
]);

$charge = \Stripe\Charge::create([
  'customer' => $customer->id,
  'amount'   => $valorDuracion * 100,
  'currency' => 'eur',
]);

$db= DWESBaseDatos::obtenerInstancia();
AnuncioManager::insert($id,$nombre_real,$fecha_alta, $fecha_baja, $url,$valorDuracion);
header('Location: anuncio.php');
die();
?>
