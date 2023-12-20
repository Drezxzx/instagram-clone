const url = location.href;
let idfollowed = url.split("?id=")[1]
window.addEventListener('load', async()=>{
    idfollowed = parseInt(idfollowed)
    console.log(typeof idfollowed);
    const printcolumspublications = document.getElementById("colum-publication")
    const printgridpublications = document.getElementById("table-publication")
    printcolumspublications.addEventListener("click", async(e)=>{
        e.preventDefault()
        await getUserPublication(idfollowed, "colums")
    })
    printgridpublications.addEventListener("click", async(e)=>{
        e.preventDefault()
        await getUserPublication(idfollowed, "grid")
    })
    const publications = await getUserPublication(idfollowed, "grid")
    if (publications) {
        handleEvntsFollow()
        eventlike();

    }else{
        const wrapper = document.querySelector(".wrapperr")
        wrapper.innerHTML ="<h3> Aun no ha Hecho nunguna publicación.</h3>"
    }
    handleEvents()
    checkSizeWindow()
    const user = await getUserInformation(idfollowed)
    const followers = await getFollowers(idfollowed, publications )

})

async function getUserPublication(idplayer,grid) {
    let datareturn = null
        const dataRequest = {
            action: "getUserPublications",
            id    : idplayer
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
              
                printPublications(responseData,"user", grid);
                responseData.result ? datareturn = responseData.result.length : datareturn = "0"
                return (datareturn)
            }
        } catch (error) {
            console.error("Error al obtener las publicaciones:", error);
        }
}
async function getFollowers(id, numpublications = null) {
    console.log(numpublications);
    if (numpublications === null) {
        numpublications = "0"
    }
        let deltail = document.querySelector(".detail-follow");
        let followers = document.querySelector(".follower")
        let followed= document.querySelector(".followed")
        console.log(followed);
        console.log(followers);
       
        const dataRequest = {
            action: "getFollowersAndFollowed",
            id: id
        };
    
        try {
            const data = await fetch(location.origin + "/api/src/ajax/ajax.php",{
                method: "POST",
                body: JSON.stringify(dataRequest),
                headers: {
                    "Content-type": "application/json"
                }
            });
    
            if (!data.ok) {
                throw new Error(data.status);
            }
    
            const dataReturn = await data.json();
            console.log(dataReturn.result);
            let followersData = {
                SEGUIDOS: dataReturn.result[1] || null,
                SEGUIDORES: dataReturn.result[0] || null
            };
            if (followersData.SEGUIDORES === null && followersData.SEGUIDOS === null) {
                console.log("null ambos");
                followersData.SEGUIDOS = null;
                followersData.SEGUIDORES = null;
            }
            else if (followersData.SEGUIDORES === null) {
                console.log("NULL SEGUIDORES");
                followersData.SEGUIDORES = null;
                followersData.SEGUIDOS = dataReturn.result[1].SEGUIDOS;
            }
            else if (followersData.SEGUIDOS === null) {
                console.log("NULLLL SEGUIDOS");
                followersData.SEGUIDOS = null;
                followersData.SEGUIDORES = dataReturn.result[0].SEGUIDORES;
            }
            else if ( followersData.SEGUIDOS !== null && followersData.SEGUIDORES !== null) {
                console.log("NO NULL NINGUNOS");
                followersData.SEGUIDOS = dataReturn.result[1].SEGUIDOS;
                followersData.SEGUIDORES = dataReturn.result[0].SEGUIDORES;
            }
          
              
        
            console.log(followersData);
           
            if (dataReturn.error >= 400) {
                deltail.innerHTML = `<div class="follower-wrapper"><p>SEGUIDOS<p><p>0</p></div> <div class="follower-wrapper"><h3>SEGUIDORES<h3><p>0</p></div> ` ;
            }
            
             if (dataReturn.result) {
                    console.log(followersData.SEGUIDOS);
                    console.log(followersData.SEGUIDORES);
                    if (idfollowed == "4") {
                        let SEGUIDOS = followersData.SEGUIDOS;
                        let SEGUIDORES = followersData.SEGUIDORES;
                        deltail.innerHTML = `<div class="follower-wrapper"><p>Publicaciones</p><h3>${numpublications}</h3></div><div class="follower-wrapper"><p>Seguidores</p><h3>1M</h3></div><div class="follower-wrapper"><p>SEGUIDOS</p><p>${SEGUIDOS}</p></div>` ;
                       }
                    else if (followersData.SEGUIDOS !== null && followersData.SEGUIDORES !== null) {
                        let SEGUIDOS = followersData.SEGUIDOS;
                        let SEGUIDORES = followersData.SEGUIDORES;
                        deltail.innerHTML = `<div class="follower-wrapper"><p>Publicaciones</p><h3>${numpublications}</h3></div><div class="follower-wrapper"><p>Seguidores</p><h3>${SEGUIDORES}</h3></div><div class="follower-wrapper"><p>SEGUIDOS</p><p>${SEGUIDOS}</p></div>` ;
                    }
                    else if(followersData.SEGUIDOS !== null){
                        let SEGUIDOS = followersData.SEGUIDOS;
                        deltail.innerHTML = `<div class="follower-wrapper"><p>Publicaciones</p><h3>${numpublications}</h3></div><div class="follower-wrapper"><p>Seguidores</p><h3> 0 </h3></div>
                         <div class="follower-wrapper"><p>Seguidos</p><h3>${SEGUIDOS}</h3> </div>` ;
                    }
                    else if (followersData.SEGUIDORES !== null) {
                        let SEGUIDORES = followersData.SEGUIDORES;
                        deltail.innerHTML = `<div class="follower-wrapper"><p>Publicaciones</p><h3>${numpublications}</h3></div><div class="follower-wrapper"><p>Seguidores</p><h3>${SEGUIDORES}</h3></div>
                        <div class="follower-wrapper"><p>Seguidos</p><h3> 0 </h3></div>` ;
                    }else{
                        console.log("HOLAAAAAAAAAAAA");
                        deltail.innerHTML = `<div class="follower-wrapper"><p>Publicaciones</p><h3>${numpublications}</h3></div><div class="follower-wrapper"><p>Seguidos</p><h3>0</h3></div> <div class="follower-wrapper"><p>Seguidores</p><h3>0</h3></div> ` ;
                    }  
                }
        } catch (error) {
            console.error(error);
        }
        handleEvntsFollow()
}

