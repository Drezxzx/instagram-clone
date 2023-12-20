
function checkSizeWindow() {
    const anchoPantalla = window.innerWidth;
const altoPantalla = window.innerHeight;
if (anchoPantalla >= 1000  ) {
    createRelated()
}
console.log(`Ancho de la pantalla: ${anchoPantalla}`);
console.log(`Alto de la pantalla: ${altoPantalla}`);
}

async function createRelated() {
    const noderelated = document.querySelector(".related")
    const username = document.querySelector(".username-detail")
    const data = await fetch(location.origin + "/api/src/ajax/ajax.php", {
        method: "POST",
        body: JSON.stringify({ action: "related" }),
        headers: { "Content-type": "application/json" }
    })
    try {
        const responde = await data.json()
        noderelated.innerHTML=`<div class="user-related-wrapper">`
        noderelated.innerHTML=`<strong class="user-related-tittle">Sugerencias para ti </strong>`
        responde.user.forEach(user => {
        
                noderelated.innerHTML+=`
            <div >
            <a href="../../src/views/detailuser.php?id=${user.iduser}" class="user-related">
            <img src="${user.nameimg}" alt="" class="user-related">
            <div class="detail-user-related">
            <strong>${user.username}</strong>
            <span class="name-related">${user.name}</span>
            </div>
            </a>
            </div>`
            
        });
        noderelated.innerHTML+="</div>"
        console.log(responde);
    } catch (error) {
        console.error(error);
    }
    

}