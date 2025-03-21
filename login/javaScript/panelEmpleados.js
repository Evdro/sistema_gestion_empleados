document.addEventListener("DOMContentLoaded", function () {
  // Cargar empleados al inicio
  cargarEmpleados();

  // Controlador para registrar empleados
  document.getElementById("formRegistroEmpleado").addEventListener("submit", async function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    formData.append("btnRegistrarEmpleado", "true");

    try {
      const response = await fetch("php/DataConectorEmpleados.php", {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        throw new Error("No se pudo realizar la conexión con el servidor");
      }

      const data = await response.json();

      if (data.status === "success") {
        Swal.fire({
          title: "Éxito",
          text: data.message,
          icon: "success",
          timer: 2000,  
          showConfirmButton: false
      });  
        cargarEmpleados(); 
        this.reset(); 
        $("#addEmployeeModal").modal("hide"); 
      } else {
        Swal.fire("Error", data.message, "error");
      }
    } catch (error) {
      Swal.fire("Error", "No se pudo conectar al servidor: " + error.message, "error");
    }
  });
  //controlador para editar datos de empleados
  document.addEventListener("submit", async function (event) {
    if (event.target && event.target.id === "formEditarEmpleados") {
        event.preventDefault();

        const formData = new FormData(event.target);
        formData.append("btnCambiarDatos", "true");

        try {
            const response = await fetch("php/DataConectorEmpleados.php", {
                method: "POST",
                body: formData,
            });

            if (!response.ok) {
                throw new Error("No se pudo realizar la conexión con el servidor");
            }

            const data = await response.json(); // Aquí puede fallar si no es un JSON válido

            if (data.status === "success") {
                Swal.fire({
                    title: "Éxito",
                    text: data.message,
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });
                cargarEmpleados();
                $("#editEmployeeModal").modal("hide");
            } else {
                Swal.fire("Error", data.message, "error");
            }
        } catch (error) {
            Swal.fire("Error", "No se pudo conectar al servidor: " + error.message, "error");
        }
    }
});
  

  //controlador para editar empleados
  document.getElementById("employee-table").addEventListener("click", async (event) => {
    if (event.target && event.target.classList.contains("btn-danger")) { 
      const idEmpleado = event.target.getAttribute("data-id");

      if (confirm(`¿Estás seguro de eliminar al empleado con ID ${idEmpleado}?`)) {
        try {
          const formData = new FormData();
          formData.append("idEmpleado", idEmpleado); 
          formData.append("btnEliminarEmpleado", "true");

          const response = await fetch("php/DataConectorEmpleados.php", {
            method: "POST",
            body: formData,
          });

          if (!response.ok) {
            throw new Error("Error de conexión al servidor");
          }

          const data = await response.json();

          if (data.status === "success") {
            Swal.fire({
              title: "Éxito",
              text: data.message,
              icon: "success",
              timer: 2000,  
              showConfirmButton: false
          });  
            cargarEmpleados(); 
          } else {
            Swal.fire("Error", data.message, "error");
          }
        } catch (error) {
          Swal.fire("Error", `No se pudo conectar al servidor: ${error.message}`, "error");
        }
      }
    }
  });
});

// Función para cargar empleados
async function cargarEmpleados() {
  try {
    Swal.fire({
      title: "Cargando empleados...",
      allowOutsideClick: false,
      showConfirmButton: false,
      didOpen: () => Swal.showLoading(),
    });

    const response = await fetch("php/DataConectorEmpleados.php?action=getAll");
    if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

    const empleados = await response.json();
    const tabla = document.getElementById("employee-table");
    const fragment = document.createDocumentFragment();

    empleados.data.forEach((empleado) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td id="idEmpleado" name="idEmpleado">${empleado.id}</td>
        <td>${empleado.nombre}</td>
        <td>${empleado.correo}</td>
        <td>${empleado.puesto}</td>
        <td>${empleado.status}</td>
        <td>
          <button class="btn btn-sm btn-warning" onclick="openEditModal(
            ${empleado.id}, 
            '${empleado.nombre}', 
            '${empleado.correo}', 
            '${empleado.puesto}', 
            '${empleado.status}',
            '${empleado.telefono}',
            '${empleado.direccion}',
            '${empleado.fecha_ingreso}',
            '${empleado.salario}',
            '${empleado.departamento}'
          )">Editar</button>
          <button type="button" class="btn btn-sm btn-danger" data-id="${empleado.id}">Eliminar</button>
        </td>
      `;
      fragment.appendChild(tr);
    });

    tabla.innerHTML = ""; // Limpiar tabla antes de añadir datos
    tabla.appendChild(fragment); // Agregar todos los datos de una vez

    Swal.close(); // Cerrar la pantalla de carga
  } catch (error) {
    console.error("Error al cargar los empleados:", error);
    Swal.fire("Error", "No se pudieron cargar los empleados", "error");
  }
}


// Modal de edición
function openEditModal(id, name, email, position, status, telefono, direccion, fechaIngreso, salario, departamento) {  
  document.getElementById("editEmployeeId").value = id;
  document.getElementById("cambiarNombreEmpleado").value = name;
  document.getElementById("cambiarCorreoEmpleado").value = email;
  document.getElementById("cambiarPuestoEmpleado").value = position;
  document.getElementById("camabirStatusEmpleado").value = status;
  document.getElementById("cambiarTelefonoEmpleado").value = telefono;
  document.getElementById("cambiarDireccionEmpleado").value = direccion;
  document.getElementById("cambiarFechaIngresoEmpleado").value = fechaIngreso;
  document.getElementById("cambiarSalarioEmpleado").value = salario;
  document.getElementById("cambiarDepartamentoEmpleado").value = departamento;

  const modal = new bootstrap.Modal(document.getElementById("editEmployeeModal"));
  modal.show();
}
