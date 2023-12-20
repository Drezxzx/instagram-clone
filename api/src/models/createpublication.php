<?php
require "conectionDB.php";
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $description = $_POST["description"];
    $iduser = $_SESSION['id'];

    $uploadDirectory = realpath(__DIR__ . '/../../public/img') . '/';

    $imageName = $_FILES["image"]["name"];
    $imageTmpName = $_FILES["image"]["tmp_name"];

    $uniqueName = uniqid() . "_" . $imageName;
    $uploadPath = "../../public/img/" . $uniqueName;

    if (move_uploaded_file($imageTmpName, $uploadPath)) {

        $conn = conectoBD("normal");

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO publications (iduser, description, date, nameimg) VALUES (?, ?, ?, ?)");

        $date = date("Y-m-d H:i:s");

        $stmt->bind_param("ssss", $iduser, $description, $date, $uploadPath);

        if ($stmt->execute()) {
            echo json_encode(["success" => "Publicación creada correctamente"]);
        } else {
            echo json_encode(["error" => "Error al crear la publicación: " . $stmt->error]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["error" => "Error al subir la imagen"]);
    }
} else {
    echo json_encode(["error" => "Método de solicitud no permitido"]);
}

?>
