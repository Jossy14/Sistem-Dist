<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/Server01/Domain/Models/CategoryModel.php";
$message = @$_REQUEST['message'];
$category = @$_SESSION["category.find"];
if (isset($category)) {
    $category = unserialize($category);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
    <script type="text/javascript" src="../../js/validations.js"></script>
</head>
<body>
    <center>
        <a href="../../../Controllers/CategoryController.php?action=Listar">REGRESAR</a>
        <h1>Editar Categoría</h1>
        <hr>
        <form action="../../../Controllers/CategoryController.php?action=Actualizar" method="POST">
            <table>
                <tr>
                    <th style="text-align: right">Código:</th>
                    <td>
                        <input type="number" name="codigo" id="codigo" value="<?= $category != null ? @$category->getCodigo() : ""; ?>" required placeholder="Digite el código" readonly>
                    </td>
                </tr>
                <tr>
                    <th style="text-align: right">Nombre Categoría:</th>
                    <td><input type="text" name="nombre_categoria" id="nombre_categoria" value="<?= $category != null ? @$category->getNombre_categoria() : ""; ?>"></td>
                </tr>
                <tr>
                    <th style="text-align: right">Descripción:</th>
                    <td><input type="text" name="descripcion" id="descripcion" value="<?= $category != null ? @$category->getDescripcion() : ""; ?>"></td>
                </tr>
                <tr>
                    <th style="text-align: right">Fecha Creación:</th>
                    <td><input type="date" name="fecha_creacion" id="fecha_creacion" value="<?= $category != null ? @$category->getFecha_creacion() : ""; ?>"></td>
                </tr>
                <tr>
                    <th style="text-align: right">Estado:</th>
                    <td><input type="text" name="estado" id="estado" value="<?= $category != null ? @$category->getEstado() : ""; ?>"></td>
                </tr>
                
                    <tr>
                        <th style="text-align: right">Imagen:</th>
                        <td><input type="text" name="imagen" id="imagen" value="<?= $category != null ? @$category->getImagen() : ""; ?>" readonly></td>
                    </tr>
                <tr>
                    <th style="text-align: right">Orden:</th>
                    <td><input type="number" name="orden" id="orden" value="<?= $category != null ? @$category->getOrden() : ""; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center">
                        <input type="reset" value="Limpiar">
                        <input type="submit" id="action" name="action" value="Actualizar">
                    </td>
                </tr>
            </table>
        </form>
        <span style="color: red"><?= ($message != null || isset($message)) ? $message : ""; ?></span>
    </center>
</body>
</html>
