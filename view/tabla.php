<?php
require_once '../php/conexion.php';

$resultados_por_pagina = 5;

$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

$inicio_limit = ($pagina - 1) * $resultados_por_pagina;

$sql = "SELECT * FROM productos LIMIT $inicio_limit, $resultados_por_pagina";
$result = $conn->query($sql);

?>

<?php if ($result->num_rows > 0) : ?>
    <table class='table'>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Marca</th>
                <th>Referencia</th>
                <th>Agotado</th>
                <th>Disponible</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr scope='row'>
                    <td class="td"><?php echo $row["Nombre"]; ?></td>
                    <td><?php echo $row["Categoria"]; ?></td>
                    <td><?php echo $row["Marca"]; ?></td>
                    <td><?php echo $row["Referencia"]; ?></td>
                    <td><button class="btn agotado" data-id='<?= $row['ID'] ?>'>Agotado <i class="fa-solid fa-lock"></i></button></td>
                    <td><button class="btn disponible" data-id='<?= $row['ID'] ?>'>Disponible <i class="fa-solid fa-lock-open"></i></button></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="pagination-container">
        <?php
        // Consulta SQL para contar el total de registros
        $sql = "SELECT COUNT(*) as total FROM productos";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_resultados = $row['total'];

        $total_paginas = ceil($total_resultados / $resultados_por_pagina);

        for ($i = 1; $i <= $total_paginas; $i++) {
            echo "<button class='btn btn-pagination' data-pagina='$i'>$i</button>";
        }
        ?>
    </div>
<?php else : ?>
    <table class='table'>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Marca</th>
                <th>Referencia</th>
                <th>Agotado</th>
                <th>Disponible</th>
            </tr>
        </thead>
        <tbody>
            <tr scope='row'>
                <td colspan='6' class='no-data'>Sin Datos</td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>