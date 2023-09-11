<?php
include('./utils/config.php');

// Verifica si se ha enviado un formulario para eliminar un Pokémon
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pokemon_id"])) {
    // Obtén el ID del Pokémon a eliminar
    $pokemon_id = $_POST["pokemon_id"];

    // Crea una conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $database);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon eliminado</title>
    <link rel="icon" href="./assets/pokedex.png" type="image/png">

    <!-- Agrega enlaces a las hojas de estilo Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <?php
        // Verifica la conexión
        if ($conn->connect_error) {
            die("La conexión a MySQL ha fallado: " . $conn->connect_error);
        }

        // Consulta SQL para eliminar el Pokémon por su ID
        $sql = "DELETE FROM favoritos WHERE id = $pokemon_id";

        if ($conn->query($sql) === TRUE) {
            ?>
            <div class="alert alert-success text-center" role="alert">
                <h1 class="display-4">El Pokémon ha sido eliminado</h1>
            </div>
            <div class="text-center"> <!-- Agrega la clase text-center aquí para centrar el botón -->
                <a class="btn btn-primary" href="favoritos.php">Regresar</a>
            </div>
        <?php
        } else {
            ?>
            <div class="alert alert-danger text-center" role="alert">
                <h1 class="display-4">Hubo un error al eliminar el Pokémon con </h1>
            </div>
            <div class="text-center"> <!-- Agrega la clase text-center aquí para centrar el botón -->
                <a class="btn btn-primary" href="favoritos.php">Regresar</a>
            </div>
        <?php
        }

        // Cierra la conexión a la base de datos
        $conn->close();
        }
        ?>
    </div>
</body>
</html>
