    document.getElementById("formLogin").addEventListener("submit", async function(event) { 
        event.preventDefault();

        const formData = new FormData(this);
        formData.append("btnLogin", "true"); 

        try {
            const response = await fetch('php/DataConector.php', {
                method: "POST",
                body: formData,
            });

            if (!response.ok) {
                throw new Error("Error de conexión al servidor error2");
            }

            const data = await response.json();

            if (data.status === "success") {
                Swal.fire({
                    text: data.message,
                    icon: "success",
                    timer: 2000,  
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "home.php";
                });    
            } else {
                Swal.fire("Error", data.message, "error");
            }
        } catch (error) {
            Swal.fire("Error", "No se pudo conectar al servidor error1: " + error.message, "error");
        }
    });

