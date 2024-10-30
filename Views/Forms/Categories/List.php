<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/Server01/Domain/Models/CategoryModel.php";
$message = @$_REQUEST['message'];
$categories = @$_SESSION["categories.all"];
if (isset($categories)) {
    $categories = unserialize($categories);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PHP</title>
    <link rel="stylesheet" href="../../css/style.css">
    <script type="text/javascript" src="../../js/validations.js"></script>
</head>
<body>
    <center>
        <a href="../Users/index.php">REGRESAR</a>
        <h1>Lista De Categorías</h1>
        <?php if ($categories == null || count($categories) <= 0) { ?>
            <span style="color: #900D40; background-color: #FAD7CE;">NO EXISTEN CATEGORÍAS REGISTRADAS</span><br>
        <?php } else { ?>
            <fieldset style="width: 90%;">
                <legend>Información De Las Categorías:</legend>
                <table style="width: 100%;">
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Imagen</th>
                        <th>Orden</th>
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($categories as $i => $category) { ?>
                        <tr style="text-align: left;">
                            <th><?php echo ($i + 1); ?></th>
                            <td><?php echo $category->getCodigo(); ?></td>
                            <td><?php echo $category->getNombre_categoria(); ?></td>
                            <td><?php echo $category->getDescripcion(); ?></td>
                            <td><?php echo $category->getFecha_creacion(); ?></td>
                            <td><?php echo $category->getEstado(); ?></td>
                            <td><img src="<?php echo $category->getImagen(); ?>" alt="Imagen" style="max-width: 100px;"></td>
                            <td><?php echo $category->getOrden(); ?></td>
                            <td style="text-align: center">
                                <a href="../../../Controllers/CategoryController.php?action=Edit&codigo=<?= $category->getCodigo(); ?>">Editar</a><br><br>
                                <a onclick="ConfirmAction(event)" href="../../../Controllers/CategoryController.php?action=DELETE&codigo=<?= $category->getCodigo(); ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </fieldset>
        <?php } ?>
        <span style="color: red"><?php echo ($message != null || isset($message)) ? $message : ""; ?></span>
    </center>
</body>
</html>
