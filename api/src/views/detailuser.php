<?php
require "../models/logic.php";
session_start();
function printImg()
{
    if (isset($_SESSION['id'])) {
        $img = getprofilepic($_SESSION['id']);
        return "<img src='{$img['result'][0]['nameimg']}' class='circle100' alt='profile picture'>";
    } else {
        return "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' style='fill: rgba(0, 0, 0, 1);transform: ;msFilter:;'><path d='M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z'></path></svg>";
    }

}
$img = printImg();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../public/js/detailuser.js"></script>
    <script src="../../public/js/PrintPublications.js"></script>
    <script src="../../public/js/createpublication.js"></script>
    <script src="../../public/js/edituser.js"></script>
    <script src="../../public/js/handleEvents.js"></script>
    <script src="../../public/js/login.js"></script>
    <script src="../../public/js/responsive.js"></script>
    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="stylesheet" href="../../public/css/responsive.css">
    <link rel="stylesheet" href="../../public/css/detail.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title></title>
</head>
<body>
<section class="related"></section>
    <main> 
    <section class="user-information">
    </section>
    <section class="detail-follow">
        <div class="follower"></div>
        <div class="followed"></div>
    </section>
    <section class="changePublications">
        <span id="table-publication"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                style="fill: rgba(252, 252, 252, 1);transform: ;msFilter:;">
                <path
                    d="M4 21h15.893c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zm0-2v-5h4v5H4zM14 7v5h-4V7h4zM8 7v5H4V7h4zm2 12v-5h4v5h-4zm6 0v-5h3.894v5H16zm3.893-7H16V7h3.893v5z">
                </path>
            </svg></span>
        <span id="colum-publication"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                class="bi bi-collection" viewBox="0 0 16 16">
                <path
                    d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5z" />
            </svg></span>
        <!-- <span id="liked-publications"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                style="fill: rgba(252, 252, 252, 1);transform: ;msFilter:;">
                <path
                    d="M12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412l7.332 7.332c.17.299.498.492.875.492a.99.99 0 0 0 .792-.409l7.415-7.415c2.354-2.354 2.354-6.049-.002-8.416a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595zm6.791 1.61c1.563 1.571 1.564 4.025.002 5.588L12 18.586l-6.793-6.793c-1.562-1.563-1.561-4.017-.002-5.584.76-.756 1.754-1.172 2.799-1.172s2.035.416 2.789 1.17l.5.5a.999.999 0 0 0 1.414 0l.5-.5c1.512-1.509 4.074-1.505 5.584-.002z">
                </path>
            </svg></span> -->
    </section>
    <section class="wrapperr"></section>
</main>
    <section class="addNewComent hidden">
        <span class="close-section-coment"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                style="fill: rgba(113, 3, 3, 1);transform: ;msFilter:;">
                <path
                    d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z">
                </path>
            </svg></span>
        <form class="comments-form">
            <input type="text" placeholder="Escriba comentarió" id="newcoment">
            <button class="addcoment">Enviar</button>
        </form>
        <div class="coments"></div>
    </section>
    <section class="edit-user-secction hidden">
    <span class="close-section"><svg  xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" style="fill: rgba(113, 3, 3, 1);transform: ;msFilter:;">
                <path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path>
            </svg></span>
        <form class="edit-user-form">
            <label for="name">Nuevo Nombre
                <input type="text" id="nameuser">
            </label>
            <label for="username">Nuevo Username
                <input type="text" id="username">
            </label>
            <label for="lastname">Nuevo Apellido
                <input type="text" id="lastnameuser">
            </label>
            <label for="Descripción">Descripción
                <input type="text" id="Description">
            </label>

            <label for="image">Foto de perfil
                <input type="file" id="image" accept=".png, .jpg, .jpeg, .jfif">
            </label>
            <button id="confirm-user">Actualizar</button>
        </form>
    </section>
    <!-- <section class="addNewComent">
    <form >
        <input type="text" placeholder="Escriba comentarió" id="newcoment">
        <button class ="addcoment">Enviar</button>
    </form>
   </section> -->

    <footer class="navegation">
        <section class="related"></section>
    <nav class="navegationbar"><a href="../controllers/main.php" class="inicio"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 255);transform: ;msFilter:;">
                    <path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"></path>
                </svg></a>

                <?php 
                if (isset($_SESSION["id"])) {
                    echo "<a href='../views/detailuser.php?id={$_SESSION["id"]}' class='detail'>$img</a>";
                }?>
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