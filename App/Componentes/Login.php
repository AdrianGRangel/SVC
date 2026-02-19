<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <title>Login - Bienvenido</title>
    </head>
    <body>
        <div class="login-card">
            <p class="subtitle">Inicia sesión en tu cuenta</p>
            <button class="google-btn">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google"">
                Continuar con Google
            </button>

            <div class="separator">
                <span>o continue con correo</span>
            </div>
            <form action="Login.php" method="POST">
                <div class="input-group">
                    <label>Correo Electronico</label>
                    <input type="email" name="email" placeholder="tu_correo@ues.com" required>
                </div>
                <div class="input-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="*******" required>
                    <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                </div>
                <button type="submit" name="ingresar" class="main-btn"Iniciar sesión></button> 
            </form>
            <p class="footer-text">¿No tienes cuenta? <a href="#">Registrate</p>
            <?php if(isset($_POST['ingresar'])){
                $email = $_POST['email'];
                $pw = $_POST['password'];
                echo "<p style='color:green; text-align:center;'>Intentando conectar con: $email</p>";
            }
            ?>
        </div>
    </body>
</html>