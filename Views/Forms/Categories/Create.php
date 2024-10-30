<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro De Categorias</title>
</head>
<body>
    <center>
        <a href="../Users/index.php">REGRESAR</a>
        <h1>Registro De Categorias</h1>
        <form action="../../../Controllers/CategoryController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="GUARDAR">
            <fieldset style="width: 30%;">
                <legend>Datos De La Categoria: </legend>
                <table border="1" style="width: 90%;">
                    <tr>
                        <th style="text-align: center">Codigo:</th>
                        <td><input type="number" name="codigo" id="codigo" required placeholder="Digitar el codigo" style="width: 98%;"></td>
                    </tr>
                    <tr>
                        <th style="text-align: center">Nombre Categoria:</th>
                        <td><input type="text" name="nombre_categoria" id="nombre_categoria" placeholder="Digita la categoria" style="width: 98%;"></td>
                    </tr>
                    <tr>
                        <th style="text-align: center">Descripcion:</th>
                        <td><input type="text" name="descripcion" id="descripcion" placeholder="Describa la categoria" style="width: 98%;"></td>
                    </tr>
                    <tr>
                        <th style="text-align: center">Fecha Creacion:</th>
                        <td><input type="date" name="fecha_creacion" id="fecha_creacion" placeholder="Digite la fecha" style="width: 98%;"></td>
                    </tr>
                    <tr>
                        <th style="text-align: center">estado:</th>
                        <td><input type="number" name="estado" id="estado" placeholder="Estado" style="width: 98%;"></td>
                    </tr>
                    <tr>
                        <th style="text-align: center">Imagen:</th>
                        <td><input type="file" name="imagen" id="imagen" placeholder="Colocar la imagen" style="width: 98%;"></td>
                    </tr>
                    <tr>
                        <th style="text-align: center">Orden:</th>
                        <td><input type="number" name="orden" id="orden" placeholder="Digita el orden" style="width: 98%;"></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td colspan="2" style="text-align: center">
                            <input type="reset" value="Limpiar">&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="submit" id="action" name="action" value="Guardar">
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
        <span style="color: red"><?php echo @$_REQUEST["message"]; ?></span>
    </center>
</body>
</html>