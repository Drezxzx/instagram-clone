const urll = location.origin + "/api/src/ajax/ajax.php";
async function login(email,password) {
    const dataRequest ={
        action : "login",
        email  : email,
        password : password
    }
    try {
      const data = await fetch(location.origin + "/api/src/ajax/ajax.php",{
        method : "POST",
        body   : JSON.stringify(dataRequest),
        headers:{
            "Content-Type": "application/json"
        }
    })
    if (!data.ok) {
      throw new Error(data.status)
    }else{
      const dataName = await data.json()
      const input = document.querySelectorAll(".input-login")
      let mensaje = document.querySelector(".msg-login")
      return new Promise((resolve, reject) => {
        if (dataName["result"] && dataName.result.length > 0) {
          console.log(dataName);
          for (const name of dataName["result"]) {
            resolve (name.mail)
            location.reload()
          }
        }else{
          mensaje.innerHTML= "Nombre de usuario o contraseña incorrectos."
          input.forEach(element => {
            element.addEventListener("click", ()=>{mensaje.innerHTML=""})
          });
          console.log(mensaje);
          reject("No data")
        }
      })  
    }
  } catch (error) {
    console.log(error);
  }  
  
}

 async function Sessionclose(){
  console.log(urll);
const dataRequest ={
  action : "closeSession"
}
const data = await fetch(urll,{
  method : "POST",
  body   : JSON.stringify(dataRequest),
  headers : {
    "Content-type" : "aplication.json"
  }
})
try {
  if (!data.ok) {
    throw new Error (data.status)
  } else {
    const dataOBJ = await data.json()
    if (dataOBJ) {
      location.reload()
    }
  }
} catch (error) {
  console.log(error);
}
}

function handleEventsCloseForms() {
  const closeLogin = document.querySelector(".close-login")
  const formLogin = document.querySelector(".form-login")
  if (closeLogin) {
    closeLogin.addEventListener("click", ()=>{
      formLogin.classList.add("hidden")
    })
  }
  console.log(closeLogin);
}