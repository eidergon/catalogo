<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de control</title>
    <link rel="shortcut icon" href="../img/shopify.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/control.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <header class="header">
        <button class="btn index" data-page="index"><a href="../">Catalogo</a></button>

        <i class="fa-solid fa-bars" id="menu-icon"></i>

        <nav class="navbar">
            <ul class="links">
                <li class="nav-link pages2" data-page="tabla">Tabla de productos</li>
                <li class="nav-link pages2" data-page="agregar">Agregar</li>
            </ul>
        </nav>

        <a href="../php/cerrar.php"><i class="fa-solid fa-right-to-bracket"></i></a>
    </header>
    <main class="main" id="main"></main>

    <script src="../js/script.js"></script>
</body>

</html>