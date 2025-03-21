async function cargarEmpleados() {
    try{
        Swal.fire({
            title: "Cargando empleados...",
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading(),
        });

        const response = await fetch("php/DataConectorHome.php?action=getAll");
        if(!response.ok) throw new Error(`Error HTTP: ${response.status}`);

        const empleados = await response.json();
        const tabla = document.getElementById("employee-table");
        const fragment = document.createDocumentFragment();

        empleados.data.forEach((empleado) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td id="idEmpleado" name="idEmpleado">${empleado.id}</td>
                <td>${empleado.nombre}</td>
                <td>${empleado.puesto}</td>
                <td>${empleado.status}</td>`;
            fragment.appendChild(tr);
        });

        tabla.appendChild(fragment);
        Swal.close();

    }catch(error){
        console.error("Error al cargar los empleados:", error);
        Swal.fire("Error", "No se pudieron cargar los empleados", "error");
    }
}