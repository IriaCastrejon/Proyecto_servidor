<?php
$cantidad = 2000;
$dercripcion = "pago mama";
?>
<form action="charge.php" method="post">
    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="<?php echo $stripe['publishable_key']; ?>"
        data-description="Monto a pagar  <?=$cantidad ?> €"
        data-amount=<?=$cantidad ?>
        data-currency="eur"
        data-locale="es">
      </script>
      <input type="hidden" name='amount' value=<?=$cantidad ?>>
</form>
