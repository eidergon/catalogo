<?php
include 'conexion.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $referencia = $_POST['referencia'];
    $ram = $_POST['ram'];
    $sistema = $_POST['sistema'];
    $memoria = $_POST['memoria'];
    $procesador = $_POST['procesador'];
    $bateria = $_POST['bateria'];
    $camara = $_POST['camara'];
    $tarjeta = $_POST['tarjeta'];
    $resolucion = $_POST['resolucion'];
    $peso = $_POST['peso'];
    $pantalla = $_POST['pantalla'];
    $disponibilidad = 1;

    if ($categoria == "Telefono") {
        $sql = "INSERT INTO Productos (Nombre, Categoria, Marca, Referencia, Sistema, Memoria, Procesador, Camara, Ram, Bateria, Disponibilidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", $nombre, $categoria, $marca, $referencia, $sistema, $memoria, $procesador, $camara, $ram, $bateria, $disponibilidad);
    } elseif ($categoria == "Televisor") {
        $sql = "INSERT INTO Productos (Nombre, Categoria, Marca, Referencia, Resolucion, Pantalla, Peso, Disponibilidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $nombre, $categoria, $marca, $referencia, $sistema, $resolucion, $pantalla, $peso, $disponibilidad);
    } elseif ($categoria == "Computador") {
        $sql = "INSERT INTO Productos (Nombre, Categoria, Marca, Referencia, Sistema, Memoria, Ram, Procesador, Tarjeta_video, Disponibilidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $nombre, $categoria, $marca, $referencia, $sistema, $memoria, $ram, $procesador, $tarjeta, $disponibilidad);
    }

    if ($stmt->execute()) {
        $producto_id = $conn->insert_id;

        for ($i = 0; $i < count($_FILES['imagen']['name']); $i++) {
            $nombreArchivo = $_FILES['imagen']['name'][$i];
            $tipoArchivo = $_FILES['imagen']['type'][$i];
            $datosArchivo = file_get_contents($_FILES['imagen']['tmp_name'][$i]);

            $sql_imagen = "INSERT INTO Imagenes (Producto_ID, NombreArchivo, TipoArchivo, Imagen) VALUES (?, ?, ?, ?)";
            $stmt_imagen = $conn->prepare($sql_imagen);
            $stmt_imagen->bind_param("isss", $producto_id, $nombreArchivo, $tipoArchivo, $datosArchivo);
            if ($stmt_imagen->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Imagen guardada correctamente.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error al guardar la imagen: ' . $stmt_imagen->error;
            }
            
        }
            $response['status'] = 'success';
            $response['message'] = 'Producto Agregado al Catalogo.';

    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error al subir el producto: ' . mysqli_error($conn);
    }

    $conn->close();
} else {
    $response['status'] = 'error';
    $response['message'] = "Método de solicitud no válido";
}
header('Content-Type: application/json');
echo json_encode($response);