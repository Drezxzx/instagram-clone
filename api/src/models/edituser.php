<?php
require "conectionDB.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $id = $_SESSION['id'];
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
   $username = $_POST["username"];
    $description = $_POST["description"];

    if (isset($_FILES["img"]) && $_FILES["img"]["size"] > 0) {
        $uploadDirectory = realpath(__DIR__ . '/../../public/img') . '/';

        $imageName = $_FILES["img"]["name"];
        $imageTmpName = $_FILES["img"]["tmp_name"];

        $uniqueName = uniqid() . "_" . $imageName;
        $uploadPath = "../../public/img/" . $uniqueName;

        if (move_uploaded_file($imageTmpName, $uploadPath)) {
            $conn = conectoBD("normal");

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("UPDATE users SET name=?, lastname=?,  nameimg=?, description=? WHERE iduser=?");

            $stmt->bind_param("ssssssi", $name, $lastname,  $uploadPath, $description,$username, $id);

            if ($stmt->execute()) {
                echo json_encode(["success" => "Usuario actualizado correctamente"]);
            } else {
                echo json_encode(["error" => "Error al actualizar el usuario: " . $stmt->error]);
            }

            $stmt->close();
            $conn->close();
        } else {
            echo json_encode(["error" => "Error al subir la nueva imagen"]);
        }
    } else {
        $conn = conectoBD("normal");

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("UPDATE users SET name=?, lastname=?,  description=? WHERE iduser=?");

        $stmt->bind_param("sssss", $name, $lastname,  $description, $id, $username);

        if ($stmt->execute()) {
            echo json_encode(["success" => "Usuario actualizado correctamente"]);
        } else {
            echo json_encode(["error" => "Error al actualizar el usuario: " . $stmt->error]);
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo json_encode(["error" => "Método de solicitud no permitido"]);
}
?>
