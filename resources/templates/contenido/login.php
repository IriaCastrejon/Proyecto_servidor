<?php
/*echo '<pre>';
var_dump($_POST);
echo '</pre>';
echo '<br>';*/
$email = "";
$pass = "";
$errores = [];
$passEncriptada;
$tabla='';

if(isset($_POST["submit"])) {

    if(isset($_POST["email"])  && $_POST["email"] != ''){
        $email = clean_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Usuario inválido";
            //http://php.net/manual/es/filter.filters.php
        }
    }else{
      $errores[]= 'Introduce un email';
    }




    if(isset($_POST["password"]) && $_POST["password"] != ''){
        $password = clean_input($_POST["password"]);
    }else{
        $errores[] = "Contraseña inválida";
    }

    //creación del objeto con conexion a la BD

    if (count($errores)===0) {

      if( MascotaManager::existeEmail($email) ){
        echo 'etra e ascota <br>';
        $resultados= MascotaManager::getByEmail($email);
        $tabla='Mascota';
      }elseif (EmpresaManager::existeEmail($email)) {
        echo 'etra e epresa';
        $resultados= EmpresaManager::getByEmail($email);
        $tabla='Empresa';
      }else {
        echo 'etra e else';
        $resultados=[];
      }


      if(count($resultados) > 0 ){// si hay resultados
          // contraseña encriptada regresda para ese email
          $clave= $resultados['pass'];
          // verfica si coinciden o no las contraseñas

          if (password_verify($password,$clave)) {
            session_start();
            $_SESSION['tipo_cliente']=$tabla;
            $_SESSION['email']=$email;
            $_SESSION['id']=$resultados['id'];
            echo $_SESSION['email'].' Las claves coinciden y este es el email <br>';
            echo $_SESSION['id'].' Las id  es <br>';

            if ($tabla=='Mascota') {
              header('Location: actividades.php');
              exit;
            }elseif ($tabla=='Empresa') {
              header('Location: inicioEmpresario.php');
              exit;
            }

          }else{
            $errores[] = "Clave errónea";
          }

        }else{
          $errores[] ="El correo electrónico no existe";
        }


    }// if errores =0

    echo count($errores).' errores <br>';
    var_dump($resultados);
    echo '<br>';
    echo count($resultados).' Resultados <br>';




}


if(isset($_GET["error"])){
    $errores[] = $_GET["error"];
}

?>


  <div class="contenedor_del_login">
      <img src="../imgs/InicioFondo1.png" alt="Perritos abrazados">
      <div class="titulo">
        <p>La red social de mascotas mas grande del mundo</p>
      </div>
      <h1>Conoce a las mascotas que estan cerca de ti</h1>


        <form action="login.php" method="post" class="login" >
            <p>
              <input type="text" name="email" id="email" value="<?=$email?>" placeholder="Usuario">
            </p>
            <p>
              <input type="password" name="password" id="password" value="<?=$pass ?>" placeholder="Contraseña">
            </p>

            <?php if (count($errores)>0) { ?>
            <p>
              <?php foreach($errores as $error) { ?>
                <div class="error"><?= $error ?></div>
              <?php } ?>
            </p>
            <?php }?>

            <p class="login-submit">
              <label for="submit">&nbsp;</label>
              <button type="submit" name="submit" class="login-button">Login</button>
            </p>
        </form>

      <p>Recuperar contraseña</p>
      <a href="registro.php">
        <p>Registrarme</p>
      </a>
  </div>
