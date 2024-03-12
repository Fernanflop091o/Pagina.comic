<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["comic"])) {
    $targetDirectory = "uploads/"; // Directorio donde se guardarán los cómics
    $targetFile = $targetDirectory . basename($_FILES["comic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen real o un archivo fake
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["comic"]["tmp_name"]);
        if($check !== false) {
            echo "El archivo es una imagen - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "El archivo no es una imagen.";
            $uploadOk = 0;
        }
    }

    // Verificar si el archivo ya existe
    if (file_exists($targetFile)) {
        echo "Lo siento, el archivo ya existe.";
        $uploadOk = 0;
    }

    // Limitar el tamaño del archivo
    if ($_FILES["comic"]["size"] > 5000000) { // 5MB
        echo "Lo siento, el archivo es muy grande.";
        $uploadOk = 0;
    }

    // Permitir ciertos formatos de archivo
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "pdf" ) {
        echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y PDF.";
        $uploadOk = 0;
    }

    // Verificar si $uploadOk está establecido en 0 por un error
    if ($uploadOk == 0) {
        echo "Lo siento, tu archivo no fue subido.";

    // Si todo está bien, intenta subir el archivo
    } else {
        if (move_uploaded_file($_FILES["comic"]["tmp_name"], $targetFile)) {
            echo "El archivo ". htmlspecialchars( basename( $_FILES["comic"]["name"])). " ha sido subido.";
        } else {
            echo "Lo siento, hubo un error al subir tu archivo.";
        }
    }
}
?>