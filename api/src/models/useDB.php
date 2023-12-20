<?php
require "conectionDB.php";
function createUser_useDB($name, $lastname, $password, $mail, $username,$img)
{
    $conn = conectoBD("normal");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO users (name, lastname, mail, password, username,nameimg) VALUES (?, ?, ?, ?, ?,?)");
    $stmt->bind_param("ssssss", $name, $lastname, $mail, $password, $username,$img);

    $data = ["status" => ""];

    if ($stmt->execute()) {
        $data["status"] = "success";
    } else {
        $data["status"] = "error";
        $data["message"] = "Error al crear el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    return $data;
}

function giveLike_UseDB($idpublication, $iduser, $date)
{
    $data = [
        "status" => ""

    ];

    $conn = conectoBD("normal");
    $sql = "INSERT INTO likes (idpublications,idliker,  date) VALUES ('$idpublication', '$iduser', '$date')";

    // Imprimir la sentencia SQL para debug

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        $data["status"] = "200";

    } else {
        $data["status"] = "400";

    }


    return $data;
}
function createNewComent_UseDB($coment, $idpublication, $date, $iduser)
{
    $data = ["status" => ""];
    $conn = conectoBD("normal");
    $sql = "INSERT INTO coments (coment, `date`, iduser, idpublications) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $coment, $date, $iduser, $idpublication);

    if ($stmt->execute()) {
        $data["status"] = "200";
    } else {
        $data["status"] = "400";
    }

    $stmt->close();
    $conn->close();

    return $data;
}
function editUser_useDB($id, $name, $lastname, $password, $img)
{
    $conn = conectoBD("normal");
    $stmt = $conn->prepare("UPDATE users SET name=?, lastname=?, password=?, nameimg=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $lastname, $password, $img, $id);
    $data = ["status" => ""];
    if ($stmt->execute()) {
        $data["status"] = "success";
    } else {
        $data["status"] = "error";
        $data["message"] = "Error al actualizar el usuario: " . $stmt->error;
    }
    $stmt->close();
    return $data;
}

function deleteLike_useDB($idpublication, $iduser)
{
    $data = [
        "status" => "",
        "data" => ""
    ];

    $conn = conectoBD("normal");
    $sql = "DELETE  FROM likes WHERE idpublications = $idpublication && idliker= $iduser";



    if ($conn->query($sql) === TRUE) {
        $data["status"] = "200";

    } else {
        $data["status"] = "400";

    }


    return $data;
}
function unfollow_useDB($idfollower, $idfollowed)
{
    $data = [
        "status" => "",
        "data" => ""
    ];

    $conn = conectoBD("normal");
    $sql = "DELETE FROM USERFRIEND WHERE idfollower = $idfollower AND idfollowed = $idfollowed";
    
    if ($conn->query($sql) === TRUE) {
        $data["status"] = "200";
    } else {
        $data["status"] = "400";
    }

    return $data;
}
function follow_useDB($idfollower,$idfollowed)
{
    $data = [
        "status" => "",
        "data" => ""
    ];
    $conn = conectoBD("normal");
    $sql = "INSERT INTO USERFRIEND (idfollower, idfollowed) VALUES ($idfollower,$idfollowed)";
    
    if ($conn->query($sql) === TRUE) {
        $data["status"] = "200";
    } else {
        $data["status"] = "400";
    }

    return $data;
}

function select_useDB($id)
{
    $conn = conectoBD('normal');
    $sql = "SELECT nameimg, name FROM users WHERE iduser = $id";
    $result = $conn->query($sql);
    $dataReturn = [
        "status" => "",
        "data" => []
    ];
    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $dataReturn["status"] = "200";
            $dataReturn["data"][] = $row;
        } else {
            $dataReturn["status"] = "400";
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error;
    }

    return $dataReturn;
}
function related_useDB()
{
    $conn = conectoBD('normal');
    $sql = "SELECT nameimg, name, username, iduser FROM users LIMIT 5";
    $result = $conn->query($sql);
    $dataReturn = [
        "status" => "",
        "data" => []
    ];

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataReturn["data"][] = $row;
            }

            $dataReturn["status"] = "200";
        } else {
            $dataReturn["status"] = "400";
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error;
    }

    return $dataReturn;
}

function getUserInformation_useDB($id)
{
    $conn = conectoBD('normal');
    $sql = "SELECT * FROM users WHERE iduser = $id";
    $result = $conn->query($sql);
    $dataReturn = [
        "status" => "",
        "data" => []
    ];
    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $dataReturn["status"] = "200";
            $dataReturn["data"][] = $row;
        } else {
            $dataReturn["status"] = "400";
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error;
    }

    return $dataReturn;
}
function isFollowed_useDB($idfollower, $followed_id)
{
    $conn = conectoBD('normal');
    $sql = "SELECT idfollower, idfollowed FROM USERFRIEND
    WHERE idfollower = $idfollower AND idfollowed = $followed_id";
    $result = $conn->query($sql);
    $dataReturn = [
        "status" => "",
        "data" => false
    ];

    if ($result) {
        if ($result->num_rows > 0) {
            $dataReturn["status"] = "200";
            $dataReturn["data"] = true;
        } else {
            $dataReturn["status"] = "400";
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error;
    }

    return $dataReturn;
}

function getFollowersAndFollowed_useDB($id)
{
  
    $conn = conectoBD('normal');
    $sql1 = "SELECT COUNT(idfollowed) AS  SEGUIDORES
    FROM USERFRIEND
    WHERE idfollowed = $id
    GROUP BY idfollowed";
    $sql2 = "SELECT COUNT( idfollower) as SEGUIDOS FROM USERFRIEND WHERE  idfollower = $id GROUP BY  idfollower";
    
    $result = $conn->query($sql1);
    $result2 = $conn->query($sql2);
    
    $dataReturn = [
        "status" => "",
        "data" => []
    ];

    if ($result) {
        if ($result->num_rows >= 0) {
            $row = $result->fetch_assoc();
            $dataReturn["status"] = "200";
            $dataReturn["data"][] = $row;
        } else{
            $dataReturn["status"] = "400";
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error; 
    }
    if ($result2) {
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $dataReturn["data"][] = $row;
            }
        }
    }
    return $dataReturn;
}




