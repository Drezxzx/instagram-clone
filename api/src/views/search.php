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
    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="stylesheet" href="../../public/css/main.css">
    <script src="../../public/js/search.js"></script>
    <script src="../../public/js/login.js"></script>
    <script src="../../public/js/handleEvents.js"></script>
    <link rel="stylesheet" href="../../public/css/search.css">
    <link rel="stylesheet" href="../../public/css/responsivesearch.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>search</title>
</head>
<body>
   
<footer class="navegation">
<nav class="navegationbar"><a href="../controllers/main.php"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 255);transform: ;msFilter:;"><path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"></path></svg></a>
<a href="" class="create-publication"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 255);transform: ;msFilter:;"><path d="M4 5h13v7h2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-2H4V5z"></path><path d="m8 11-3 4h11l-4-6-3 4z"></path><path d="M19 14h-2v3h-3v2h3v3h2v-3h3v-2h-3z"></path></svg></a>
<?php 
if (isset($_SESSION["id"])) {
    echo "<a href='../views/detailuser.php?id={$_SESSION["id"]}'>$img</a>";
}?>
</a>
<a href="../views/search.php"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" style="fill: rgba(255, 243, 243, 1);transform: ;msFilter:;"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"></path></svg></a>
<?php if (isset($_SESSION["id"])) {
    echo "<button id='close' class='season '><svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 24 24' style='fill: rgba(255, 247, 247, 1);transform: ;msFilter:;'><path d='M16 13v-2H7V8l-5 4 5 4v-3z'></path><path d='M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z'></path></svg></button>";
}?>

</nav>
    </footer>
    <section class="search">
        <form class="search-form">
            <input type="text" id="search" placeholder="Buscar publicaciones, usuarios...">
        </form>
    </section>
    <section class="result">
        <div class="user"></div>
        <div class="publication"></div>
    </section>
</body>
</html>


