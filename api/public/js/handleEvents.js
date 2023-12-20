function handleEvents() {

    const closeButton = document.getElementById("close");
    const showcretepubli = document.querySelector(".create-publication");
    const showcreateuser = document.querySelector(".create-user-show");
    const showloginuser = document.querySelector(".form-login");
    const showcreatepubli = document.querySelector(".form-newpublication");
    const closesection = document.querySelectorAll(".close-section");
    const openlogin = document.querySelector(".open-login")


    if (showcretepubli) {
        showcretepubli.addEventListener('click', async (e) => {

            e.preventDefault();
            document.body.style.overflow = 'hidden';
            showcreatepubli.classList.toggle("hidden");

            try {
                const response =  createPublication();
                console.log(response);
            } catch (error) {
                console.error("Error en createPublication:", error.message);
            }
        });
    }
    if (openlogin) {
        openlogin.addEventListener("click", (e)=>{
            e.preventDefault()
            showloginuser.classList.toggle("hidden")
        })
       }
    if (showcreateuser) {
        showcreateuser.addEventListener('click', (e) => {
            e.preventDefault();
            createUser();
        });
    }

    if (closeButton) {
        closeButton.addEventListener('click', Sessionclose);
    }

    closesection.forEach(button => {
        button.addEventListener("click", () => {
            const section = button.closest("section");
            console.log(section);
            section.classList.toggle("hidden");
            document.body.style.overflow = 'auto';
        });
    });
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
                if (nodeForm) {
                    nodeForm.classList.add("hidden")
                }
                return dataOBJ
            }
        }
    } catch (error) {
        console.error(error);
    }
}