<?php
session_start();
if (isset($_SESSION['usuario'])) {
    require_once 'php/showDataHome.php';
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HR Software - Home</title>
        <link rel="stylesheet" href="styles/panelEmpleadosStyle.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="sidebar d-flex flex-column" style="height: 100vh;">
            <h4 class="text-center">HR Software</h4>
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
                <h2>Bienvenida/o <?php echo htmlspecialchars($_SESSION['usuario']); ?></h2><br><br>
                <div class="row">
                    <!-- Botones para abrir modales -->
                    <div class="col-md-4 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal1">
                                    <h5>Total de Empleados</h5>
                                </button>
                                <p class="display-6"><?php echo contarEmpleados() ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal2">
                                    <h5>Empleados Activos</h5>
                                </button>
                                <p class="display-6"><?php echo contarEmpleadosActivos() ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal3">
                                    <h5>Empleados inactivos</h5>
                                </button>
                                <p class="display-6"><?php echo contarEmpleadosInactivos() ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal4">
                                    <h5>Solicitudes de Permiso</h5>
                                </button>
                                <p class="display-6">8</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal5">
                                    <h5>Nuevos Ingresos</h5>
                                </button>
                                <p class="display-6">5</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">
                                <button class="btn btn-secundary" data-bs-toggle="modal" data-bs-target="#modal6">
                                    <h5>Próximos Cumpleaños</h5>
                                </button>
                                <p class="display-6">3</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modales -->
        <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal1Label">Total de Empleados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <center>
                                    <div class="d-flex" style="width: 300px;">
                                        <input type="text" class="form-control form-control-sm me-3" placeholder="Nombre de empleado">
                                        <button class="btn btn-primary btn-sm" type="button">Buscar</button>
                                    </div>
                                </center>
                                <br>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Puesto</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody id="employee-table">
                                <!-- Aquí se llenarán los datos desde la base de datos -->
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal2Label">Empleados Activos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <center>
                                    <div class="d-flex" style="width: 300px;">
                                        <input type="text" class="form-control form-control-sm me-3" placeholder="Nombre de empleado">
                                        <button class="btn btn-primary btn-sm" type="button">Buscar</button>
                                    </div>
                                </center>
                                <br>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Puesto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se llenarán los datos desde la base de datos -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="modal3Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal3Label">Empleados que faltaron hoy</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <center>
                                <div class="d-flex" style="width: 300px;">
                                    <input type="text" class="form-control form-control-sm me-3" placeholder="Nombre de empleado">
                                    <button class="btn btn-primary btn-sm" type="button">Buscar</button>
                                </div>
                                </center>
                                <br>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Puesto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se llenarán los datos desde la base de datos -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="modal4Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal4Label">Solicitudes de Permiso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <center>
                                <div class="d-flex" style="width: 300px;">
                                    <input type="text" class="form-control form-control-sm me-3" placeholder="Nombre de empleado">
                                    <button class="btn btn-primary btn-sm" type="button">Buscar</button>
                                </div>
                                </center>
                                <br>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Motivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se llenarán los datos desde la base de datos -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal5" tabindex="-1" aria-labelledby="modal5Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal5Label">Nuevos Ingresos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <center>
                                <div class="d-flex" style="width: 300px;">
                                    <input type="text" class="form-control form-control-sm me-3" placeholder="Nombre de empleado">
                                    <button class="btn btn-primary btn-sm" type="button">Buscar</button>
                                </div>
                                </center>
                                <br>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Puesto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se llenarán los datos desde la base de datos -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal6" tabindex="-1" aria-labelledby="modal6Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal6Label">Próximos Cumpleaños</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <center>
                                <div class="d-flex" style="width: 300px;">
                                    <input type="text" class="form-control form-control-sm me-3" placeholder="Nombre de empleado">
                                    <button class="btn btn-primary btn-sm" type="button">Buscar</button>
                                </div>
                                </center>
                                <br>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Puesto</th>
                                    <th scope="col">Fecha cumpleaños</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se llenarán los datos desde la base de datos -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="javaScript/panelEmpleados.js"></script>

    </body>
        
    </html>
<?php
} else {
    header('Location: index.php');
}
?>