document.querySelector('#formRegistro').addEventListener('submit', async (e) => {
    e.preventDefault(); 

    const password1 = document.querySelector('input[name="password1"]').value;
    const password2 = document.querySelector('input[name="password2"]').value;

    // Validar que las contraseñas coincidan
    if (password1 !== password2) {
        Swal.fire({
            title: "Las contraseñas no coinciden",
            text: "Asegúrate de que las contraseñas coincidan",
            icon: "error",
        });
        return; 
    }

    // Crear los datos del formulario para enviar al servidor
    const formData = new FormData(e.target); 
    formData.append("btnRegistro", "true"); 

    try {
        const response = await fetch('php/DataConector.php', {
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
            }).then(() => {
                window.location.href = "login.php";
            });            
        } else {
            Swal.fire("Error", data.message, "error");
        }
    } catch (error) {
        Swal.fire("Error", "No se pudo conectar al servidor: " + error.message, "error");
    }
});
