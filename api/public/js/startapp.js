window.addEventListener('load', async function () {
    try {
       const response =  await isLogin();
       if (!response) {
           showLogin();
       }
       const publications = await getPublications("colums");
       

    } catch (error) {
        console.error("Error en la carga de la página:", error);
    }
    checkSizeWindow()
    handleEventsCloseForms()
    eventlike();
    handleEvents();
});


async function getPublications(grid) {
    const dataRequest = {
        action: "getPublications"
    };

    try {
        const data = await fetch(location.origin + "/api/src/ajax/ajax.php", {
            method: "POST",
            body: JSON.stringify(dataRequest),
            headers: {
                "Content-Type": "application/json",
            }
        });

        console.log("Respuesta completa del servidor:", data);
        if (!data.ok) {
            throw new Error(`Error de red: ${data.status}`);
        } else {
            const responseData = await data.json();
            console.log("Respuesta JSON del servidor:", responseData);
            printPublications(responseData, "all", grid);
        }
    } catch (error) {
        console.log("Error al obtener las publicaciones:", error);
    }
}
async function isLogin() {
    const nodeForm = document.querySelector(".form-login")
     const response = await fetch(location.origin + "/api/src/ajax/ajax.php", {
            method : "POST",
            body   : JSON.stringify({action : "isLogin"}),
            headers: {"Content-type" : "application/json"}
        })
    try {
        const dataOBJ = await response.json()
        console.log(dataOBJ);
        if (dataOBJ) {
            if (dataOBJ ) {
                nodeForm.classList.add("hidden")
                return dataOBJ
            }
        }
    } catch (error) {
        console.error(error);
    }
}

function showLogin() {
    document.body.style.overflow = 'hidden';
    const nodeForm = document.querySelector(".form-login");
    const valueUser = document.getElementById("name");
    const valuePassword = document.getElementById("password");
    const buttonConfirm = document.getElementById("confirm-login");


        nodeForm.classList.remove("hidden");

        buttonConfirm.addEventListener('click', async function (e) {
            e.preventDefault();
            try {
                const name = await login(valueUser.value, valuePassword.value);
                if (name) {
                    nodeForm.classList.add("hidden");
                } else {
                    console.log("No existe el usuario");
                }
            } catch (error) {
                console.error("Error en login:", error.message);
            }
        });
    
}



