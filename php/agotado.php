<?php
require_once 'conexion.php';
$id = $_GET['id'];
$response = array();

$sql_update = "UPDATE productos SET disponibilidad = 0 WHERE id = '$id'";
if ($conn->query($sql_update) === TRUE) {
    $response['status'] = 'success';
    $response['message'] = "Producto agotado.";
} else {
    $response['status'] = 'error';
    $response['message'] = "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($response);