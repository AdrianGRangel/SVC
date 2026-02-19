<?php
/**
 * LÓGICA DE CAPTURA DE FILTROS
 */
$filtro_estado = $_POST['estado'] ?? 'todos';
$filtro_fecha = $_POST['fecha_busqueda'] ?? '';

/**
 * BASE DE DATOS ACTUALIZADA
 */
$reportes_db = [
    // 5 COMPLETADAS
    ["id" => "REP-1001", "descripcion" => "Revisión de baches en Av. Tecnológico", "fecha" => "2026-02-18", "estado" => "completado"],
    ["id" => "REP-1002", "descripcion" => "Autos mal estacionados en zona escolar V10", "fecha" => "2026-02-18", "estado" => "completado"],
    ["id" => "REP-1003", "descripcion" => "Revisión de infracción por exceso de velocidad", "fecha" => "2026-02-17", "estado" => "completado"],
    ["id" => "REP-1004", "descripcion" => "Otros: Limpieza de escombro en banqueta", "fecha" => "2026-02-16", "estado" => "completado"],
    ["id" => "REP-1005", "descripcion" => "Revisión de baches tras lluvia reciente", "fecha" => "2026-02-15", "estado" => "completado"],

    // 3 EN REVISIÓN (Ahora con color Amarillo)
    ["id" => "REP-2001", "descripcion" => "Revisión de infracción - Apelación de usuario", "fecha" => "2026-02-18", "estado" => "revision"],
    ["id" => "REP-2002", "descripcion" => "Autos mal estacionados obstruyendo cochera", "fecha" => "2026-02-17", "estado" => "revision"],
    ["id" => "REP-2003", "descripcion" => "Revisión de baches profundos en calle secundaria", "fecha" => "2026-02-16", "estado" => "revision"],

    // 3 CANCELADAS
    ["id" => "REP-3001", "descripcion" => "Otros: Reporte de luminaria fundida", "fecha" => "2026-02-18", "estado" => "cancelado"],
    ["id" => "REP-3002", "descripcion" => "Autos mal estacionados - Reporte duplicado", "fecha" => "2026-02-15", "estado" => "cancelado"],
    ["id" => "REP-3003", "descripcion" => "Revisión de infracción - Datos incorrectos", "fecha" => "2026-02-14", "estado" => "cancelado"]
];

/**
 * LÓGICA DE FILTRADO
 */
$reportes_filtrados = array_filter($reportes_db, function($r) use ($filtro_estado, $filtro_fecha) {
    $match_estado = ($filtro_estado === 'todos') || ($r['estado'] === $filtro_estado);
    $match_fecha = empty($filtro_fecha) || ($r['fecha'] === $filtro_fecha);
    return $match_estado && $match_fecha;
});

$total_reportes = count($reportes_filtrados);
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    :root { 
        --vinotinto: #800040; /* Color principal basado en tus documentos */
        --naranja: #FF6B00;
        --verde: #28a745;
        --amarillo: #FFC107; /* Nuevo color Amarillo para revisión */
        --amarillo-texto: #856404;
        --rojo: #dc3545;
    }   

    body { font-family: 'Segoe UI', sans-serif; padding: 30px; background-color: #fff; color: #333; }

    .header-historial h1 { font-size: 26px; margin-bottom: 5px; }
    .header-historial p { color: #666; font-size: 14px; margin-top: 0; }
    .header-historial b { color: var(--naranja); }

    .filtros-box {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        background: #fdfdfd;
    }

    .inputs-container { display: flex; gap: 20px; align-items: flex-end; }
    .input-group { display: flex; flex-direction: column; gap: 5px; }
    .input-group label { font-size: 11px; font-weight: 700; color: var(--vinotinto); text-transform: uppercase; }

    select, input[type="date"] { padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px; outline: none; }

    .tabla-container { border: 1px solid #e9ecef; border-radius: 12px; overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f8f9fa; padding: 15px; text-align: left; font-size: 13px; color: #888; border-bottom: 1px solid #eee; }
    
    tr { transition: background-color 0.15s ease; cursor: pointer; }
    tr:hover { background-color: #f9f9f9; }
    tr:active { background-color: #f2f2f2; }

    td { padding: 15px; font-size: 14px; border-bottom: 1px solid #f9f9f9; }

    .badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; }
    .badge-completado { background: #e8f5e9; color: var(--verde); }
    
    /* ESTADO EN REVISIÓN ACTUALIZADO A AMARILLO */
    .badge-revision { background: #fff3cd; color: var(--amarillo-texto); border: 1px solid #ffeeba; }
    
    .badge-cancelado { background: #f8d7da; color: var(--rojo); }
</style>

<div class="contenedor">
    <div class="header-historial">
        <h1>Historial de reportes</h1>
        <p>Tienes <b><?php echo $total_reportes; ?></b> reporte(s) registrado(s)</p>
    </div>

    <form method="POST">
        <div class="filtros-box">
            <div style="font-size: 14px; font-weight: 600; margin-bottom: 15px;"><i class="bi bi-funnel-fill"></i> Filtros de Reportes</div>
            <div class="inputs-container">
                <div class="input-group">
                    <label>Estado</label>
                    <select name="estado" onchange="this.form.submit()">
                        <option value="todos" <?php echo $filtro_estado == 'todos' ? 'selected' : ''; ?>>Todos</option>
                        <option value="completado" <?php echo $filtro_estado == 'completado' ? 'selected' : ''; ?>>Completado</option>
                        <option value="revision" <?php echo $filtro_estado == 'revision' ? 'selected' : ''; ?>>En Revisión</option>
                        <option value="cancelado" <?php echo $filtro_estado == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Fecha</label>
                    <input type="date" name="fecha_busqueda" value="<?php echo htmlspecialchars($filtro_fecha); ?>" onchange="validarFecha(this)">
                </div>
                <div style="margin-left: auto;">
                    <a href="" style="color: var(--naranja); font-size: 13px; text-decoration: none; font-weight: 600;">Limpiar</a>
                </div>
            </div>
        </div>
    </form>

    <div class="tabla-container">
        <?php if ($total_reportes > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID REPORTE</th>
                        <th>DESCRIPCIÓN</th>
                        <th>FECHA</th>
                        <th>ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($reportes_filtrados as $r): ?>
                        <tr>
                            <td style="font-weight: 700; color: var(--vinotinto);"><?php echo $r['id']; ?></td>
                            <td><?php echo $r['descripcion']; ?></td>
                            <td><i class="bi bi-calendar3"></i> <?php echo $r['fecha']; ?></td>
                            <td>
                                <span class="badge badge-<?php echo $r['estado']; ?>">
                                    <?php echo ($r['estado'] == 'revision') ? 'En Revisión' : $r['estado']; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="padding: 80px; text-align: center; color: #999;">No hay resultados.</div>
        <?php endif; ?>
    </div>
</div>

<script>
function validarFecha(input) {
    if (input.value === "") { input.form.submit(); return; }
    const anio = input.value.split("-")[0];
    if (anio.length === 4) { input.form.submit(); }
}
</script>