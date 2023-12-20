<?php
session_start();    
require "../models/logic.php";

function printImg(){
    if (isset($_SESSION['id'])) {
        $img = getprofilepic($_SESSION['id']);
        return "<img src='{$img['result'][0]['nameimg']}' class='circle100' alt='profile picture'>";
    }else {
       return "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' style='fill: rgba(0, 0, 0, 1);transform: ;msFilter:;'><path d='M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z'></path></svg>";
    }

}
$img = printImg();


require "../views/viewmain.php";
?>