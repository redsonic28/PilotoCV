<?php
// --- Conexión a la BD ---
$conn = new mysqli("localhost", "root", "", "reconocimiento_facial");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];

    $directorio = "imagenes/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
        $extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
        $nombreArchivo = "user_" . time() . "." . $extension;
        $rutaDestino = $directorio . $nombreArchivo;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino)) {
            $sql = "INSERT INTO usuarios (nombre, cedula, imagen_ref) VALUES ('$nombre', '$cedula', '$rutaDestino')";
            if ($conn->query($sql) === TRUE) {
                $mensaje = "✅ Usuario registrado correctamente.";
            } else {
                $mensaje = "❌ Error al guardar en la BD: " . $conn->error;
            }
        } else {
            $mensaje = "❌ Error al mover el archivo.";
        }
    } else {
        $mensaje = "⚠️ Debe subir una foto válida.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-lg p-4 rounded-4 mx-auto" style="max-width: 420px;"> <!-- Más angosto -->
    <h2 class="text-center text-primary">Registro de Usuario</h2>

    <?php if (isset($mensaje)): ?>
      <div class="alert alert-info text-center mt-3">
        <?php echo $mensaje; ?>
      </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="mt-3">
      <div class="mb-3">
        <label class="form-label">Nombre:</label>
        <input type="text" name="nombre" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Cédula:</label>
        <input type="text" name="cedula" maxlength="10" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Foto de referencia:</label>
        <input type="file" name="foto" accept="image/*" class="form-control" required>
      </div>

      <!-- Botón más pequeño y centrado -->
      <div class="text-center">
        <button type="submit" class="btn btn-success btn-sm px-4">Registrar</button>
      </div>
    </form>

    <!-- Cámara -->
    <div class="text-center mt-4">
      <button id="abrirCamara" class="btn btn-outline-primary btn-sm px-4">Abrir Cámara</button>
      <div class="mt-3">
        <video id="video" width="320" height="240" autoplay muted class="border rounded"></video>
      </div>
    </div>
  </div>
</div>

<script>
  const video = document.getElementById('video');
  const abrirCamaraBtn = document.getElementById('abrirCamara');

  abrirCamaraBtn.addEventListener('click', () => {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(stream => {
        video.srcObject = stream;
      })
      .catch(err => {
        alert("Error al acceder a la cámara: " + err);
      });
  });
</script>

</body>
</html>
