<?php
include_once '../php/conexion.php';

$sql = "SELECT p.*, MAX(i.Imagen) AS ImagenBinaria FROM productos p LEFT JOIN imagenes i ON p.ID = i.Producto_ID WHERE p.Disponibilidad != 0 AND p.Categoria = 'Televisor' GROUP BY p.ID ORDER BY RAND()";

$result = mysqli_query($conn, $sql);
?>

<?php if ($result->num_rows > 0) : ?>
    <?php while ($row = $result->fetch_assoc()) : ?>
        <div class="card" data-form="producto" data-id="<?= $row["ID"] ?>">
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
