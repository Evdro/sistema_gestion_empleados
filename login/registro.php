<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="login-card">
    <h3>Registrate</h3>
    <form action="php/DataConector.php" method="POST" id="formRegistro">
      <div class="mb-3">
        <label for="nickname" class="form-label">Ingresa tu nombre</label>
        <input type="text" class="form-control" name="nombre" placeholder="Aqui va tu nombre" required>
      </div>
      <div class="mb-3">
        <label for="nickname" class="form-label">Crea tu usuario</label>
        <input type="text" class="form-control" name="nickname" placeholder="Aqui crea tu usuario" required>
      </div>
      <div class="mb-3">
        <label for="nickname" class="form-label">Ingresa tu correo</label>
        <input type="email" class="form-control" name="correo" placeholder="Aqui va tu correo" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Crea tu contraseña</label>
        <input type="password" class="form-control" name="password1" placeholder="Aqui va tu contraseña" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Confirma contraseña</label>
        <input type="password" class="form-control" name="password2" placeholder="Aqui confirma tu contraseña" required>
      </div>
      <br>
      <button type="submit" class="btn btn-primary w-100" name="btnRegistro">Registrate</button>
    </form>
    <script src="javaScript/mensajesRegistro.js"></script>
</body>
</html>
