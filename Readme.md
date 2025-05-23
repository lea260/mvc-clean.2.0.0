Here's the updated `README.md` with all the requested information, including the application and phpMyAdmin access details, and database setup instructions.

-----

# Iniciando el Proyecto con Docker y Composer

Para poner en marcha este proyecto, sigue estos pasos:

### 1\. Iniciar los Contenedores Docker

Lo primero que debes hacer es levantar todos los servicios definidos en tu archivo `docker-compose.yml`. Esto iniciará tu entorno de desarrollo, incluyendo el contenedor PHP, en segundo plano.

```bash
docker-compose up -d
```

-----

### 2\. Acceder al Contenedor PHP

Una vez que los contenedores estén en funcionamiento, necesitarás acceder al entorno PHP dentro de tu contenedor Docker. Esto te permitirá ejecutar comandos de Composer y otras operaciones relacionadas con PHP.

```bash
docker exec -it php_container bash
```

Este comando ejecuta un shell interactivo (`-it`) dentro del contenedor llamado `php_container`.

-----

### 3\. Volcar la Autocarga de Composer

Una vez dentro del contenedor, el siguiente paso es "volcar" la autocarga de Composer. Esto es crucial después de instalar o actualizar dependencias, ya que regenera el mapa de clases para que Composer sepa dónde encontrar todos los archivos de tu proyecto.

```bash
composer dump-autoload
```

**Nota:** Es importante ejecutar `composer dump-autoload` siempre que añadas nuevas clases, cambies el *namespace* de alguna existente, o instales nuevas librerías para asegurar que tu proyecto funcione correctamente.

-----

### 4\. Acceder a la Aplicación y phpMyAdmin

Una vez que los contenedores estén corriendo y Composer haya actualizado la autocarga, podrás acceder a la aplicación y a phpMyAdmin:

  * **La aplicación estará disponible en:**
    [http://localhost:8080](https://www.google.com/search?q=http://localhost:8080)

  * **Para ingresar a phpMyAdmin, utiliza la siguiente URL:**
    [http://localhost:8081](https://www.google.com/search?q=http://localhost:8081)

-----

### 5\. Configurar la Base de Datos

Dentro de phpMyAdmin, deberás crear y poblar la base de datos:

1.  **Crea una nueva base de datos** (el nombre debería coincidir con el configurado en tu aplicación, comúnmente `concesionaria` si usaste el ejemplo anterior).
2.  **Importa el esquema de la base de datos** ejecutando el archivo `schema.sql`. Esto creará todas las tablas necesarias.
3.  **Importa los datos iniciales** ejecutando el archivo `data.sql`. Esto poblará las tablas con datos de ejemplo.

¡Tu aplicación ya debería estar lista para usar\!