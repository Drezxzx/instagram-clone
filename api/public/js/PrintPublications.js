async function printPublications(data, type, grid = null) {
    let node = null;
    console.log(type);
    if (type === "all") {
        node = document.querySelector(".wrapper");
        
    } else {
        node = document.querySelector(".wrapperr");
    }
    node.innerHTML = "";
    const namePromises = data["result"].map((element) => getNamePublication(element.iduser));
    const names = await Promise.all(namePromises);
    console.log(names);
    if (grid === "colums") {
        for (const [index, element] of data["result"].entries()) {
            const likes = await Like(element.idpublications);
            let comments = await getComent(element.idpublications, "visible");
            comments !== "" ?comments = comments :  comments =`<span class="more-coments" id="${element.idpublications}"> Agregar Comentario</span>`  
            const publicationHTML = `
                <div class="publications">
                    <span class="id hidden">${element.idpublications}</span>
                        <a class="conteiner-name-img" href="../views/detailuser.php?id=${element.iduser}">
                        <div class="img-profile"><img src="${names[index].nameimg}" class="circle100" alt="profile picture"></div>
                            <div class="name-date">
                            <strong class="nameUser">${names[index].username}</strong>
                            <p class="date-publication">${element.date}</p>
                            </div>
                        </a>
                    <div class="img"><img class="width100" src="${element.nameimg}" alt=""></div>
                    <div class="buttonadd">
                        ${data.liked ? printButton("yes", data, element.idpublications) : printButton("no", data, element.idpublications)}  
                        <button class="addComent" id="${element.idpublications}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                        <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894m-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                      </svg>
                        </button>
                    </div>
                    <h5 class="likes" id="likes-${element.idpublications}"> ${likes} me gusta</h5>
                    <div class="description"><span>${element.description}</span></div>
    
                    ${comments}
                </div>`;
    
            node.innerHTML += publicationHTML;
        }
    }else{
        data.result.forEach(element => {
           
            node.innerHTML+= `<div class="grid-img"><img src="${element.nameimg}" class="img-grig100" alt=""></img></div>`
          
        });
    }
    eventlike();
    createNewComentClick();
    return true;
}

async function eventlike() {
    const buttonLike = document.querySelectorAll(".addLike");
    const buttonLiked = document.querySelectorAll(".disable");

    buttonLiked.forEach((button) => {
        button.removeEventListener('click', handleUnlike);
        button.addEventListener('click', handleUnlike);
    });

    buttonLike.forEach((button) => {
        button.removeEventListener('click', handleLike);
        button.addEventListener('click', handleLike);
    });
}

async function handleUnlike() {
    try {
        const islogin = await isLogin();
        if (!islogin) {
            showLogin();
            return;
        }

        const idpublication = getPublicationId(this);
        await deleteLike(idpublication);

        const likesElement = getLikesElement(idpublication);
        const likes = await Like(idpublication);
        updateLikeButton(this, likesElement, likes, true);
    } catch (error) {
        console.error(error);
    }
}

async function handleLike() {
    try {
        const islogin = await isLogin();
        if (!islogin) {
            showLogin();
            return;
        }

        const idpublication = getPublicationId(this);
        await giveLike(idpublication);

        const likesElement = getLikesElement(idpublication);
        const likes = await Like(idpublication);
        updateLikeButton(this, likesElement, likes, false);
    } catch (error) {
        console.error(error);
    }
}

function getPublicationId(element) {
    const target = element.closest('.publications');
    return target.querySelector('.id').textContent;
}

function getLikesElement(idpublication) {
    return document.getElementById(`likes-${idpublication}`);
}

function updateLikeButton(button, likesElement, likes, isUnlike) {
    button.classList.remove(isUnlike ? "disable" : "addLike");
    button.classList.add(isUnlike ? "addLike" : "disable");
    button.innerHTML = isUnlike
        ? `<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 248, 248, 1);transform: ;msFilter:;"><path d="M12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412l7.332 7.332c.17.299.498.492.875.492a.99.99 0 0 0 .792-.409l7.415-7.415c2.354-2.354 2.354-6.049-.002-8.416a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595zm6.791 1.61c1.563 1.571 1.564 4.025.002 5.588L12 18.586l-6.793-6.793c-1.562-1.563-1.561-4.017-.002-5.584.76-.756 1.754-1.172 2.799-1.172s2.035.416 2.789 1.17l.5.5a.999.999 0 0 0 1.414 0l.5-.5c1.512-1.509 4.074-1.505 5.584-.002z"></path></svg>`
        : `<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(240, 7, 7, 1);transform: ;msFilter:;"><path d="M20.205 4.791a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412L12 21.414l8.207-8.207c2.354-2.353 2.355-6.049-.002-8.416z"></path></svg>`;

    likesElement.textContent = `${likes} me gusta`;
}

