<?php
include('./utils/config.php');

// Crea una conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("La conexión a MySQL ha fallado: " . $conn->connect_error);
}

// Consulta SQL para obtener todos los favoritos
$sql = "SELECT * FROM favoritos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon favoritos</title>
    <link rel="icon" href="./assets/pokedex.png" type="image/png">

    <!-- Agrega enlaces a las hojas de estilo Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="display-4">Pokémon favoritos</h1>
        <?php
        // Verifica si se encontraron resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <h1 class='display-4'> <?php echo "{$row['nombre']}  {$row['numero']}" ?></h1>
                <div class="row justify-content-center" id="pokemon-container">

                    <div class="col-md-4"> <!-- Imagen a la izquierda -->
                        <div class="card border-0 text-center">
                            <img src="<?php echo $row['imagen']; ?>" class="card-img-top" alt="Pokemon">
                        </div>
                        <div class="text-center">
                            <form method="post" action="eliminar_pokemon.php">
                                <input type="hidden" name="pokemon_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>


                    </div>
                    <div class="col-md-8"> <!-- Texto a la derecha -->

                        <div class="card border-0">
                            <ul class="list-unstyled">
                                <li><strong>ID:</strong> <?php echo $row['id']; ?></li>
                                <li><strong>Tipo:</strong> <?php echo $row['tipo']; ?></li>
                                <li><strong>Categoría:</strong> <?php echo $row['categoria']; ?></li>
                                <li><strong>Habilidad:</strong> <?php echo $row['habilidad']; ?></li>
                                <li><strong>Debilidades:</strong> <?php echo $row['debilidad']; ?></li>
                                <li><strong>Altura:</strong> <?php echo $row['altura']; ?></li>
                                <li><strong>Peso:</strong> <?php echo $row['peso']; ?></li>
                                <li><strong>Sexo:</strong> <?php echo $row['sexo']; ?></li>
                            </ul>
                            <div class="card-text">
                                <strong>Descripción 1:</strong>
                                <p><?php echo $row['descripcion_version_x']; ?></p>
                                <strong>Descripción 2:</strong>
                                <p><?php echo $row['descripcion_version_y']; ?></p>
                            </div>
                            <div class="card-text">
                                <strong>Evoluciones:</strong> <?php echo $row['evoluciones']; ?>
                            </div>
                            <div class="card-text">
                                <strong>Puntos Base:</strong> <br>
                                <ul>
                                    <li><strong>PS:</strong> <?php echo $row['ps']; ?></li>
                                    <li><strong>Ataque:</strong> <?php echo $row['ataque']; ?></li>
                                    <li><strong>Defensa:</strong> <?php echo $row['defensa']; ?></li>
                                    <li><strong>Ataque especial:</strong> <?php echo $row['ataque_especial']; ?></li>
                                    <li><strong>Defensa especial:</strong> <?php echo $row['defensa_especial']; ?></li>
                                    <li><strong>Velocidad:</strong> <?php echo $row['velocidad']; ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "No se encontraron Pokémon favoritos en la base de datos.";
        }
        ?>
    </div>
    <div class="text-center"> <!-- Agrega la clase text-center aquí para centrar el botón -->
            <a class="btn btn-primary" href="index.php">Home</a>
    </div>
    <!-- Agrega el script de Bootstrap para funcionalidad adicional si es necesario -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
<?php
// Cierra la conexión a la base de datos
$conn->close();
?>