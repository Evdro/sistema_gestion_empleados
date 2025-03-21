<?php
session_start();
if(isset($_SESSION['usuario'])){
  header('Location: home.php');
?>
<?php
  }else{
?>
  <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="login-card">
    <h3>Inicia sesion</h3><br>
    <form method="POST" action="php/DataConector.php" id="formLogin">
      <div class="mb-3">
        <label for="nickname" class="form-label">Ingresa usuario</label>
        <input type="text" class="form-control" name="nickname" placeholder="Usuario" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Ingresa contraseña</label>
        <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
      </div>
      <br>
      <button type="submit" name="btnLogin" id="btnLogin" class="btn btn-primary w-100">Login</button>
    </form>
    <br>
    <label>No tienes cuenta?</label><br>
    <a href="registro.php" class="forgot-password">Registrate</a>
    <br>
    <br>
    <label>No recuerdas tu contraseña?</label><br>
    <a href="recuperarCuenta.php" class="forgot-password">Recupera tu cuenta</a>
  </div>
  <script src="javaScript/mensajesLogin.js"></script>
</body>
</html>
<?php
  }
?>