async function getNamePublication(id) {
    console.log(id);
    const dataRequest = {
        action: "getData",
        id: id
    };

    try {
        const response = await fetch(location.origin + "/api/src/ajax/ajax.php", {
            method: "POST",
            body: JSON.stringify(dataRequest),
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`Error de red: ${response.status}`);
        } else {
            const data = await response.json();
            console.log(data);
            return { nameimg: data["result"].map(name => name.nameimg).join(', '), username: data["result"].map(name => name.name).join(', ') };
        }
    } catch (error) {
        console.error(`Error en la solicitud: ${error.message}`);
        return { nameimg: '', username: '' };
    }
}
async function Like( value = null) {
            try {
                const data = await fetch(location.origin + "/api/src/ajax/ajax.php", {
                    method: "POST",
                    body: JSON.stringify({
                        action: "getLikes",
                        idpublication: value
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!data.ok) {
                    throw new Error("Hubo un error: " + data.statusText);
                }

                const dataOBJ = await data.json();
                if (dataOBJ["result"].length > 0) {
                    return dataOBJ["result"][0].likes;
                }else{
                    return "0"
                }
            } catch (error) {
                console.log("Hubo un error: " + error);
               
            }    
}
async function giveLike(value) {
    const dataRequest = {
        action: "giveLike",
        idpublication: value
    }
    const data = await fetch(location.origin + "/api/src/ajax/ajax.php", {
        method: "POST",
        body: JSON.stringify(dataRequest),
        headers: {
            'Content-Type': 'application/json'
        }
    });
    
    if (!data.ok) {
        throw new Error("Hubo un error: " + data.statusText);
    }
    
    try {
        const dataOBJ = await data.json();
        console.log(dataOBJ);
        if (dataOBJ) {
        }
    } catch (error) {
        console.log("Error al convertir la respuesta a JSON: " + error);
    }
    eventlike()
}

function printButton(disable,data, idpublication) {
    console.log(disable);
    let button = "";
    if (disable === "yes") {
        let objIndex = data.liked;
        const  likedPublications= new Set()
        for (const idliked of objIndex) {
            likedPublications.add(idliked.idpublications)
        }
        if (likedPublications.has(idpublication)) {
                 button = `<button class="disable"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(240, 7, 7, 1);transform: ;msFilter:;"><path d="M20.205 4.791a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412L12 21.414l8.207-8.207c2.354-2.353 2.355-6.049-.002-8.416z"></path></svg></button>`;
        }else{
                 button = `<button class="addLike"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 248, 248, 1);transform: ;msFilter:;"><path d="M12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412l7.332 7.332c.17.299.498.492.875.492a.99.99 0 0 0 .792-.409l7.415-7.415c2.354-2.354 2.354-6.049-.002-8.416a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595zm6.791 1.61c1.563 1.571 1.564 4.025.002 5.588L12 18.586l-6.793-6.793c-1.562-1.563-1.561-4.017-.002-5.584.76-.756 1.754-1.172 2.799-1.172s2.035.416 2.789 1.17l.5.5a.999.999 0 0 0 1.414 0l.5-.5c1.512-1.509 4.074-1.505 5.584-.002z"></path></svg></button>`;
        } 
    }else{
        button = `<button class="addLike"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 248, 248, 1);transform: ;msFilter:;"><path d="M12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412l7.332 7.332c.17.299.498.492.875.492a.99.99 0 0 0 .792-.409l7.415-7.415c2.354-2.354 2.354-6.049-.002-8.416a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595zm6.791 1.61c1.563 1.571 1.564 4.025.002 5.588L12 18.586l-6.793-6.793c-1.562-1.563-1.561-4.017-.002-5.584.76-.756 1.754-1.172 2.799-1.172s2.035.416 2.789 1.17l.5.5a.999.999 0 0 0 1.414 0l.5-.5c1.512-1.509 4.074-1.505 5.584-.002z"></path></svg></button>`;
    }

    return button;
}
async function deleteLike(value) {
    console.log(value);
    const dataRequest = {
        action: "deleteLike",
        idpublication: value,
    }
    try {
        const data = await fetch(location.origin + "/api/src/ajax/ajax.php", {
            method: "POST",
            body: JSON.stringify(dataRequest),
            headers: {
                'Content-Type': 'application/json'
            }
        });
        if (!data.ok) {
            throw new Error("Hubo un error: " + data.statusText);
        }
        const dataOBJ = await data.json();
        if (dataOBJ) {
            console.log(dataOBJ);
           
            
        } else {
            console.log("data no existe");
        }
    } catch (error) {
        console.log("Hubo un error: " + error);
    }
    eventlike()
}
async function getComent(id, action = null) {
    let dataReturn = "";
    const data = await fetch(location.origin + "/api/src/ajax/ajax.php", {
        method: "POST",
        body: JSON.stringify({
            action: "getComent",
            id: id
        })
    });

    try {
        const dataOBJ = await data.json();
        let numbercomenst= null
        if (dataOBJ.result.length > 0) {
            numbercomenst = dataOBJ.result.length 
        }else{
            numbercomenst = (dataOBJ.result.length - 1)
        }
        await Promise.all(dataOBJ.result.map(async function (element) {
            if (action === "visible"){
                        dataReturn =`
                <div class="viseble-coment">
                <div class="coment-visible" id="comentid-${element.idcoments}">
                <div class="wrapper-img-"><img src="${element.nameimg}" class="img-coment" alt=""></div>
                <p><strong class="name-coment">${element.numbercoment}</strong></p>
                <p class="textcoment">${element.coment}</p>
                <p class="date hidden">${element.date}</p>
                </div>
                <span class="more-coments" id="${element.idpublications}"> Ver  ${numbercomenst} comentarios...</span>
            </div>`;
            }else if(action === "Fullcoments"){
                dataReturn += `
                    <div class="coment" id="comentid-${element.idcoments}">
                    
                    <div class="wrapper-img-"><img src="${element.nameimg}" class="img-coment" alt=""></div>
                    <div class="user-coments"> 
                    <span><strong class="name-coment">${element.numbercoment}<span class="date">${element.date}</span></strong></span>
                    <span class="textcoment">${element.coment}</span>
                    </div>
                    </div>
                </div>
                `
            }
        }));
            
        return dataReturn;
    } catch (error) {
        console.log(error);
    }
}

 function createNewComentClick() {
    const buttsonaddcoment = document.querySelectorAll(".addComent, .more-coments ")
    const nodeform = document.querySelector(".addNewComent")
    const newcomentt = document.getElementById("newcoment")
    const confirmButton = document.querySelector(".addcoment")
    console.log(newcomentt);
    console.log(confirmButton);
    buttsonaddcoment.forEach(button => {
        button.addEventListener('click',  (e)=>{
            nodeform.classList.toggle("hidden")
            document.body.style.overflow = 'hidden';
            const idpublication = button.id
            showOtherComent(idpublication)
            console.log(idpublication);
            confirmButton.addEventListener('click',async function(e) {
                e.preventDefault()
                try {
                    const islogin = await isLogin()
                    if (!islogin) {
                        showLogin()
                    }else{
                        createNewComent(idpublication, newcomentt, e)
                    }
                } catch (error) {
                    console.log(error);
                }
            })
        })
    });
}

async function createNewComent(idpublication, newcoment) {
    console.log(idpublication);
    const newcomenvalue = newcoment.value;
    const responde = await fetch(location.origin + "/api/src/ajax/ajax.php",{
        method : "POST",
        body   : JSON.stringify({
            action : "createNewComent",
            id     : idpublication,
            newComnet :newcomenvalue
        }),
        headers  :{
            "Content-type" : "aplication/json"
        }
    })
    try {
        const respondeData = await responde.json()
        console.log("Respuesta del servidor:");
        if (respondeData) {
            showOtherComent(idpublication)
        }
        
    } catch (error) {
        console.log(error);
    }
}

async function showOtherComent(idpublication) {
    const nodesectioncoments= document.querySelector(".addNewComent")
    const closesection = document.querySelector(".close-section-coment")
    let nodecoments = document.querySelector(".coments")
    let nodecomentsvisible = document.querySelector(".viseble-coment")
    const newcomentt = document.getElementById("newcoment")
    newcomentt.value =""
    nodecoments.innerHTML=""
    console.log(nodecomentsvisible);
    const coments = await getComent(idpublication, "Fullcoments")
    if (coments) {
        const comentsvisible = await getComent(idpublication, "visible")
        nodecoments.innerHTML= coments
        if (comentsvisible) {
            nodecomentsvisible.innerHTML= comentsvisible
        }
    }
    closesection.addEventListener("click", ()=>{
        nodesectioncoments.classList.add("hidden")
        document.body.style.overflow = 'auto';
    })
   

}









