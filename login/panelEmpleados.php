<?php
session_start();
if (isset($_SESSION['usuario'])) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Empleados</title>
    <link rel="stylesheet" href="styles/panelEmpleadosStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
    <div class="sidebar d-flex flex-column" style="height: 100vh;">
      <h4 class="text-center">Admin Panel</h4>
      <hr class="text-light">
      <a href="home.php">Inicio</a>
      <a href="panelEmpleados.php">Administrar Empleados</a>
      <a href="#">Reportes</a>
      <a href="#">Configuración</a>

      <div class="mt-auto">
        <form action="php/logout.php" method="POST">
          <button class="btn btn-secondary w-100" name="btnCerrarSesion">Cerrar sesión</button>
        </form>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2>Lista de Empleados</h2>
          <div class="d-flex" style="width: 300px;">
            <input type="text" class="form-control form-control-sm me-3" placeholder="Nombre de empleado">
            <button class="btn btn-primary btn-sm" type="button">Buscar</button>
          </div>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Agregar
            Empleado</button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Posición</th>
                <th>Status</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <form action="php/DataConectorEmpleados.php" method="POST" id="formEliminarEmpleado"></form>
            <tbody id="employee-table">
              <!-- Aquí se cargan los datos de la base de datos -->
            </tbody>
            </form>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal para agregar empleado -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addEmployeeModalLabel">Agregar Empleado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="formRegistroEmpleado" method="POST" action="php/DataConectorEmpleados.php">
              <div class="row">
                <!-- Primera columna -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="nombreEmpleadoRegistro" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombreEmpleadoRegistro" name="nombreEmpleadoRegistro" required>
                  </div>
                  <div class="mb-3">
                    <label for="correoEmpleadoRegistro" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correoEmpleadoRegistro" name="correoEmpleadoRegistro" required>
                  </div>
                  <div class="mb-3">
                    <label for="empleadoPuestoRegistro" class="form-label">Posición</label>
                    <input type="text" class="form-control" id="empleadoPuestoRegistro" name="empleadoPuestoRegistro" required>
                  </div>
                  <div class="mb-3">
                    <label for="telefonoEmpleadoRegistro" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefonoEmpleadoRegistro" name="telefonoEmpleadoRegistro" required>
                  </div>
                  <div class="mb-3">
                    <label for="direccionEmpleadoRegistro" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccionEmpleadoRegistro" name="direccionEmpleadoRegistro" required>
                  </div>
                  <div class="mb-3">
                    <label for="fechaIngresoRegistro" class="form-label">Fecha de Ingreso</label>
                    <input type="date" class="form-control" id="fechaIngresoRegistro" name="fechaIngresoRegistro" required>
                  </div>
                  <div class="mb-3">
                    <label for="empleadoStatusRegistro" class="form-label">Status</label>
                    <select class="form-select" id="empleadoStatusRegistro" name="empleadoStatusRegistro" required>
                      <option value="Activo">Activo</option>
                      <option value="Inactivo">Inactivo</option>
                    </select>
                  </div>
                </div>

                <!-- Segunda columna -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="salarioRegistro" class="form-label">Salario</label>
                    <input type="text" class="form-control" id="salarioRegistro" name="salarioEmpleadoRegistro" required>
                  </div>
                  <div class="mb-3">
                    <label for="departamentoRegistro" class="form-label">Departamento</label>
                    <input type="text" class="form-control" id="departamentoRegistro" name="departamentoEmpleadoRegistro" required>
                  </div>
                  <div class="mb-3">
                    <label for="supervisorRegistro" class="form-label">Supervisor ID</label>
                    <input type="text" class="form-control" id="supervisorRegistro" name="supervisorEmpleadoRegistro">
                  </div>
                  <div class="mb-3">
                    <label for="generoRegistro" class="form-label">Género</label>
                    <select class="form-select" id="generoRegistro" name="generoEmpleadoRegistro" required>
                      <option value="Masculino">Masculino</option>
                      <option value="Femenino">Femenino</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="nssRegistro" class="form-label">NSS</label>
                    <input type="text" class="form-control" id="nssRegistro" name="nssEmpleadoRegistro" required>
                  </div>
                  <div class="mb-3">
                    <label for="curpRegistro" class="form-label">CURP</label>
                    <input type="text" class="form-control" id="curpRegistro" name="curpEmpleadoRegistro" required>
                  </div>
                  <div class="mb-3">
                    <label for="rfcRegistro" class="form-label">RFC</label>
                    <input type="text" class="form-control" id="rfcRegistro" name="rfcEmpleadoRegistro" required>
                  </div>
                </div>
              </div>

              <div class="text-end">
                <button type="submit" class="btn btn-primary" name="btnRegistrarEmpleado" id="btnRegistrarEmpleado">Agregar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal para editar empleado -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editEmployeeModalLabel">Editar Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarEmpleados" method="POST" action="php/DataConectorEmpleados.php">
          <input type="hidden" id="editEmployeeId">
          <div class="row">
            <!-- Columna izquierda -->
            <div class="col-6">
              <div class="mb-3">
                <label for="cambiarNombreEmpleado" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="cambiarNombreEmpleado" name="cambiarNombreEmpleado" required readonly>
              </div>
              <div class="mb-3">
                <label for="cambiarCorreoEmpleado" class="form-label">Correo</label>
                <input type="email" class="form-control" id="cambiarCorreoEmpleado" name="cambiarCorreoEmpleado" required>
              </div>
              <div class="mb-3">
                <label for="cambiarPuestoEmpleado" class="form-label">Posición</label>
                <input type="text" class="form-control" id="cambiarPuestoEmpleado" name="cambiarPuestoEmpleado" required>
              </div>              
              <div class="mb-3">
                <label for="cambiarTelefonoEmpleado" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="cambiarTelefonoEmpleado" name="cambiarTelefonoEmpleado" required>
              </div>
              <div class="mb-3">
                <label for="camabirStatusEmpleado" class="form-label">Status</label>
                <select class="form-select" id="camabirStatusEmpleado" name="cambiarStatusEmpleado" required>
                  <option value="Activo">Activo</option>
                  <option value="Inactivo">Inactivo</option>
                </select>
              </div>
            </div>
            <!-- Columna derecha -->
            <div class="col-6">
              <div class="mb-3">
                <label for="cambiarDireccionEmpleado" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="cambiarDireccionEmpleado" name="cambiarDireccionEmpleado" required>
              </div>
              <div class="mb-3">
                <label for="cambiarFechaIngresoEmpleado" class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" id="cambiarFechaIngresoEmpleado" name="cambiarFechaIngresoEmpleado" required readonly>
              </div>
              <div class="mb-3">
                <label for="cambiarSalarioEmpleado" class="form-label">Salario</label>
                <input type="number" class="form-control" id="cambiarSalarioEmpleado" name="cambiarSalarioEmpleado" required>
              </div>
              <div class="mb-3">
                <label for="cambiarDepartamentoEmpleado" class="form-label">Departamento</label>
                <input type="text" class="form-control" id="cambiarDepartamentoEmpleado" name="cambiarDepartamentoEmpleado" required>
              </div>
            </div>
          </div>
          <br>
          <center><button type="submit" class="btn btn-success" name="btnCambiarDatos" id="btnCambiarDatos">Guardar Cambios</button></center>
        </form>
      </div>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="javaScript/panelEmpleados.js"></script>

  </html>
<?php
} else {
  header('Location: index.php');
}
?>