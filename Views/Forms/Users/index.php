<?php
session_start();

if (isset($_SESSION["users.all"])) {
    $_SESSION["users.all"] = null;
}
if (isset($_SESSION["user.find"])) {
    $_SESSION["user.find"] = null;
}

// Validar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Redirige a la página de login
    exit; // Salir del script para evitar que el contenido se cargue
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión De Categoría</title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        .logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <div class="logout-btn">
        <a href="logout.php"><button>Cerrar Sesión</button></a>
    </div>
    <center>
        <table>
            <tr>
                <th>Gestión De Categorías</th>
            </tr>
            <tr>
                <th><a href="../Categories/Create.php">Crear Categoría</a></th>
            </tr>
            <tr>
                <th><a href="../Categories/Search.php">Buscar Categoría</a></th>
            </tr>
            <tr>
                <th><a href="../../../Controllers/CategoryController.php?action=Listar">Listar Categoría</a></th>
            </tr>
        </table>
    </center>
</body>
</html>
