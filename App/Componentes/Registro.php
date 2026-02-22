<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cuenta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primario: #9b004b; --gris-borde: #dcdcdc; }
        body { font-family: 'Segoe UI', sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; padding: 20px; }
        
        .modal { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 450px; text-align: center; }
        
        .btn-google { width: 100%; padding: 10px; border: 1px solid var(--gris-borde); border-radius: 8px; background: white; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; font-weight: 500; }
        
        .separador { margin: 20px 0; color: #888; display: flex; align-items: center; }
        .separador::before, .separador::after { content: ""; flex: 1; border-bottom: 1px solid var(--gris-borde); margin: 0 10px; }

        .grid-inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .input-group { position: relative; margin-bottom: 15px; text-align: left; }
        .input-group i { position: absolute; left: 12px; top: 38px; color: #999; }
        .input-group label { font-size: 14px; font-weight: bold; color: #444; }
        
        input { width: 100%; padding: 10px 10px 10px 35px; border: 1px solid var(--gris-borde); border-radius: 8px; box-sizing: border-box; margin-top: 5px; }
        
        .btn-registro { width: 100%; padding: 12px; background: var(--primario); color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        
        .exito { color: green; margin-bottom: 15px; font-weight: bold; }
    </style>
</head>
<body>

<div class="modal">
    <h2>Crear cuenta</h2>
    <p>Completa tus datos para registrarte</p>

    <?php if($mensaje_exito): ?>
        <p class="exito"><?php echo $mensaje_exito; ?></p>
    <?php endif; ?>

    <button class="btn-google">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" width="18"> 
        Registrarse con Google
    </button>

    <div class="separador">o regístrate con email</div>

    <form method="POST">
        <div class="grid-inputs">
            <div class="input-group">
                <label>Nombre</label>
                <i class="fa fa-user"></i>
                <input type="text" name="nombre" placeholder="Juan" required>
            </div>
            <div class="input-group">
                <label>Apellidos</label>
                <i class="fa fa-user"></i>
                <input type="text" name="apellidos" placeholder="Pérez García">
            </div>
        </div>

        <div class="input-group">
            <label>Correo electrónico</label>
            <i class="fa fa-envelope"></i>
            <input type="email" name="email" placeholder="tu@email.com" required>
        </div>

        <div class="grid-inputs">
            <div class="input-group">
                <label>Contraseña</label>
                <i class="fa fa-lock"></i>
                <input type="password" name="pass" placeholder="••••••••" required>
            </div>
            <div class="input-group">
                <label>Confirmar</label>
                <i class="fa fa-lock"></i>
                <input type="password" name="confirm_pass" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn-registro">Crear cuenta</button>
    </form>
    
    <p style="font-size: 13px; margin-top: 20px;">
        ¿Ya tienes una cuenta? <a href="#" style="color: #ff4500; text-decoration: none; font-weight: bold;">Inicia sesión</a>
    </p>
</div>

</body>
</html>