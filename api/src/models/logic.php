<?php

require "useDB.php";
function getUser($id) {
    $data = select_useDB($id);
    $dataReturn = ["result" => []];
    if ($data) {
        foreach ($data["data"] as $value) {
            array_push($dataReturn["result"], $value);
        }
    } else {
        $dataReturn["result"] = []; 
    }
    return $dataReturn;
}

function getUserInformation($id) {
    $data = getUserInformation_useDB($id);
    $dataReturn = ["result" => []];
    if ($data) {
        foreach ($data["data"] as $value) {
            array_push($dataReturn["result"], $value);
        }
    } else {
        $dataReturn["result"] = []; 
    }
    return $dataReturn;
}
function createUser($name, $lastname, $password, $mail, $username)
{
    $img = "../../public/img/no-user.webp";
    $data = createUser_useDB($name, $lastname, $password, $mail, $username, $img);

    if ($data["status"] === "success") {
        return $data["status"];
    } else {
        return $data["message"];
    }
}

function getprofilepic($id) {
    $data = getprofilepic_useDB($id);
    $dataReturn = ["result" => []];
    if ($data) {
        foreach ($data["data"] as $value) {
            array_push($dataReturn["result"], $value);
        }
    } else {
        $dataReturn["result"] = []; 
    }
    return $dataReturn;
}
function editUser($id, $name, $lastname, $password, $imgData)
{
    $uploadDirectory = realpath(__DIR__ . '/../../public/img') . '/';
    $fileName = $id . '_' . basename($imgData['name']);
    $uploadFilePath =  "../../public/img/". $fileName;

    if (move_uploaded_file($imgData['tmp_name'], $uploadDirectory)) {
        $data = editUser_useDB($id, $name, $lastname, $password, $uploadFilePath);

        $dataReturn = ["result" => []];

        if ($data["status"] === "success") {
            $dataReturn["result"] = ["message" => "Usuario actualizado exitosamente"];
        } else {
            $dataReturn["result"] = ["error" => $data["message"]];
        }

        return $dataReturn;
    } else {

        return ["result" => ["error" => "Error al subir la nueva imagen"]];
    }
}

function getFollowersAndFollowed($id) {
    $data = getFollowersAndFollowed_useDB($id);
    $dataReturn = ["result" => []];
    
    if ($data["status"] === "200") {
        foreach ($data["data"] as $value) {
            $dataReturn["result"][] = $value;
        }
    } else {
        $dataReturn["error"] = $data["status"]; 
    }
    
    return $dataReturn;
}
function isFollowed($idfollower, $followed_id) {
    $data = isFollowed_useDB($idfollower, $followed_id);
    $dataReturn = ["result" => [],
                    "error" =>[]           ];

    if ($data["status"] === "200") {
        $dataReturn["result"] = $data["data"]; 
    } else {
        $dataReturn["error"] = $data["status"];
    }

    return $dataReturn;
}
function unfollow($idfollower,$idfollowed) {
    $data = unfollow_useDB($idfollower,$idfollowed);
    $dataReturn = ["result" => []];

    if ($data["status"] === "200") {
        $dataReturn["result"] = "Eliminado Correctamente"; 
    } else {
        $dataReturn["error"] = "Algo falló";
    }

    return $dataReturn;
}
function follow($idfollower,$idfollowed) {
    $data = follow_useDB($idfollower,$idfollowed);
    $dataReturn = ["result" => []];

    if ($data["status"] === "200") {
        $dataReturn["result"] = "Agregado Correctamente"; 
    } else {
        $dataReturn["error"] = "Algo falló";
    }

    return $dataReturn;
}


function GetNameID($id) {
    $data = select_useDB($id);
    $dataReturn = ["result" => []];

    if ($data) {
        foreach ($data["data"] as $value) {
            array_push($dataReturn["result"], $value);
        }
    } else {
        $dataReturn["result"] = []; 
    }

    return $dataReturn;
}
function getComent($id) {
    $data = getComent_useDB($id);
    $dataReturn = ["result" => []];

    if ($data) {
        foreach ($data["data"] as $value) {
            array_push($dataReturn["result"], $value);
        }
    } else {
        $dataReturn["result"] = []; 
    }

    return $dataReturn;
}
function search($value) {
    $data = search_useDB($value);
    $dataReturn = [
                    "user" =>[]   ];

    if ($data["user"]) {
        foreach ($data["user"] as $value) {
            array_push($dataReturn["user"], $value);
        }
    }

    return $dataReturn;
}
function related() {
    $data = related_useDB();
    $dataReturn = [
                    "user" =>[]   ];

    if ($data["data"]) {
        foreach ($data["data"] as $value) {
            array_push($dataReturn["user"], $value);
        }
    }

    return $dataReturn;
}



