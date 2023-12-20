<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../public/js/startapp.js"></script>
    <script src="../../public/js/PrintPublications.js"></script>
    <script src="../../public/js/login.js"></script>
    <script src="../../public/js/newuser.js"></script>
    <script src="../../public/js/createpublication.js"></script>
    <script src="../../public/js/handleEvents.js"></script>
    <script src="../../public/js/responsive.js"></script>
    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="stylesheet" href="../../public/css/responsive.css">
    <link rel="stylesheet" href="../../public/css/main.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Principal Page</title>
</head>

<body>


    <section class="addNewComent hidden">
        <span class="close-section-coment"><svg  xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(113, 3, 3, 1);transform: ;msFilter:;">
                <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
            </svg></span>
        <form class="comments-form">
            <input type="text" placeholder="Escriba comentarió" id="newcoment">
            <button class="addcoment">Enviar</button>
            <div class="msg"></div>
        </form>
        <div class="coments"></div>
    </section>
    <section class="form-login hidden">
        <span class="close-section"><svg  xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(113, 3, 3, 1);transform: ;msFilter:;">
                <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
            </svg></span>
        <form class="login">
            <h2>Iniciar sección</h2>
            <label for="name">Correo electrónico
                <input class="input-login" type="text" id="name">
            </label>

            <label for="password">Contraseña
                <input class="input-login" type="password" id="password">
            </label>
            <a href="" class="create-user-show">¿No tienes cuenta? Crea una</a>
            <button id="confirm-login">
                Sign up
                <div class="arrow-wrapper">
                    <div class="arrow"></div>

                </div>
            </button>
            <div class="msg-login"></div>
        </form>

    </section>
    <section class="create-user hidden">
    <span class="close-section"><svg  xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(113, 3, 3, 1);transform: ;msFilter:;">
                <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
            </svg></span>
        <form class="create-user ">
            <label for="name">Nombre
                <input type="text" id="nameuser">
            </label>
            <label for="username">Username
                <input type="text" id="username">
            </label>
            <label for="lastname">Apellido
                <input type="text" id="lastnameuser">
            </label>
            <label for="mail">Correo electrónico
                <input type="text" id="mailuser">
            </label>
            <label for="password">Contraseña
                <input type="password" id="passworduser">
            </label>
            <button id="confirm-user">Confirmar</button>
            <div class="msg"></div>
        </form>
    </section>
    <section class="form-newpublication hidden">
    <span class="close-section"><svg  xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(113, 3, 3, 1);transform: ;msFilter:;">
                <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
            </svg></span>
            <form class="new-publication">
            <h1>Crear publicacion</h1>

            <label for="description">
                <input type="text" id="description">
                Descripción
            </label>
            <label for="image">
                <input type="file" id="image" accept=".png, .jpg, .jpeg, .jfif">
            </label>
            <button id="cornfim-publication">Subir</button>
        </form>
    </section>
    <div class="related"></div>
    <div class="wrapper"></div>
    <footer class="navegation">
        <nav class="navegationbar"><a href="../controllers/main.php" class="inicio"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 255);transform: ;msFilter:;">
                    <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"></path>
                </svg></a>
                <?php
                if (isset($_SESSION["id"])) {
                    echo "<a href='' class='create-publication'><svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' style='fill: rgba(255, 255, 255, 255);transform: ;msFilter:;'>
                    <path d='M4 5h13v7h2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-2H4V5z'></path>
                    <path d='m8 11-3 4h11l-4-6-3 4z'></path>
                    <path d='M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z'></path>
                </svg></a>";
                }
            
                ?>
                <?php 
                if (isset($_SESSION["id"])) {
                    echo "<a href='../views/detailuser.php?id={$_SESSION["id"]}' class='detail'>$img</a>";
                }else{
                    echo "<a href='' class='open-login'><svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' style='fill: rgba(240, 240, 240, 1);transform: ;msFilter:;'><path d='m13 16 5-4-5-4v3H4v2h9z'></path><path d='M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z'></path></svg></a>";
                }
                ?>
            </a>
            <a href="../views/search.php" class="buscar"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 243, 243, 1);transform: ;msFilter:;">
                    <path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path>
                </svg></a>
            <?php if (isset($_SESSION["id"])) {
                echo "<button id='close' class='season '><svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' style='fill: rgba(255, 247, 247, 1);transform: ;msFilter:;'><path d='M16 13v-2H7V8l-5 4 5 4v-3z'></path><path d='M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z'></path></svg></button>";
            } ?>

        </nav>
    </footer>
</body>

</html>