async function isFollower(id) {
    let dataReturn = ""
    const dataRequest = {
        action : "isFollowed",
        id     : id
    }

    const response = await fetch (location.origin + "/api/src/ajax/ajax.php",{
        method : "POST",
        body   : JSON.stringify(dataRequest),
        headers: {
            "Content-type" : "application/json"
        }
    })
    try {
        const responde = await response.json()
        console.log(responde);
        if (responde === "same") {
            dataReturn =""
            console.log("Nothing");
        }else if (responde.result === true){
            dataReturn = printButtonFollow("Unfollow")
        }else{
            dataReturn = printButtonFollow("Follow")
            console.log("no sigue");
        }
    } catch (error) {
        console.error(error);
    }
    
    return dataReturn
}
function printButtonFollow(action = null) {
    let dataReturn = ""
    if (action === "Follow") {
        dataReturn = `<button id="follow">Seguir</button>`
    } else {
        dataReturn = `<button id="unfolow">Dejar de seguir</button>`
    }
    return dataReturn
}
function handleEvntsFollow() {
    const buttonFollow = document.getElementById("follow")
    const buttonUnfollow = document.getElementById("unfolow")
    if (buttonUnfollow) {
        buttonUnfollow.addEventListener('click', (e)=>{
            e.preventDefault
            unfollow(idfollowed)
        });
    }
    if (buttonFollow) {
        buttonFollow.addEventListener('click', (e)=>{
            e.preventDefault()
            follow(idfollowed)
        });
    }
 
}
async function unfollow(idfollowed){
    const data = await fetch(location.origin + "/api/src/ajax/ajax.php",{
        method : "POST",
        body   :JSON.stringify({action : "unfollow", id : idfollowed}),
        headers : {"Content-type" : "application/json"}
    })

    const response = await data.json()
    if (response) {
       getFollowers(idfollowed)
      location.reload()
    }
    console.log(response);
}
async function follow(id) {
    const islogin = await isLogin()
    if (islogin) {
        
    const data = await fetch(location.origin + "/api/src/ajax/ajax.php", {
        method : "POST",
        body   : JSON.stringify({action : "follow", id : id}),
        headers : { "Content-type" : "application/json"}
    })
    const response = await data.json()
    if (response) {
        console.log(response);
        location.reload()
    }
}else{
    location.href = location.origin+"/api/src/controllers/main.php"
}
}
async function getUserInformation(id) {
    let nodedetail =document.querySelector(".user-information")
    const response = await fetch(location.origin + "/api/src/ajax/ajax.php",{
        method : "POST",
        body   : JSON.stringify({action : "getUserInformation", id : id}),
        headers : {
            "Content-type" : "application/json"
        }
        
    })
    try {

        const buttonFollow = await isFollower(idfollowed)
        let tittle = document.querySelector("title")
        const data = await response.json()
        let name = document.getElementById("nameuser").value;
        let lastname = document.getElementById("lastnameuser").value;
        let username = document.getElementById("username").value;
        data.data.result.forEach( datauser => {
            console.log(datauser);
            let description = ""
            datauser.description !==null ? description = datauser.description : description = ""
            tittle.innerHTML = "Profile "+datauser.username
            nodedetail.innerHTML = `<div class="username">
            <div class="img-detail"><img class="circle100-dtail" src="${datauser.nameimg}" alt="Profile picture ${datauser.name}">
            </div>
            <div class="wrapper-detail">
            <h1 class="username-detail">${datauser.username}</h1>
            <div class="buttons">`+(datauser.iduser !== data.idLogin ? "": `<button id="edit-user">Editar usuario</button>`) 
            +buttonFollow + `</div>
            </div>
            </div>
            <strong class="name-user">${datauser.name} ${datauser.lastname}</strong>
            <div class="description-user">${description}</div>
            `
            name = datauser.name
            lastname = datauser.lastname
            username = datauser.username
        });
        console.log(name);
        console.log(username);
        console.log(lastname);
        const buttondisplayedit = document.getElementById("edit-user")
        if (buttondisplayedit) {
            buttondisplayedit.addEventListener('click', (e)=>{
                e.preventDefault()
                editUser()
            })
        }
        console.log(buttondisplayedit);
    } catch (error) {
        console.error(error);
    }
    handleEvntsFollow()
}