<?php
    session_start();
    if (isset($_SESSION["users.all"])) {
        $_SESSION["users.all"] = null;
    }
    if (isset($_SESSION["user.find"])) {
        $_SESSION["user.find"] = null;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <center>
        <form action="../../../Controllers/UserController.php" method="post">
        <input type="hidden" name="action" value="LOGIN">
            <table>
                <tr>
                    <th colspan="2">Iniciar Sesión</th>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" required></td>
                </tr>
                <tr>
                    <td>Contraseña:</td>
                    <td><input type="password" name="password" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Login">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a> <input type="button" value="Registrarse" onclick="location.href='register.php'" ></a></td>
                </tr>
            </table>
        </form>
    </center>
</body>
</html>
