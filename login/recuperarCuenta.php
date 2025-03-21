<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recupera tu cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="login-card">
        <h3>Recupera tu cuenta</h3><br>
        <form method="POST" action="php/DataConector.php" id="formRecuperar">
            <div class="mb-3">
                <label for="nickname" class="form-label" >Ingresa tu correo</label>
                <input type="text" class="form-control" name="correo" placeholder="Correo" required>
            </div>
            <div class="mb-3">
                <label for="nickname" class="form-label">Ingresa tu nickname</label>
                <input type="text" class="form-control" name="nickname" placeholder="Usuario" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña</label>
                <input type="password" class="form-control" name="password1" placeholder="Contraseña" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Confirma contraseña</label>
                <input type="password" class="form-control" name="password2" placeholder="Contraseña" required>
            </div>
            <br>
            <button type="submit" name="btnCambiarDatos" class="btn btn-primary w-100">Cambiar contraseña</button>
        </form>
        <br>
        <script src="javaScript/mensajesRecuperar.js"></script>
    </div>
</body>

</html>