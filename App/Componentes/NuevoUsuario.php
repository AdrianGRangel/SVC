<?php
// Configuración temporal
$simular_db = true; // Cambia a false cuando conecte la DB real o no
$mensaje_exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $confirm_pass = $_POST['confirm_pass'];

    // Simulacion de validacion
    if ($pass !== $confirm_pass) {
        echo "<script>alert('Las contraseñas no coinciden');</script>";
    } else {
        if ($simular_db) {
            // Aqui agregar el inserto a la base de datos
            $mensaje_exito = "¡Usuario $nombre registrado correctamente (Modo Demo)!";
        }
    }
}
?>