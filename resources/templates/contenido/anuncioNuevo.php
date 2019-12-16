<?php

  session_start();
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';

  if( !isset($_SESSION['id']) && $_SESSION['tipo_cliente']!='Empresa'){
      header('Location: login.php');
      die();
  }
  $id = $_SESSION['id'];
  $duracion = '';
  $fecha_alta = '';
  $foto = '';
  // $fecha_baja = fecha_alta + duracion;
  //$fecha_baja = strtotime($fecha_alta."+ ". $duracion." days");
  $url= '';
  $empresa=false;

  $precio= 0;
  $precioDia = 25;


  $errores=[];


// validacion del formulario
  if (isset($_POST['comprar'])) {

    // duracion
    if (isset($_POST['duracion']) && $_POST['duracion'] != 0) {
      $duracion=clean_input($_POST['duracion']);
    }else{
      $errores['duracion']= 'introduce una duración';
    }

    //url
    if (isset($_POST['url']) && $_POST['url'] != '') {
      $url = clean_input($_POST['url']);
    }else{
      $errores['url']= 'introduce una url';
    }

    //Funcion para validar la fecha que sea mayor a la actual

    function validarFecha($fecha_alta){
      $fecha_actual = date("Y-m-d");

      if($fecha_alta > $fecha_actual) {
        //echo "La fecha actual es mayor a la comparada.";
        //echo $fecha_actual;
        return true;
    	}else	{
    		//echo "La fecha comparada es igual o menor";
        return false;
      }
    }// validarFecha($fecha);


    // fecha_alta
  if (isset($_POST['fecha_alta']) && $_POST['fecha_alta'] != '') {
      if (validarFecha($_POST['fecha_alta']) && isset($_POST['duracion'])) {
        $fecha_alta = $_POST['fecha_alta'];

        echo date("Y-m-d",strtotime($fecha_alta."+ ".$duracion." days"));
        $fecha_baja = date("Y-m-d",strtotime($fecha_alta."+ ".$duracion." days"));

      }else{
        $errores['fecha_alta_menor'] = 'Introduce una fecha mayor a la actual';
      }
    }else{
      $errores['fecha_alta'] = 'Introduce una fecha de alta';
    }

    //foto
    if (isset($_POST['foto']) && $_POST['foto'] != '') {
      $foto = clean_input($_POST['foto']);
    }
    // else{
    //   $errores['foto'] = 'Introduce una foto';
    // }

    //errores
    if(count($errores)==0){
      $db = DWESBaseDatos::obtenerInstancia();
      AnuncioManager::insert($id, $foto, $fecha_alta, $fecha_baja, $url);


      //$_SESSION['id']= $db->getLastId();
      //echo $_SESSION['id']. ' ultimo id insertado';
      header("location: anuncio.php");

    }// no hay errores

  }
  //echo $_SESSION['tipo_cliente'];
 ?>

 <div class="form_anuncio">

  <?php if (isset($_SESSION['id'])): ?>
 <form class="registro" action="anuncioNuevo.php" method="post">
   <!-- Duracion-->
   <?php if (isset($errores['duracion'])): ?>
     <span class="error">Debe introducir una duración</span> <br>
   <?php endif; ?>
   <label for=""> Duración </label><input type="number" name="duracion" value=" <?= $duracion ?>" placeholder='Número de días'><br><br>

   <!-- URL-->
   <?php if (isset($errores['url'])): ?>
     <span class="error">Debe introducir la URL de su empresa</span> <br>
   <?php endif; ?>
  <label for=""> Url </label><input type="url" name="url" value="<?= $url ?>" placeholder='http://www.ejemplo.com'><br><br>

   <!-- EMAIL-->
   <?php if (isset($errores['fecha_alta'])): ?>
     <span class="error"> Debe introducir una fecha de alta </span> <br>
   <?php endif; ?>
   <?php if (isset($errores['fecha_alta_menor'])): ?>
     <span class="error"> Debe introducir una fecha de alta mayor a la actual </span> <br>
   <?php endif; ?>
   <label for=""> Fecha de alta </label><input type="date" name="fecha_alta" value="<?= $fecha_alta ?>"><br><br>

   <!-- FOTO-->
   <!-- <?php //if (isset($errores['foto'])): ?>
     <span class="error"> Debe introducir una foto para el anuncio </span> <br>
   <?php //endif; ?> -->
   <label for=""> Foto </label><input type="file" name="foto" value="<?= $foto ?>"><br>

   <h4> Total a pagar:
     <?php if (isset($_POST['calcular'])): ?>
       <span ><?php $precio = $precioDia * $_POST['duracion']; echo $precio . ' €';?></span> <br>
    <?php else: ?>
      <span ><?= $precio ?></span> <br>
     <?php endif; ?>
     </h4>

   <br><br>

   <div class="botones">
     <input type="submit" name="calcular" value="Calcular">
     <input type="submit" name="comprar" value="Comprar">
   </div>


  </form>
  <?php endif; ?>

 </div>
