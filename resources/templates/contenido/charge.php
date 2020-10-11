<?php
echo "<pre>";
print_r($_POST);
echo "</pre>";
$token = $_POST['stripeToken'];
$email = $_POST['stripeEmail'];
$cantidad = $_POST['cantidad'];
$customer = \Stripe\Customer::create([
  'email' => $email,
  'source'  => $token,
]);

$charge = \Stripe\Charge::create([
  'customer' => $customer->id,
  'amount'   => 1200,
  'currency' => 'eur',
]);

echo '<h1>Successfully ' + $charge['amount'] + '</h1>';
?>
