<?php


  if( !isset($_SESSION['id']) && $_SESSION['tipo_cliente']!='Empresa'){
      header('Location: login.php');
      die();
  }
  if($_SESSION['tipo_cliente'] == 'mascota'){
    header('Location: accesoRestringido.php');
    die();
  }

  $id = $_SESSION['id'];
  $duracion = '';
  $valorDuracion =0;
  $fecha_alta = '';
  $foto = '';
  $fecha_baja = '';
  $url= '';
  $empresa=false;
  $activarPagar=false;
  $errores=[];

  define("PRECIO_DIA", 25);
  define("ERROR_FECHA_MAYOR", 0);
  define("ERROR_FECHA_NO", 1);

  // validacion del formulario
  if (isset($_POST['comprar'])) {
    // duracion
    if (isset($_POST['duracion']) && $_POST['duracion'] > 0) {
      $duracion=clean_input($_POST['duracion']);
    }else{
      $errores['duracion']= true;
    }
    // valor Duracion
    if (isset($_POST['valorDuracion']) && $_POST['valorDuracion'] > 0) {
      $valorDuracion =$_POST['valorDuracion'];
    }
    //url
    if (isset($_POST['url']) && $_POST['url'] != '') {
      $url = clean_input($_POST['url']);
    }else{
      $errores['url']= true;
    }
    // fecha_alta
    if (isset($_POST['fecha_alta']) && $_POST['fecha_alta'] != '') {
      if (validarFecha($_POST['fecha_alta'])) {
        $fecha_alta=clean_input($_POST['fecha_alta']);
        $fecha_baja = strtotime($fecha_alta. "+ $duracion days");

        $fecha_baja = date('Y-m-d',$fecha_baja);

      }else{
        $errores['fecha_alta'] = ERROR_FECHA_MAYOR;
      }
    }else{
      $errores['fecha_alta'] = ERROR_FECHA_NO;
    }
    //foto
    if(count($_FILES)>0) {
        if($_FILES['imagen']['size'] < $config['MB_2']){
            if($_FILES['imagen']['type'] == "image/png" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/jpg" ){
                // Gestionamos la información del fichero
                $fichero_tmp = $_FILES["imagen"]["tmp_name"];
                $nombre_real = basename($_FILES["imagen"]["name"]);
                $ruta_destino = $config['img_path']."/".$nombre_real;
              //  echo "$fichero_tmp <br>$nombre_real <br>$ruta_destino <br>";

            } else {
                $errores['foto'] = "Fichero no soportado";
            }
        } else {
            $errores['foto'] = "Fichero gigante";
        }
    } else {
        $errores['foto'] = "Sin imagen";
    }
    //errores
    if(count($errores) == 0){
      $activarPagar = true;
    }

    }

 ?>

<?php if (!$activarPagar): ?>

  <div class="form_anuncio">

   <?php if (isset($_SESSION['id'])): ?>
    <form class="formulario" action="anuncioNuevo.php" method="post"  enctype="multipart/form-data" >
        <h2> Todos los campos son obligatorios</h2>

        <!-- Duracion-->
        <?php if (isset($errores['duracion'])): ?>
          <span class="error">Debe introducir una duración</span> <br>
        <?php endif; ?>
        <p>
          <label for=""> Duración </label>
          <input type="number" name="duracion" value="<?=$duracion?>" min="1" placeholder='Número de días'>
        </p>

        <!-- URL-->
        <?php if (isset($errores['url'])): ?>
          <span class="error">Debe introducir la URL de su empresa</span> <br>
        <?php endif; ?>
        <p>
          <label for=""> Url </label>
          <input type="url" name="url" value="<?= $url ?>" placeholder='http://www.ejemplo.com'><br><br>
        </p>

        <!-- FECHA ALTA-->
        <?php if (isset($errores['fecha_alta'])){
          if ($errores['fecha_alta'] == ERROR_FECHA_MAYOR ){ ?>
            <span class="error"> Introduce una fecha mayor a la actual </span>
          <?php }else if($errores['fecha_alta'] == ERROR_FECHA_NO){ ?>
            <span class="error"> Introduce una fecha</span>
          <?php  } ?>
        <?php } ?>
        <p>
          <label for=""> Fecha de alta </label>
          <input type="date" name="fecha_alta" value="<?=$fecha_alta?>">
        </p>

        <!-- Foto-->
        <?php if (isset($errores['foto'])): ?>
          <span class="error"><?= $errores['foto']?> </span> <br><br>
        <?php endif; ?>
        <p>
          <label for=""> Foto </label>
          <input type="file" name="imagen" accept="image/png, image/jpeg">
        </p>

        <div class="totalAPagar">
          <h4> Total a pagar: <span id="precio"> <?=$valorDuracion?> €</span> </h4>
          <input type="hidden" name="valorDuracion" value="<?=$valorDuracion?>">
        </div>

        <!-- Enviar-->
        <p>
          <label ></label>
          <input  type="submit" name="comprar" value="Comprar">
        </p>

     </form>
   <?php endif; ?>
   <script type="text/javascript">
      const PRECIO_BASE = 25;
      let coste= 0;
      const INPUT_DURACION = document.getElementsByName('duracion')[0];
      const INPUT_VALOR_DURACION= document.getElementsByName('valorDuracion')[0];
      const SPAN_PRECIO = document.getElementById('precio');
      INPUT_DURACION.addEventListener('change',fctActualizaPrecio);

      function fctActualizaPrecio(e){

          coste = PRECIO_BASE * e.target.value;
          SPAN_PRECIO.innerText = coste + " €";
          INPUT_VALOR_DURACION.value= coste;
      }
   </script>
  </div>
<?php endif; ?>

 <?php if ($activarPagar): ?>
   <div class="stripe form_anuncio">
     <form action="charge.php" method="post">
          <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="<?php echo $stripe['publishable_key']; ?>"
            data-description="Pagar anuncio hipets"
            data-amount=<?=$valorDuracion * 100?>
            data-currency="eur"
            data-locale="es">
          </script>
          <input type="hidden" name='amount' value=<?=$valorDuracion * 1 ?>>
          <input type="hidden" name='id' value=<?=$id ?>>
          <input type="hidden" name='nombre_real' value=<?=$nombre_real ?>>
          <input type="hidden" name='fecha_alta' value=<?=$fecha_alta ?>>
          <input type="hidden" name='fecha_baja' value=<?=$fecha_baja ?>>
          <input type="hidden" name='url' value=<?=$url ?>>
     </form>
   </div>
 <?php endif; ?>
