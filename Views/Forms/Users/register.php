<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <center>
    <form action="../../../Controllers/UserController.php" method="post">
    <input type="hidden" name="action" value="GUARDAR"> <!-- Asegura que el valor 'GUARDAR' sea enviado -->
    <table>
        <tr>
            <th colspan="2">Registro</th>
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
            <td colspan="2"><input type="submit" value="Registrar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a> <input type="button" value="Login" onclick="location.href='login.php'" ></a></td>
        </tr>
    </table>
</form>

    </center>
</body>
</html>
