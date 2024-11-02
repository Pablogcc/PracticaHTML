<?php


// Parámetros de conexión
$host = 'localhost';
$port = 9999;
$usuario = 'root';
$password = 'dada';
$dbname = 'colegio';

try {
    // Crear la conexión PDO
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";
    $conn = new PDO($dsn, $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si se recibe el parámetro "id" en la URL
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id']; // Convertir a entero para mayor seguridad

        // Preparar la consulta para obtener el alumno por su ID
        $stmt = $conn->prepare("SELECT * FROM alumno WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el resultado
        $alumno = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($alumno) {
            // Si se encontró el alumno, devolverlo en formato JSON
            $response = json_encode([
                'status' => 'success',
                'data' => $alumno
            ]);
        } else {
            // Si no se encontró el alumno, devolver un mensaje de error
            $response = json_encode([
                'status' => 'error',
                'message' => 'Alumno no encontrado'
            ]);
        }
    } else {
        // Si no se recibe el parámetro "id", devolver todos los alumnos
        $stmt = $conn->prepare("SELECT * FROM alumno");
        $stmt->execute();
        
        // Obtener todos los alumnos
        $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($alumnos) {
            // Si se encontraron alumnos, devolver la lista en formato JSON
            $response = json_encode([
                'status' => 'success',
                'data' => $alumnos
            ]);
        } else {
            // Si no se encontraron alumnos, devolver un mensaje de error
            $response = json_encode([
                'status' => 'error',
                'message' => 'No se encontraron alumnos'
            ]);
        }
    }

} catch (PDOException $e) {
    // Manejar errores de conexión o consulta
    $response = json_encode([
        'status' => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
} finally {
    // Cerrar la conexión (PDO lo hace automáticamente al final del script)
    $conn = null;
}

// Imprimir la respuesta como string JSON
echo $response;
