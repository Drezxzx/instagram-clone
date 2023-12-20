 function createUser() {
    const nodeformcrete = document.querySelector(".create-user-show")
    const nodeforlogin = document.querySelector(".form-login")
    const nodeforcreate = document.querySelector(".create-user")
    const confirmButton = document.getElementById("confirm-user")
    nodeforcreate.classList.remove("hidden")
    console.log(nodeforcreate);
    confirmButton.addEventListener('click', async (e)=>{
        e.preventDefault()       
        const name = document.getElementById("nameuser")
        const lastname = document.getElementById("lastnameuser")
        const username = document.getElementById("lastnameuser")
        const mail = document.getElementById("mailuser")
        const password = document.getElementById("passworduser")
        const dataRequest = {
            name : name.value,
            username : username.value,
            action : "createUser",
            lastname : lastname.value,
            mail : mail.value,
            password : password.value

        }

        const response = await fetch(location.origin + "/api/src/ajax/ajax.php",{
            method  : "POST",
            body    : JSON.stringify(dataRequest),
            headers  : {
                'Content-Type': 'application/json'
            }
        })
        try {
            if (!response.ok) {
               throw new Error (`Error ${response.status}`)
            }
            const rsponseOBJ = await response.json()
            console.log(rsponseOBJ);
            login(mail.value,password.value)
        } catch (error) {
           console.error(`Error faral ${error.message}`);
        }
    })
    nodeformcrete.classList.toggle("hidden")
    nodeforlogin.classList.toggle("hidden")
    console.log("hola");
}