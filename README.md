# Pokedex-PHP
Este es un proyecto de página web que utiliza PHP, Bootstrap y MySQL para interactuar con una API Pokedex. Con esta aplicación, los usuarios pueden buscar y obtener información detallada sobre diferentes Pokémon.

## Enlace a la Página en Línea
Puedes acceder a la página en línea haciendo clic en el siguiente enlace:
[Página en linea](https://pokedex-retbot.000webhostapp.com/index.php)
![Img_Página en linea](https://github.com/RETBOT/Pokedex-PHP/blob/main/assets/pokedex_php.png)

## Funcionalidades
- Búsqueda de Pokémon por nombre o número de Pokédex.
- Visualización de detalles de Pokémon, como tipo, altura, peso y más.
- Listado de todos los Pokémon disponibles.
- Interfaz de usuario amigable y atractiva gracias a Bootstrap.

# Requisitos
Antes de comenzar a utilizar esta aplicación, asegúrate de tener instalado lo siguiente:

- PHP (versión 7 o superior)
- MySQL (o un servidor de base de datos compatible)

# Configuración
1. Clona este repositorio en tu servidor web local o en tu servidor de producción.
    ```bash
    git clone https://github.com/tu-usuario/pokedex.git
    ```
2. Crea una base de datos MySQL y configura las credenciales en config.php.
    ```php
    // config.php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'tu_usuario');
    define('DB_PASS', 'tu_contraseña');
    define('DB_NAME', 'nombre_de_la_base_de_datos');
    ```
3. Importa la estructura de la base de datos utilizando el archivo SQL proporcionado en la carpeta database.
    ```bash
    mysql -u tu_usuario -p nombre_de_la_base_de_datos < database/pokedex.sql
    ```
4. Inicia tu servidor web y accede al proyecto a través de un navegador.

## Uso
Una vez que la aplicación esté configurada, puedes empezar a utilizarla para buscar y explorar información sobre Pokémon. Sigue las instrucciones en la pantalla para comenzar.

## Contribución
Si deseas contribuir a este proyecto, siéntete libre de hacer un fork y enviar solicitudes de extracción. Estamos abiertos a mejoras y nuevas características.

## Licencia
Este proyecto se distribuye bajo la Licencia MIT. Consulta el archivo LICENSE para obtener más información.

¡Esperamos que disfrutes utilizando la Pokedex y que este proyecto sea útil para tus necesidades! Si tienes alguna pregunta o problema, no dudes en abrir un problema en el repositorio o ponerte en contacto con nosotros. ¡Atrapa todos los Pokémon!
