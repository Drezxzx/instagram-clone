<?php
session_start();
require_once('../models/logic.php');

$dataRequest = trim(file_get_contents("php://input"));
$arDataRequest = json_decode($dataRequest, true);

switch ($arDataRequest["action"]) {
    case 'createUser':
        $data = createUser($arDataRequest["name"],$arDataRequest["lastname"],$arDataRequest["password"],$arDataRequest["mail"],$arDataRequest["username"]);
        echo json_encode($data);
        break;
    case 'getData':
        $data = getUser($arDataRequest["id"]);
        echo json_encode($data);
        break;
    case 'related':
        $data = related();
        echo json_encode($data);
        break;
    case 'getUserInformation':
        $data = getUserInformation($arDataRequest["id"]);
        if (isset($_SESSION['id'])) {
            echo json_encode(["data"=>$data, "idLogin"=>$_SESSION['id']] );
        }else{
            echo json_encode(["data"=>$data]);
        }
        
        break;
    case 'isLogin':
        if (isset($_SESSION['id'])) {
           echo json_encode(true);
        }else {
            echo json_encode(false);
        }
        break;
    case 'unfollow':
        $data = unfollow($_SESSION['id'],$arDataRequest["id"] );
        echo json_encode($data);
        break;
    case 'follow':
        $data = follow($_SESSION['id'],$arDataRequest["id"] );
        echo json_encode($data);
        break;
    case 'GetNameID':
        $data = GetNameID($arDataRequest["id"]);
        echo json_encode($data);
        break;
    case 'getprofilepic':
        $data = getprofilepic($_SESSION['id']);
        echo json_encode($data);
        break;
    case 'getFollowersAndFollowed':
        $data =  getFollowersAndFollowed($arDataRequest["id"]);
        echo json_encode($data);
        break;
    case 'isFollowed':
        if (isset($_SESSION['id']) && $_SESSION["id"] != $arDataRequest["id"])  {
            $data =  isFollowed($_SESSION["id"], $arDataRequest["id"]);
            echo json_encode($data);
        }else if (isset($_SESSION['id']) && $_SESSION["id"] == $arDataRequest["id"]){
            $data = "same";
            echo json_encode($data);
        }else{
            $data = "No login";
            echo json_encode($data);
        }
        break;
    case 'getComent':
        $data = getComent($arDataRequest["id"]);
        echo json_encode($data);
        break;
    case 'editUser':
        $data = editUser($_SESSION["id"],$arDataRequest["name"],$arDataRequest["lastname"],$arDataRequest["password"],$arDataRequest["img"]);
        echo json_encode($data);
        break;
    case 'getPublications':
        if (isset($_SESSION['user_name']) && isset($_SESSION['id'])) {
            $data = getPublicationsLiked($_SESSION['id']);
        } else {
            $data = getPublications();
        }
        echo json_encode($data);
        break;
        
    case 'getUserPublications':
        if (isset($_SESSION['user_name']) && isset($_SESSION['id'])) {
            $data = getUserPublications($arDataRequest["id"],$_SESSION['id'] );
        }else{
            $data = getUserPublications($arDataRequest["id"]);
            
        }
        echo json_encode($data);
        break;
    case 'getLikes':
        $data = getLikes($arDataRequest["idpublication"], );
        echo json_encode($data);
        break;
    case 'search':
        $data = search($arDataRequest["value"]);
        echo json_encode($data);
        break;
    case 'giveLike':
        $data = giveLike($arDataRequest["idpublication"], $_SESSION['id']);
        echo json_encode($data);
        break;
    case 'deleteLike':
        $data = deleteLike($arDataRequest["idpublication"], $_SESSION['id']);
        echo json_encode($data);
        break;
    case 'createPublication':
        if (isset($arDataRequest["img"])) {
            $data = createPublication($arDataRequest["image"], $arDataRequest["description"],$_SESSION['id'] );
            echo json_encode($data);
        } else {
            $data = ["error" => "No se proporcionó ninguna imagen"];
            echo json_encode($data);
        }
        break;
    case 'createNewComent':
        if (isset ($_SESSION['id'])) {
        if (isset($arDataRequest["id"]) && isset($arDataRequest["newComnet"])) {
            $data = createNewComent($arDataRequest["id"], $arDataRequest["newComnet"],$_SESSION['id']);
            echo json_encode($data);
        } else {
            $data = ["error" => "Faltan datos"];
            echo json_encode($data);
        }
        } else {
            $data = ["error" => "No session"];
            echo json_encode($data);
        }
        break;
    case 'closeSession':
        if ($_SESSION['user_name']) {
            session_unset();
            session_destroy();
            $data = ["success" => "Sesión cerrada correctamente"];
            echo json_encode($data);
        } else {
            $data = ["error" => "No hay sesión activa"];
            echo json_encode($data);
        }
        break;
    case 'login':
        $data = login($arDataRequest["email"], $arDataRequest["password"]);
        foreach ($data["result"] as $key => $value) {
            $_SESSION['user_name'] = $value["name"];
            $_SESSION['user_mail'] = $value["mail"];
            $_SESSION['id'] = $value["iduser"];
        }
        echo json_encode($data);
        break;
    default:
        $data = ["error" => "Acción no válida"];
        echo json_encode($data);
        break;
}


?>