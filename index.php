<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pokédex</title>
    <link rel="icon" href="./assets/pokedex.png" type="image/png">

    <!-- Incluye Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <?php

        if (isset($_GET['pagina'])) {
            $paginaActual = $_GET['pagina'];
        } else {
            // Si no se especificó una página en la URL, establece una página por defecto (por ejemplo, 1)
            $paginaActual = 1;
        }

        // URL de la API a la que deseas hacer la petición
        $url = "https://pokedex-api-server.onrender.com/api/v1/pokedex?page=$paginaActual";

        // Inicializa cURL
        $ch = curl_init($url);

        // Configura las opciones de la petición
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta en lugar de imprimirla
        // Puedes agregar más opciones aquí según las necesidades de tu API, como headers, métodos, etc.

        // Realiza la petición y guarda la respuesta en una variable
        $response = curl_exec($ch);

        // Verifica si hubo algún error en la petición
        if (curl_errno($ch)) {
            echo 'Error en la petición cURL: ' . curl_error($ch);
        } else {
            // Decodifica el JSON en un arreglo asociativo
            $data = json_decode($response, true);
            $totalPaginas = $data['pages'];

            if ($paginaActual > $totalPaginas) {
                // Si la página solicitada es mayor al total de páginas disponibles, muestra un error 404
                http_response_code(404);
                echo '<div class="d-flex justify-content-center align-items-center">';
                echo '<img src="./assets/5203299.jpg" style="width: 60%;" class="mx-auto my-auto">';
                echo '</div>';
            } else {
                if (isset($_GET['pagina'])) {
                    $paginaActual = max(1, min($_GET['pagina'], $totalPaginas)); // Asegura que la página esté dentro del rango válido
                }

                // Muestra los Pokémon de la página actual
                $elementosPorPagina = 10; // Cambia esto según tus necesidades
                $inicio = ($paginaActual - 1) * $elementosPorPagina;
                $fin = min($inicio + $elementosPorPagina, count($data['docs']));

                // Itera a través de los elementos en el arreglo
                echo "<h1 class='mt-4'>Pokédex</h1>";
                echo "<div class='row justify-content-center' id='pokemon-container'>";
                $count = 0; // Variable para rastrear el número de tarjetas en la fila actual

                foreach ($data['docs'] as $pokemon) {
                    echo "<div class='col-md-4'>";
                    echo "<div class='card' >"; // Tarjeta de Pokémon con ancho 100%
                    echo "<img src='" . $pokemon['imagen'] . "' class='card-img-top' alt='Pokemon'>";

                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $pokemon['nombre'] . "</h5>";
                    echo "<p class='card-text'><strong>Número:</strong> " . $pokemon['numero'] . "</p>";
                    echo "<p class='card-text'><strong>Tipo:</strong> " . $pokemon['tipo'] . "</p>";
                    echo "<p class='card-text'><strong>Categoría:</strong> " . $pokemon['categoria'] . "</p>";
                    echo "<p class='card-text'><strong>Habilidad:</strong> " . $pokemon['habilidad'] . "</p>";
                    echo "<p class='card-text'><strong>Debilidades:</strong> " . $pokemon['debilidad'] . "</p>";

                    // Botón "Ver detalles" con estilo de botón Bootstrap
                    // En el bucle foreach
                    echo "<div class='text-center mt-3'>";
                    echo "<a href='pokemon_detalle.php?id=" . $pokemon['_id'] . "' class='btn btn-primary btn-sm'>Ver detalles</a>"; // Enlace a la página de detalles
                    echo "</div>";


                    echo "</div>";
                    echo "</div>"; // Cerrar la tarjeta de Pokémon
                    echo "</div>"; // Cerrar el div para el contenido de la tarjeta

                    $count++;

                    if ($count % 3 == 0 || $count == count($data['docs'])) {
                        // Cierra la fila después de cada tercer Pokémon o en la última iteración
                        echo "</div>";
                        echo "<div class='row justify-content-center'>"; // Inicia una nueva fila y centra el contenido
                    }
                }

                echo "</div>";

                // Calcula el número de página siguiente y página anterior
                $paginaSiguiente = min($paginaActual + 1, $totalPaginas);
                $paginaAnterior = max($paginaActual - 1, 1);
            }
        }

        // Cierra la sesión cURL
        curl_close($ch);
        ?>
        <!-- Formulario para cambiar de página -->
        <div class="row mt-4 p-3">
            <div class="col text-center">
                <?php if ($paginaActual > 1 && $paginaActual < $totalPaginas + 1) { ?>
                    <a class="btn btn-primary" href="?pagina=<?php echo $paginaAnterior; ?>">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Página anterior
                    </a>
                <?php } ?>
            </div>
            <?php if ($paginaActual != 1) { ?>
            <div class="col text-center">
                    <a class="btn btn-primary" href="index.php">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar al Inicio
                    </a>
            </div>
            <?php } ?>
            <div class="col text-center">
                <a class="btn btn-primary" href="favoritos.php">
                    Favoritos <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                </a>
            </div>
            
            <div class="col text-center">
                <?php if ($paginaActual < $totalPaginas) { ?>
                    <a class="btn btn-primary" href="?pagina=<?php echo $paginaSiguiente; ?>">
                        Página siguiente <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Incluye Bootstrap JS y jQuery (opcional, si lo necesitas) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Escucha el evento submit del formulario
        document.getElementById('cambiar-pagina-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita que el formulario se envíe

            // Obtiene el valor ingresado por el usuario
            var nuevaPagina = document.getElementById('pagina').value;

            // Verifica si la nueva página es válida
            if (nuevaPagina >= 1 && nuevaPagina <= <?php echo $totalPaginas; ?>) {
                // Redirecciona a la nueva página
                window.location.href = '?pagina=' + nuevaPagina;
            }
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function verificarServidor() {
            $.ajax({
                url: 'https://pokedex-api-server.onrender.com/api/v1/pokedex?page=$1',

                method: 'GET',
                success: function(response) {
                    if (response === 'listo') {
                        // El servidor está listo, redirige o carga el contenido principal
                        window.location.href = 'pokemon/?pagina=1';
                    }
                },
                error: function(xhr, status, error) {
                    // Maneja errores aquí, si es necesario
                }
            });
        }

        // Realiza la verificación cada 5 segundos (ajusta el intervalo según tus necesidades)
        setInterval(verificarServidor, 5000);
    </script>
</body>

</html>