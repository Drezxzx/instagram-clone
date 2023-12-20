window.addEventListener("DOMContentLoaded", () => {
    console.log("hola");
    search()
    handleEvents()
    handleEventsCloseForms()
})

function search() {
    let nodeuser = document.querySelector(".user")
    let nodepublication = document.querySelector(".publication")
    let searchinput = document.getElementById("search")
    searchinput.addEventListener("input", async () => {
        console.log(searchinput.value);
        if (searchinput.value !== "") {
            nodepublication.innerHTML=""
            const response = await fetch(location.origin + "/api/src/ajax/ajax.php", {
                method: "POST",
                body: JSON.stringify({ action: "search", value :searchinput.value  }),
                headers: { "Content-type": "application/json" }
            })
        
        try {
            const dataOBJ = await response.json()
            console.log(dataOBJ);
            nodeuser.innerHTML = ""
            dataOBJ.user.forEach(user => {
                console.log(user);
                nodeuser.innerHTML += `<div class="user-detail">
                <a href="../../src/views/detailuser.php?id=${user.iduser}">
                <div class="img-search"><img src="${user.nameimg}" class="width100-search" alt=""></div>
                <div class="detail"><strong class="username">${user.username}</strong>
                <span class="name">${user.name} ${user.lastname}</span>

                </div></a>
                </div>`
            });
            console.log(dataOBJ);
        } catch (error) {
            console.error(error);
        }}else{
            nodepublication.innerHTML=`<h1 class="tittle-user">No hay resultados</h1>`
        }
    })
}