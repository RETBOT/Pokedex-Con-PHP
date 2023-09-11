<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pokemon Agregado</title>
    <link rel="icon" href="./assets/pokedex.png" type="image/png">

    <!-- Incluye Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <?php
        include('./utils/config.php');

        if (isset($_POST['pokemonID'])) {
            $pokemonID = $_POST['pokemonID'];
        } else {
            // Si no se especificó un 'pokemonID' en el POST, puedes manejar este caso como lo desees
            die('No se especificó un Pokémon.');
        }

        $url = "https://pokedex-api-server.onrender.com/api/v1/pokedex/id/$pokemonID";

        // Inicializa cURL
        $ch = curl_init($url);

        // Configura las opciones de la petición
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta en lugar de imprimirla
        // Puedes agregar más opciones aquí según las necesidades de tu API, como headers, métodos, etc.

        // Realiza la petición y guarda la respuesta en una variable
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            http_response_code(404);
            echo '<div class="d-flex justify-content-center align-items-center">';
            echo '<img src="./assets/5203299.jpg" style="width: 60%;" class="mx-auto my-auto">';
            echo '</div>';
        } else {
            // Crea una conexión
            $conn = new mysqli($servername, $username, $password, $database);

            // Verifica la conexión
            if ($conn->connect_error) {
                die("La conexión a MySQL ha fallado: " . $conn->connect_error);
            }

            $pokemonData = json_decode($response);

            // Verifica si el Pokémon ya existe en la tabla 'favoritos'
            $existingPokemonCheck = "SELECT * FROM favoritos WHERE nombre = ?";
            $stmtCheck = mysqli_prepare($conn, $existingPokemonCheck);
            mysqli_stmt_bind_param($stmtCheck, "s", $pokemonData->nombre);
            mysqli_stmt_execute($stmtCheck);
            mysqli_stmt_store_result($stmtCheck);

            if (mysqli_stmt_num_rows($stmtCheck) > 0) {
                echo "<h1>¡Ya tienes a " . $pokemonData->nombre . " en tus favoritos!</h1>";
            } else {
                // Inserta el Pokémon en la tabla 'favoritos'
                $sql = "INSERT INTO favoritos (nombre, numero, url, imagen, descripcion_version_x, descripcion_version_y, altura, categoria, peso, habilidad, sexo, tipo, debilidad, evoluciones, ps, ataque, defensa, ataque_especial, defensa_especial, velocidad) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param(
                    $stmt,
                    "ssssssssssssssiiiiii",
                    $pokemonData->nombre,
                    $pokemonData->numero,
                    $pokemonData->url,
                    $pokemonData->imagen,
                    $pokemonData->descripcionversionx,
                    $pokemonData->descripcionversiony,
                    $pokemonData->altura,
                    $pokemonData->categoria,
                    $pokemonData->peso,
                    $pokemonData->habilidad,
                    $pokemonData->sexo,
                    $pokemonData->tipo,
                    $pokemonData->debilidad,
                    $pokemonData->evoluciones,
                    $pokemonData->puntosbase->ps,
                    $pokemonData->puntosbase->ataque,
                    $pokemonData->puntosbase->defensa,
                    $pokemonData->puntosbase->ataqueespecial,
                    $pokemonData->puntosbase->defensaespecial,
                    $pokemonData->puntosbase->velocidad
                );

                if (mysqli_stmt_execute($stmt)) {
                    echo "<h1>¡" . $pokemonData->nombre . " ha sido agregado a tus favoritos!</h1>";
                } else {
                    echo "<h1>¡Hubo un error al agregar a " . $pokemonData->nombre . " a tus favoritos!</h1>". mysqli_error($conn);
                }

                mysqli_stmt_close($stmt);
            }

            // Cierra la conexión a la base de datos
            $conn->close();
        }

        // Cierra la sesión cURL
        curl_close($ch);
        ?>
        <div class="row mt-4 p-3">
        <div class="col text-center">
    <a class="btn btn-primary" href='pokemon_detalle.php?id=<?php echo $pokemonID ?>'>
        Regresar <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    </a>
</div>

        <div class="col text-center">
            <a class="btn btn-primary" href="index.php">
                Inicio <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a> <!-- Enlace a la página de inicio -->
        </div>
        <div class="col text-center">
            <a class="btn btn-primary" href="favoritos.php">
                Favoritos <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>
        </div>
        </div>
    </div>
</body>
</html>