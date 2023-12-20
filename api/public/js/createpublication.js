  function createPublication() {
     const confirmButton = document.getElementById("cornfim-publication");
     confirmButton.addEventListener('click', async function (event) {

        const valueImg = document.getElementById("image");
        const valueDescription = document.getElementById("description");
        const archivo = valueImg.files[0];
        console.log(valueImg);
        event.preventDefault()
        if (archivo) {
            const dataRequest = new FormData();
            dataRequest.append("action", "createPublication");
            dataRequest.append("image", archivo); 
            dataRequest.append("description", valueDescription.value);
            const url = location.origin + "/api/src/models/createpublication.php";
            console.log(dataRequest);
            try {
                const response = await fetch(url, {
                    method: "POST",
                    body: dataRequest
                });
    
                if (!response.ok) {
                    throw new Error("Error en la solicitud: " + response.status);
                }
    
                const data = await response.json();
                console.log("Respuesta del servidor:", data);
                location.reload()
                
    
            } catch (error) {
                console.error("Error en la solicitud:", error.message);
            }
        } else {
            console.error("No se ha seleccionado ningún archivo");
        }
    });
}

