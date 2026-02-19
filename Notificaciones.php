<?php
/**
 * LÓGICA DE CAPTURA DE FILTROS
 */
$filtro_estado = $_POST['estado'] ?? 'todas';
$filtro_fecha = $_POST['fecha_inicio'] ?? '';

/**
 * DATOS DE EJEMPLO
 */
$notificaciones_db = [
    ["id" => 1, "titulo" => "Saldo de Créditos", "mensaje" => "Actualmente cuentas con 15 créditos disponibles.", "fecha" => "2026-02-18", "leido" => false, "tipo" => "credito", "icono" => "bi-cash-coin"],
    ["id" => 2, "titulo" => "¡Crédito Asignado!", "mensaje" => "Has recibido 1 crédito nuevo.", "fecha" => "2026-02-18", "leido" => false, "tipo" => "sistema", "icono" => "bi-plus-circle-fill"],
    ["id" => 3, "titulo" => "Reporte Revisado", "mensaje" => "Tu reporte sobre soporte ha sido finalizado.", "fecha" => "2026-02-17", "leido" => true, "tipo" => "sistema", "icono" => "bi-check-circle-fill"]
];

$notificaciones_filtradas = array_filter($notificaciones_db, function($noti) use ($filtro_estado, $filtro_fecha) {
    $cumple_estado = ($filtro_estado === 'todas') || ($filtro_estado === 'leidas' && $noti['leido']) || ($filtro_estado === 'no-leidas' && !$noti['leido']);
    $cumple_fecha = empty($filtro_fecha) || ($noti['fecha'] === $filtro_fecha);
    return $cumple_estado && $cumple_fecha;
});
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root { 
        --vinotinto: #800040; 
        --naranja: #FF6B00;    
        --verde: #28a745; 
    }
    .contenedor-central { padding: 30px; background: white; font-family: 'Segoe UI', sans-serif; }
    
    .filtros-bar { 
        display: flex; gap: 20px; margin-bottom: 25px; background: #fdfdfd; 
        padding: 20px; border-radius: 12px; border: 1px solid #eee; align-items: center;
    }

    .noti-card { 
        display: flex; 
        align-items: center; 
        padding: 15px 25px; 
        margin-bottom: 12px; 
        border-radius: 10px; 
        border-left: 6px solid #ccc; 
        box-shadow: 0 3px 6px rgba(0,0,0,0.03);
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }

    .noti-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .noti-card:active {
        transform: scale(0.97);
        background-color: #f0f0f0;
    }

    .unread { border-left-color: var(--naranja); background: #fffaf5; }
    .tipo-credito { border-left-color: var(--verde); background: #f8fff9; }
    
    .is-reading {
        border-left-color: #ccc !important;
        background-color: #ffffff !important;
        opacity: 0.8;
    }

    .noti-icon { 
        width: 45px; height: 45px; border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; 
        margin-right: 20px; background: #eee; color: var(--vinotinto);
        flex-shrink: 0;
    }

    .noti-body { flex-grow: 1; }
    .noti-titulo { font-weight: bold; margin: 0; font-size: 16px; color: #333; }
    .noti-mensaje { margin: 2px 0 0; font-size: 14px; color: #666; }

    .noti-fecha-container {
        text-align: right;
        margin-left: 20px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .noti-fecha-texto { font-size: 12px; color: #999; }
</style>

<div class="contenedor-central">
    <h2 style="color: var(--vinotinto);">Notificaciones</h2>

    <form id="formFiltros" method="POST" action="">
        <div class="filtros-bar">
            <div style="display:flex; align-items:center; gap:10px;">
                <label>Estado:</label>
                <select name="estado" onchange="this.form.submit()">
                    <option value="todas" <?php echo $filtro_estado == 'todas' ? 'selected' : ''; ?>>Todas</option>
                    <option value="no-leidas" <?php echo $filtro_estado == 'no-leidas' ? 'selected' : ''; ?>>No leídas</option>
                    <option value="leidas" <?php echo $filtro_estado == 'leidas' ? 'selected' : ''; ?>>Leídas</option>
                </select>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <label>Fecha:</label>
                <input type="date" 
                       name="fecha_inicio" 
                       id="fecha_input"
                       value="<?php echo htmlspecialchars($filtro_fecha); ?>" 
                       onchange="validarYEnviar(this)">
            </div>
            <a href="" style="color: var(--naranja); font-size: 13px; text-decoration: none; font-weight: bold;">Limpiar</a>
        </div>
    </form>

    <div class="lista">
        <?php foreach($notificaciones_filtradas as $noti): ?>
            <div class="noti-card <?php echo ($noti['tipo'] == 'credito' ? 'tipo-credito' : ($noti['leido'] ? '' : 'unread')); ?>" 
                 onclick="marcarLeida(this)">
                
                <div class="noti-icon">
                    <i class="bi <?php echo $noti['icono']; ?>"></i>
                </div>

                <div class="noti-body">
                    <p class="noti-titulo"><?php echo $noti['titulo']; ?></p>
                    <p class="noti-mensaje"><?php echo $noti['mensaje']; ?></p>
                </div>

                <div class="noti-fecha-container">
                    <span class="noti-fecha-texto">
                        <i class="bi bi-calendar3"></i> <?php echo $noti['fecha']; ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
/**
 * SOLUCIÓN AL PROBLEMA DE ESCRITURA:
 * Esta función detecta si la fecha está incompleta antes de enviar.
 */
function validarYEnviar(input) {
    // Si el usuario borra la fecha, enviamos para limpiar filtro
    if (input.value === "") {
        input.form.submit();
        return;
    }
    
    // Solo enviamos si el año tiene 4 dígitos (evita envíos parciales al escribir)
    const year = new Date(input.value).getFullYear();
    if (year > 1000) {
        input.form.submit();
    }
}

function marcarLeida(elemento) {
    elemento.classList.add('is-reading');
    console.log("Notificación marcada como leída visualmente.");
}
</script>