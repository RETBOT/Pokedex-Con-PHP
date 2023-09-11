<?php
if (isset($_GET['id'])) {
    $pokemonID = $_GET['id'];
} else {
    // Si no se especificó una página en la URL, establece una página por defecto (por ejemplo, 1)
    $pokemonID = 1;
}

// URL de la API a la que deseas hacer la petición
$url = "https://pokedex-api-server.onrender.com/api/v1/pokedex/id/$pokemonID";

// Inicializa cURL
$ch = curl_init($url);

// Configura las opciones de la petición
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta en lugar de imprimirla
// Puedes agregar más opciones aquí según las necesidades de tu API, como headers, métodos, etc.

// Realiza la petición y guarda la respuesta en una variable
$response = curl_exec($ch);

$nombrePokemon = "Error 404";

if (curl_errno($ch)) {
    http_response_code(404);
    echo '<div class="d-flex justify-content-center align-items-center">';
    echo '<img src="./assets/5203299.jpg" style="width: 60%;" class="mx-auto my-auto">';
    echo '</div>';

    echo 'Error en la petición cURL: ' . curl_error($ch);
} else {
    // Decodificar el JSON a un objeto PHP
    $pokemonData = json_decode($response);
    if (isset($pokemonData->nombre)) {
        $nombrePokemon = $pokemonData->nombre;
    } else {
        // La propiedad "nombre" no está definida en $pokemonData
        // Aquí puedes manejar el caso de error o asignar un valor predeterminado a $nombrePokemon si es necesario.
        $nombrePokemon = "Pokémon no encontrado";
    }
}



// URL de la API a la que deseas hacer la petición
$url2 = "https://pokedex-api-server.onrender.com/api/v1/pokedex?page=1";

// Inicializa cURL
$ch2 = curl_init($url2);

// Configura las opciones de la petición
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta en lugar de imprimirla
// Puedes agregar más opciones aquí según las necesidades de tu API, como headers, métodos, etc.

// Realiza la petición y guarda la respuesta en una variable
$response2 = curl_exec($ch2);


if (curl_errno($ch2)) {
    echo 'Error en la petición cURL: ' . curl_error($ch2);
} else {
    // Decodificar el JSON a un objeto PHP
    $pokemonData = json_decode($response2);

    // Obtener el nombre del Pokémon
    $totalPaginas = $pokemonData->total;
}

// Calcular las páginas anterior y siguiente
$paginaAnterior = $pokemonID - 1;
$paginaSiguiente = $pokemonID + 1;

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $nombrePokemon ?></title>
    <link rel="icon" href="./assets/pokedex.png" type="image/png">

    <!-- Incluye Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <?php
        // Verifica si hubo algún error en la petición
        $data = json_decode($response, true);
        if (!isset($data['nombre'])) {
            http_response_code(404);
            echo '<div class="d-flex justify-content-center align-items-center">';
            echo '<img src="./assets/5203299.jpg" style="width: 60%;" class="mx-auto my-auto">';
            echo '</div>';
        } else {
            // Decodifica el JSON en un arreglo asociativo
            echo "<div class='container mt-4'>";
            echo "<h1 class='display-4'>{$data['nombre']} {$data['numero']}</h1>";
            echo "<div class='row justify-content-center' id='pokemon-container'>";
            echo "<div class='col-md-4'>";
            echo "<div class='card border-0 text-center'>";
            echo "<img src='{$data['imagen']}' class='card-img-top' alt='Pokemon'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>{$data['nombre']}</h5>";
            echo "<p class='card-text'><strong>Número:</strong> {$data['numero']}</p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<div class='col-md-8'>";
            echo "<div class='card border-0'>";
            echo "<ul class='list-unstyled'>";
            echo "<li><strong>Tipo:</strong> {$data['tipo']}</li>";
            echo "<li><strong>Categoría:</strong> {$data['categoria']}</li>";
            echo "<li><strong>Habilidad:</strong> {$data['habilidad']}</li>";
            echo "<li><strong>Debilidades:</strong> {$data['debilidad']}</li>";
            echo "<li><strong>Altura:</strong> {$data['altura']}</li>";
            echo "<li><strong>Peso:</strong> {$data['peso']}</li>";
            echo "<li><strong>Sexo:</strong> {$data['sexo']}</li>";
            echo "</ul>";
            echo "<div class='card-text'>";
            echo "<strong>Descripción 1:</strong>";
            echo "<p>{$data['descripcionversionx']}</p>";
            echo "<strong>Descripción 2:</strong>";
            echo "<p>{$data['descripcionversiony']}</p>";
            echo "</div>";
            echo "<div class='card-text'>";
            echo "<strong>Puntos Base:</strong>";
            echo "<ul>";
            foreach ($data['puntosbase'] as $key => $value) {
                echo "<li><strong>{$key}:</strong> {$value}</li>";
            }
            echo "</ul>";
            echo "</div>";
            echo "<div class='card-text'>";
            echo "<strong>Evoluciones:</strong> {$data['evoluciones']}</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

        curl_close($ch);
        curl_close($ch2);

        ?>

        <?php if (isset($data['nombre'])) { ?>
            <form method="post" action="agregar_a_favoritos.php">
                <input type="hidden" name="pokemonID" value="<?php echo $pokemonID; ?>">
                <div class="row mt-4 p-3">
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary" name="agregar_favorito">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Agregar a favoritos
                        </button>
                    </div>
                </div>
            </form>
        <?php } ?>


        <!-- Formulario para cambiar de pokemon -->
        <div class="row mt-4 p-3">
            <?php if (isset($data['nombre'])) { ?>
                <div class="col text-center">
                    <?php if ($pokemonID > 1 && $pokemonID < $totalPaginas + 1) { ?>
                        <a class="btn btn-primary" href="?id=<?php echo $paginaAnterior; ?>">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Pokemon anterior
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="col text-center">
                <a class="btn btn-primary" href="index.php">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar al Inicio
                </a>
            </div>
            <div class="col text-center">
                <a class="btn btn-primary" href="favoritos.php">
                    Favoritos <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                </a>
            </div>
            <?php if (isset($data['nombre'])) { ?>
                <div class="col text-center">
                    <?php if ($pokemonID < $totalPaginas) { ?>
                        <a class="btn btn-primary" href="?id=<?php echo $paginaSiguiente; ?>">
                            Pokemon siguiente <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>