function getprofilepic_useDB($id)
{
    $conn = conectoBD('normal');
    $sql = "SELECT nameimg FROM users WHERE iduser = $id";
    $result = $conn->query($sql);
    $dataReturn = [
        "status" => "",
        "data" => []
    ];
    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $dataReturn["status"] = "200";
            $dataReturn["data"][] = $row;
        } else {
            $dataReturn["status"] = "400";
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error;
    }

    return $dataReturn;
}

function getPublications_useDB()
{
    $conn = conectoBD('normal');
    $sql = "SELECT iduser, nameimg, description,idpublications,date  FROM publications";
    $result = $conn->query($sql);

    $dataReturn = [
        "status" => "",
        "data" => []
    ];

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataReturn["status"] = "200";
                $dataReturn["data"][] = $row;
            }
        } else {
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error;
    }
    $dataReturn["status"] = "400";
    return $dataReturn;
}

function getUserPublications_useDB($id, $idlogin = null)
{
    $conn = conectoBD('normal');
    $sql = "SELECT iduser, nameimg, description, idpublications, date FROM publications WHERE iduser = $id";
    $result = $conn->query($sql);

    $dataReturn = [
        "status" => "",
        "data" => [],
        "likedPublication" => []
    ];

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataReturn["status"] = "200";
                $dataReturn["data"][] = $row;
            }
        } else {
            $dataReturn["status"] = "400";
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error;
    }

    if ($idlogin !== null) {
        $sql2 = "SELECT idpublications FROM likes WHERE idliker = $idlogin ";
        $result2 = $conn->query($sql2);

        if ($result2) {
            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    $dataReturn["likedPublication"][] = $row;
                }
            }
        }
    }

    return $dataReturn;
}

function search_useDB($value)
{
    $conn = conectoBD('normal');

    $sql2 = "SELECT iduser, nameimg, username,name, 
    lastname
             FROM users
             WHERE LOWER(username) LIKE LOWER(?) LIMIT 50";
    $stmt2 = $conn->prepare($sql2);
    $param2 = "%" . strtolower($value) . "%";
    $stmt2->bind_param("s", $param2);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $dataReturn = [
        "status" => "",
        "user" => [],
       
    ];


    if ($result2) {
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $dataReturn["user"][] = $row;
            }
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["user"] = "Error en la consulta de usuarios: " . $conn->error;
    }

    $stmt2->close();
    $conn->close();

    return $dataReturn;
}

function getPublicationsLiked_useDB($id)
{
    $conn = conectoBD('normal');
    $sql = "SELECT iduser, nameimg, description,idpublications,date  FROM publications";
    $result = $conn->query($sql);

    $sql2 = "SELECT idpublications FROM likes WHERE idliker = $id ";
    $result2 = $conn->query($sql2);

    $dataReturn = [
        "status" => "",
        "data" => [],
        "likedPublication" => []
    ];

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataReturn["status"] = "200";
                $dataReturn["data"][] = $row;
            }
        } else {
            $dataReturn["status"] = "400";
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error;
    }
    if ($result2) {
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $dataReturn["likedPublication"][] = $row;
            }
        }
        return $dataReturn;
    }
}
function login_useDB($email, $password)
{
    $conn = conectoBD('normal');
    $sql = "SELECT iduser, mail,name FROM users WHERE mail ='$email' && password='$password'";
    $result = $conn->query($sql);

    $dataReturn = [
        "status" => "",
        "data" => []
    ];

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataReturn["status"] = "200";
                $dataReturn["data"][] = $row;
            }
        } else {
            $dataReturn["status"] = "400";
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error;
    }
    return $dataReturn;
}
function getLikes_UseDB($idpublication)
{
    $conn = conectoBD('normal');
    $sql = "SELECT COUNT(idpublications) as likes FROM likes WHERE idpublications = '$idpublication'
    GROUP BY idpublications;";
    $result = $conn->query($sql);

    $dataReturn = [
        "status" => "",
        "data" => []
    ];

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataReturn["status"] = "200";
                $dataReturn["data"][] = $row;
            }
        } else {
            $dataReturn["status"] = "400";
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error;
    }
    return $dataReturn;
}
function getComent_useDB($idpublication)
{
    $conn = conectoBD('normal');
    $sql = "SELECT u.name AS numbercoment, u.nameimg, c.* FROM coments AS c
    INNER JOIN users AS u ON c. iduser = u. iduser
    WHERE c.idpublications = $idpublication
    GROUP BY idcoments
    ORDER BY idcoments DESC"
    ;
    $result = $conn->query($sql);

    $dataReturn = [
        "status" => "",
        "data" => []
    ];

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dataReturn["status"] = "200";
                $dataReturn["data"][] = $row;
            }
        } else {
            $dataReturn["status"] = "400";
        }
    } else {
        $dataReturn["status"] = "500";
        $dataReturn["data"] = "Error en la consulta: " . $conn->error;
    }
    return $dataReturn;
}






