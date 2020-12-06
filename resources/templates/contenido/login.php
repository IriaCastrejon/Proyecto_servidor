<?php

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
        $resultados= MascotaManager::getByEmail($email);
        $tabla='mascota';
      }elseif (EmpresaManager::existeEmail($email)) {
        $resultados= EmpresaManager::getByEmail($email);
        $tabla='empresa';
      }else {
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


            if(isset($_POST["recuerdame"]) && $_POST['recuerdame']== 'si' ){

              $token = bin2hex(random_bytes(10));
              setCookie("recuerdame",$token,time()+(3600*24*30));

              TokenManager::delete($_SESSION['id'],$_SESSION['tipo_cliente']);
              TokenManager::insert($_SESSION['id'],$token,$_SESSION['tipo_cliente']);
            }

            if ($tabla=='mascota') {
              header('Location: inicio.php');
              exit;
            }elseif ($tabla=='empresa') {
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

}

if(isset($_COOKIE['recuerdame'])){
  $token = $_COOKIE['recuerdame'];
  $resultado_token = TokenManager::getIdyTipo($token);

  session_start();
  $_SESSION['id']=$resultado_token['usuario_id'];
  $_SESSION['tipo_cliente'] = $resultado_token['tipo'];
  if($resultado_token['tipo'] == "mascota"){
     header('Location: inicio.php');
       exit;
  }else{
    header('Location: inicioEmpresario.php');
    exit;
  }

}

if(isset($_GET["error"])){
    $errores[] = $_GET["error"];
}

?>


  <div class="contenedor_del_login">

    <section class="lateralFotoPerros">
      <img src="../imgs/perritosLogo.png" alt="Perritos abrazados">
    </section>

    <section class="lateralFormLogin">
        <h1>Conoce a las mascotas que están cerca de ti</h1>
      <form action="login.php" method="post" class="form_login" >
          <?php if (count($errores)>0) { ?>
            <p>
              <?php foreach($errores as $error) { ?>
                <span class="error"><?= $error ?></span></br>
              <?php } ?>
            </p>
          <?php }?>

          <p>
            <input type="text" name="email" id="email" value="<?=$email?>" placeholder="Usuario">
          </p>
          <p>
            <input type="password" name="password" id="password" value="<?=$pass ?>" placeholder="Contraseña">
          </p>

          <p>
              <button type="submit" id="submit_btn" name="submit">Acceder</button>
          </p>
          <p class="recuerdame">
            <input id="recuerdame" type="checkbox" name="recuerdame" value="si">
            <label for="recuerdame">Recuérdame</label>
         </p>
      </form>
    <div class="Registro_RecuperaPass">
      <a href="enviarCorreo.php">Recuperar contraseña</a>
      <a href="registro.php"> Registrarme </a>
    </div>
    </section>
  </div>