function getPublications() {
    $data = getPublications_useDB();
    $dataReturn = [
        "result" => []
    ];

    if ($data && isset($data["data"])) {
        $dataArray = $data["data"];
        for ($i = count($dataArray) - 1; $i >= 0; $i--) {
            array_push($dataReturn["result"], $dataArray[$i]);
        }
    } else {
        $dataReturn["error"] = "No data";
    }

    return $dataReturn;
}
function getUserPublications($id, $idlogin=null) {
    $data = getUserPublications_useDB($id, $idlogin);
    $dataReturn = [
        "result" => [],
        "liked"  =>[]
    ];

    if ($data && isset($data["data"])) {
        $dataArray = $data["data"];
        for ($i = count($dataArray) - 1; $i >= 0; $i--) {
            array_push($dataReturn["result"], $dataArray[$i]);
        }
        if (isset($data["likedPublication"]) && count($data["likedPublication"]) > 0) {
            foreach ($data["likedPublication"] as  $value) {
                array_push($dataReturn["liked"], $value);
            }
        }else{
            $dataReturn["liked"] = "False";
        }
    } else {
        $dataReturn["error"] = "No data";
    }

    return $dataReturn;
}
function getPublicationsLiked($id) {
    $data = getPublicationsLiked_useDB($id);
    $dataReturn = [
        "result" => [],
        "liked"  =>[]
    ];

    if ($data && isset($data["data"])) {
        $dataArray = $data["data"];
        for ($i = count($dataArray) - 1; $i >= 0; $i--) {
            array_push($dataReturn["result"], $dataArray[$i]);
        }
        if (isset($data["likedPublication"]) && count($data["likedPublication"]) > 0) {
            foreach ($data["likedPublication"] as  $value) {
                array_push($dataReturn["liked"], $value);
            }
        }else{
            $dataReturn["liked"] = "False";
        }
    } else {
        $dataReturn["error"] = "No data";
    }

    return $dataReturn;
}


function login($email, $password) {
$data = login_useDB($email, $password);
$dataReturn = [
    "result" => []
];
if ( $data ) {
    foreach ( $data["data"] as $value ) {
        array_push($dataReturn["result"], $value); 
    }
}else {
    $dataReturn= ["No data"];
}
return $dataReturn;
}
function deleteLike($idpublication, $iduser) {
    $data = deleteLike_useDB($idpublication, $iduser);
    $dataReturn = [];

    if ($data && isset($data["status"]) && $data["status"] === "200") {
    
        $dataReturn["success"] = "Like eliminado correctamente";
    } else {
 
        $dataReturn["error"] = "Error al eliminar el like";
    }

    return $dataReturn;
}


function getLikes($idpublication) {
$data = getLikes_UseDB($idpublication);
$dataReturn = [
    "result" => []
];
if ( $data ) {
    foreach ( $data["data"] as $value ) {
        array_push($dataReturn["result"], $value); 
    }
}else {
    $dataReturn= "No data";
}
return $dataReturn;
}
function giveLike($idpublication, $iduser) {
    $date = date("Y-m-d");
    $dataa = giveLike_UseDB($idpublication, $iduser, $date);
    
    $dataReturn = [];

    if ($dataa && isset($dataa["status"]) && $dataa["status"] === "200") {
    
        $dataReturn["success"] = "Like registrado correctamente";
    } else {
 
        $dataReturn["error"] = "Error al registrar el like";
    }

    return $dataReturn;
}
function createNewComent($idpublication, $newcomnet, $iduser) {
    $date = date("Y-m-d");
    $dataa = createNewComent_UseDB($newcomnet,$idpublication,$date, $iduser);
    
    $dataReturn = [];

    if ($dataa && isset($dataa["status"]) && $dataa["status"] === "200") {
    
        $dataReturn["success"] = "Like registrado correctamente";
    } else {
 
        $dataReturn["error"] = "Error al registrar el like";
    }

    return $dataReturn;
}







?>