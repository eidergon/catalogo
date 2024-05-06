<?php
include_once 'php/conexion.php';
session_start();

$sql = "SELECT p.*,MIN(i.Imagen) AS ImagenBinaria FROM productos p LEFT JOIN imagenes i ON p.ID = i.Producto_ID WHERE p.Disponibilidad != 0 GROUP BY p.ID ORDER BY RAND()";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">
    <title>Catalogo</title>
    <link rel="shortcut icon" href="img/shopify.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <a href="" class="logo">Catalogo <span>Virtual</span></a>

        <i class="fa-solid fa-bars" id="menu-icon"></i>

        <nav class="navbar">
            <ul class="links">
                <li class="menu">
                    <a id="telefonos" href="#">Telefonos <i class="fa-solid fa-mobile-screen"></i></a>
                    <ul class="sub-menu" id="sub-menu">
                        <li data-page="telefonos" class="pages">Todos</li>
                        <li data-page="telefonos" data-tel="xiaomi" class="pages">Xiaomi</li>
                        <li data-page="telefonos" data-tel="iphone" class="pages">Apple Iphone</li>
                        <li data-page="telefonos" data-tel="honor" class="pages">Honor</li>
                        <li data-page="telefonos" data-tel="motorrola" class="pages">Motorrola</li>
                        <li data-page="telefonos" data-tel="oppo" class="pages">Oppo</li>
                        <li data-page="telefonos" data-tel="samsung" class="pages">Samsung</li>
                        <li data-page="telefonos" data-tel="tecno" class="pages">Tecno</li>
                        <li data-page="telefonos" data-tel="vivo" class="pages">Vivo</li>
                    </ul>
                </li>
                <li><a href="#" class="pages" data-page="computadores">Computadores <i class="fa-solid fa-laptop"></i></a></li>
                <li><a href="#" class="pages" data-page="televisores">Televisores <i class="fa-solid fa-tv"></i></a></li>
            </ul>
        </nav>
    </header>

    <main class="main" id="main">
        <?php if ($result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="card" data-id="<?= $row["ID"] ?>">
                    <div class="card-image-container">
                        <?php if ($row["ImagenBinaria"] !== null) : ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($row["ImagenBinaria"]) ?>" alt="<?= $row["Nombre"] ?>">
                        <?php else : ?>
                            <img src="img/no_img.png" alt="">
                        <?php endif; ?>
                    </div>
                    <p class="card-title"><?= $row["Nombre"] ?></p>
                </div>

            <?php endwhile; ?>
        <?php else : ?>
            <div class="card">
                <div class="card-image-container">
                    <img src="img/no_img.png" alt="">
                </div>
                <p class="card-title">No Hay Productos.</p>
            </div>
        <?php endif; ?>
    </main>
    <a id="wpp" href="#" class="wpp"><i class="fab fa-whatsapp"></i></a>
    <script src="js/script.js"></script>
</body>

</html>