<?php
include_once '../php/conexion.php';
session_start();

$id = $_GET['id'];
$sql = "SELECT p.*, i.Imagen AS ImagenBinaria FROM productos p LEFT JOIN imagenes i ON p.ID = i.Producto_ID WHERE p.ID = '$id'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$categoria = $row["Categoria"];
$marca = $row["Marca"];
?>

<?php if ($result->num_rows > 0) : ?>
    <div class="container">
        <div class="imagen">
            <img id="imagenPrincipal" src="data:image/jpeg;base64,<?= base64_encode($row["ImagenBinaria"]) ?>" alt="<?= $row["Nombre"] ?>">
        </div>

        <div class="caracteristicas">
            <?php if ($row["Categoria"] == 'Computador') : ?>
                <div class="info">
                    <input type="hidden" id="referencia" value="<?= $row["Nombre"] ?>">
                    <p class="card-title"><?= $row["Nombre"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-laptop"></i> Marca: <?= $row["Marca"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-code"></i> Sistema: <?= $row["Sistema"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-microchip"></i> Memoria: <?= $row["Memoria"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-microchip"></i> Ram: <?= $row["Ram"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-microchip"></i> Procesador: <?= $row["Procesador"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-microchip"></i> Tarjta de video: <?= $row["Tarjeta_video"] ?></p>
                </div>
            <?php elseif ($row["Categoria"] == 'Telefono') : ?>
                <div class="info">
                    <input type="hidden" id="referencia" value="<?= $row["Nombre"] ?>">
                    <p class="card-title"><?= $row["Nombre"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-mobile"></i> Marca: <?= $row["Marca"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-code"></i> Sistema: <?= $row["Sistema"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-microchip"></i> Memoria: <?= $row["Memoria"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-microchip"></i> Procesador: <?= $row["Procesador"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-camera"></i></i> Camara: <?= $row["Camara"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-microchip"></i> Ram: <?= $row["Ram"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-battery-full"></i> Bateria: <?= $row["Bateria"] ?></p>
                </div>
            <?php elseif ($row["Categoria"] == 'Televisor') : ?>
                <div class="info">
                    <input type="hidden" id="referencia" value="<?= $row["Nombre"] ?>">
                    <p class="card-title"><?= $row["Nombre"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-tv"></i> Marca: <?= $row["Marca"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-tv"></i> Resolucion: <?= $row["Resolucion"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-tv"></i> Pantalla: <?= $row["Pantalla"] ?></p>
                    <p class="card-des"><i class="fa-solid fa-tv"></i> Peso: <?= $row["Peso"] ?></p>
                </div>
            <?php endif; ?>
            <!-- botones -->
            <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) : ?>
                <button type="button" id="contacto" class="btn"><a href="#">Contactar</a></button>
            <?php else : ?>
                <button type="button" id="enviar" class="btn"><a href="#">Enviar</a></button>
            <?php endif; ?>
        </div>

        <div class="imagenes">
            <?php $sql_imagenes = "SELECT Imagen FROM imagenes WHERE Producto_ID = '$id'"; ?>
            <?php $result_imagenes = mysqli_query($conn, $sql_imagenes); ?>
            <?php while ($row_imagenes = $result_imagenes->fetch_assoc()) : ?>
                <img class="imagen-producto" src="data:image/jpeg;base64,<?= base64_encode($row_imagenes["Imagen"]) ?>" alt="Imagen de producto">
            <?php endwhile; ?>
        </div>

        <div class="sugerencias">
            <?php if ($categoria == "Telefono") : ?>
                <?php $sql_sugerencias = "SELECT p.*, MAX(i.Imagen) AS ImagenBinaria FROM productos p LEFT JOIN imagenes i ON p.ID = i.Producto_ID WHERE p.Categoria = '$categoria' AND p.Marca = '$marca' AND p.ID != '$id' GROUP BY p.ID ORDER BY RAND() LIMIT 4";  ?>
                <?php $result_sugerencias = mysqli_query($conn, $sql_sugerencias); ?>
            <?php else : ?>
                <?php $sql_sugerencias = "SELECT p.*, MAX(i.Imagen) AS ImagenBinaria FROM productos p LEFT JOIN imagenes i ON p.ID = i.Producto_ID WHERE p.Categoria = '$categoria' AND p.ID != '$id' GROUP BY p.ID ORDER BY RAND() LIMIT 4";  ?>
                <?php $result_sugerencias = mysqli_query($conn, $sql_sugerencias); ?>
            <?php endif; ?>

            <h1>Productos Similares</h1>
            <div class="productos-sugerencias">
                <?php if ($result_sugerencias->num_rows > 0) : ?>
                    <?php while ($row_sugerencia = $result_sugerencias->fetch_assoc()) : ?>
                        <div class="card" data-form="producto" data-id="<?= $row_sugerencia["ID"] ?>">
                            <div class="card-image-container">
                                <?php if ($row_sugerencia["ImagenBinaria"] !== null) : ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($row_sugerencia["ImagenBinaria"]) ?>" alt="<?= $row_sugerencia["Nombre"] ?>">
                                <?php else : ?>
                                    <img src="img/no_img.png" alt="">
                                <?php endif; ?>
                            </div>
                            <p class="card-title"><?= $row_sugerencia["Nombre"] ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="card2">
                        <div class="card-image-container">
                            <img src="img/no_img.png" alt="">
                        </div>
                        <p class="card-title">No hay productos sugeridos disponibles.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php else : ?>
<?php endif; ?>