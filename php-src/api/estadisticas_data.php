<?php
// php-src/api/estadisticas_data.php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Compra-y-Gestion-de-Leche/php-src/includes/conexion.php';

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Sesión no válida']);
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tipo = $_GET['tipo'] ?? 'semanal';

header('Content-Type: application/json');

try {
    switch ($tipo) {
        case 'semanal':
            echo json_encode(getProduccionSemanal($conn, $usuario_id));
            break;
        case 'calidad':
            echo json_encode(getDistribucionCalidad($conn, $usuario_id));
            break;
        case 'mensual':
            echo json_encode(getTendenciaMensual($conn, $usuario_id));
            break;
        default:
            echo json_encode(['error' => 'Tipo de gráfica no válido']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();

// 1. Producción semanal (últimos 7 días)
function getProduccionSemanal($conn, $usuario_id) {
    $labels = [];
    $valores = [];
    
    // Obtener los últimos 7 días
    for ($i = 6; $i >= 0; $i--) {
        $fecha = date('Y-m-d', strtotime("-$i days"));
        $labels[] = date('d/m', strtotime($fecha));
        
        $sql = "SELECT COALESCE(SUM(litros), 0) as total 
                FROM entregas 
                WHERE id_usuario_productor = ? 
                AND DATE(fecha) = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $usuario_id, $fecha);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        $valores[] = (float)$row['total'];
        $stmt->close();
    }
    
    return [
        'labels' => $labels,
        'datasets' => [[
            'label' => 'Litros entregados',
            'data' => $valores,
            'backgroundColor' => 'rgba(52, 152, 219, 0.5)',
            'borderColor' => 'rgba(52, 152, 219, 1)',
            'borderWidth' => 2,
            'tension' => 0.3,
            'fill' => true
        ]]
    ];
}

// 2. Distribución de calidad
function getDistribucionCalidad($conn, $usuario_id) {
    $calidades = ['Excelente', 'Buena', 'Regular', 'Deficiente'];
    $colores = [
        'rgba(46, 204, 113, 0.7)',  // Verde
        'rgba(52, 152, 219, 0.7)',   // Azul
        'rgba(241, 196, 15, 0.7)',   // Amarillo
        'rgba(231, 76, 60, 0.7)'     // Rojo
    ];
    
    $labels = [];
    $valores = [];
    $coloresFinal = [];
    
    foreach ($calidades as $index => $calidad) {
        $sql = "SELECT COUNT(*) as cantidad 
                FROM entregas 
                WHERE id_usuario_productor = ? 
                AND calidad = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $usuario_id, $calidad);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        $cantidad = (int)$row['cantidad'];
        
        if ($cantidad > 0) {
            $labels[] = $calidad;
            $valores[] = $cantidad;
            $coloresFinal[] = $colores[$index];
        }
        
        $stmt->close();
    }
    
    // Si no hay datos, mostrar mensaje
    if (empty($valores)) {
        $labels = ['Sin datos'];
        $valores = [1];
        $coloresFinal = ['rgba(149, 165, 166, 0.7)'];
    }
    
    return [
        'labels' => $labels,
        'datasets' => [[
            'label' => 'Entregas por calidad',
            'data' => $valores,
            'backgroundColor' => $coloresFinal,
            'borderColor' => array_map(function($color) {
                return str_replace('0.7', '1', $color);
            }, $coloresFinal),
            'borderWidth' => 1
        ]]
    ];
}

// 3. Tendencia mensual (últimos 6 meses)
function getTendenciaMensual($conn, $usuario_id) {
    $labels = [];
    $valores = [];
    
    // Obtener los últimos 6 meses
    for ($i = 5; $i >= 0; $i--) {
        $mes = date('n', strtotime("-$i months"));
        $anio = date('Y', strtotime("-$i months"));
        
        $labels[] = date('M Y', strtotime("-$i months"));
        
        $sql = "SELECT COALESCE(SUM(litros), 0) as total 
                FROM entregas 
                WHERE id_usuario_productor = ? 
                AND YEAR(fecha) = ? 
                AND MONTH(fecha) = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $usuario_id, $anio, $mes);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        $valores[] = (float)$row['total'];
        $stmt->close();
    }
    
    return [
        'labels' => $labels,
        'datasets' => [[
            'label' => 'Litros mensuales',
            'data' => $valores,
            'backgroundColor' => 'rgba(155, 89, 182, 0.5)',
            'borderColor' => 'rgba(155, 89, 182, 1)',
            'borderWidth' => 2
        ]]
    ];
}
?>