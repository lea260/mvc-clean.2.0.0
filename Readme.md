Here's the updated `README.md` with the Git clone instructions added as the initial step, before the Docker setup.

-----

# Iniciando el Proyecto con Docker y Composer

Para poner en marcha este proyecto, sigue estos pasos:

### 1\. Clonar el Repositorio

Primero, descarga el código fuente del proyecto desde GitHub. Esto creará una carpeta llamada `mvc-clean.2.0.0` en tu directorio actual.

```bash
git clone git@github.com:lea260/mvc-clean.2.0.0.git
```

Una vez clonado, **ingresa a la carpeta del proyecto**:

```bash
cd mvc-clean.2.0.0
```

-----

### 2\. Iniciar los Contenedores Docker

Ahora que estás en la carpeta del proyecto, levanta todos los servicios definidos en tu archivo `docker-compose.yml`. Esto iniciará tu entorno de desarrollo, incluyendo el contenedor PHP, en segundo plano.

```bash
docker-compose up -d
```

-----

### 3\. Acceder al Contenedor PHP

Una vez que los contenedores estén en funcionamiento, necesitarás acceder al entorno PHP dentro de tu contenedor Docker. Esto te permitirá ejecutar comandos de Composer y otras operaciones relacionadas con PHP.

```bash
docker exec -it php_container bash
```

Este comando ejecuta un shell interactivo (`-it`) dentro del contenedor llamado `php_container`.

-----

### 4\. Volcar la Autocarga de Composer

Una vez dentro del contenedor, el siguiente paso es "volcar" la autocarga de Composer. Esto es crucial después de instalar o actualizar dependencias, ya que regenera el mapa de clases para que Composer sepa dónde encontrar todos los archivos de tu proyecto.

```bash
composer dump-autoload
```

**Nota:** Es importante ejecutar `composer dump-autoload` siempre que añadas nuevas clases, cambies el *namespace* de alguna existente, o instales nuevas librerías para asegurar que tu proyecto funcione correctamente.

-----

### 5\. Acceder a la Aplicación y phpMyAdmin

Una vez que los contenedores estén corriendo y Composer haya actualizado la autocarga, podrás acceder a la aplicación y a phpMyAdmin:

  * **La aplicación estará disponible en:**
    [http://localhost:8080](https://www.google.com/search?q=http://localhost:8080)

  * **Para ingresar a phpMyAdmin, utiliza la siguiente URL:**
    [http://localhost:8081](https://www.google.com/search?q=http://localhost:8081)

-----

### 6\. Configurar la Base de Datos

Dentro de phpMyAdmin, deberás crear y poblar la base de datos:

1.  **Crea una nueva base de datos** (el nombre debería coincidir con el configurado en tu aplicación, comúnmente `concesionaria` si usaste el ejemplo anterior).
2.  **Importa el esquema de la base de datos** ejecutando el archivo `schema.sql`. Esto creará todas las tablas necesarias.
3.  **Importa los datos iniciales** ejecutando el archivo `data.sql`. Esto poblará las tablas con datos de ejemplo.

¡Tu aplicación ya debería estar lista para usar\!

-----

### 7\. Limpieza de Contenedores e Imágenes

Cuando termines de trabajar en el proyecto o quieras liberar espacio, puedes usar estos comandos para detener y eliminar los recursos de Docker:

  * **Para detener los contenedores y eliminar sus imágenes (pero no los volúmenes de datos):**

    ```bash
    docker compose down --rmi all
    ```

  * **Para detener los contenedores, eliminar sus imágenes y también los volúmenes de datos (¡uso con precaución, esto borrará tus datos\!):**

    ```bash
    docker compose down --rmi all -v
    ```

-----

### 8\. Solución de Problemas con el Depurador (Xdebug)

Si estás teniendo problemas con el depurador (Xdebug) o quieres verificar su configuración, sigue estos pasos desde una terminal bash dentro de tu contenedor PHP:

1.  **Ingresa al contenedor PHP:**

    ```bash
    docker exec -it php_container bash
    ```

2.  **Verifica la configuración de Xdebug:**
    Una vez dentro del contenedor, ejecuta el siguiente comando para ver si Xdebug está cargado y sus configuraciones:

    ```bash
    php -i | grep xdebug
    ```

    Busca líneas que confirmen que Xdebug está habilitado y configurado para conectarse a la IP correcta de tu host y puerto de depuración (generalmente `host.docker.internal` y el puerto por defecto de Xdebug es `9003` o `9000`).

3.  **Verifica la conexión del depurador (opcional, para entornos sin `telnet` preinstalado):**
    Si quieres asegurarte de que tu host puede conectarse al puerto de depuración, puedes intentar usar `telnet`. Primero, instala `telnet` dentro del contenedor (el comando varía según la distribución de Linux que use tu imagen PHP):

      * **Para Alpine (u otras distros basadas en `apk`):**

        ```bash
        apk add telnet-client
        ```

      * **Para Debian/Ubuntu (u otras distros basadas en `apt`):**

        ```bash
        apt update && apt install telnet -y
        ```

    Una vez instalado `telnet`, puedes probar la conexión al depurador desde el contenedor (reemplaza `<PUERTO_DEL_DEPURADOR>` con el puerto configurado para Xdebug, comúnmente 9003 o 9000):

    ```bash
    telnet host.docker.internal <PUERTO_DEL_DEPURADOR>
    ```

    Si la conexión es exitosa, verás algo como "Connected to host.docker.internal". Si falla, podría haber un problema con el puerto, el firewall, o la configuración de Xdebug en el archivo `php.ini`.

-----

### 9\. Configurar una Regla de Firewall para el Depurador (Windows 11)

Si estás utilizando Windows 11 y tu depurador (Xdebug) no logra conectarse desde el contenedor a tu IDE, es posible que el Firewall de Windows esté bloqueando la conexión entrante al puerto del depurador.

Sigue estos pasos para crear una regla de entrada en el Firewall de Windows para permitir las conexiones al puerto `9011` (o el puerto que hayas configurado para Xdebug en tu IDE y `php.ini`):

1.  **Abrir el Firewall de Windows con Seguridad avanzada:**

      * Presiona `Win + R` para abrir el cuadro de diálogo Ejecutar.
      * Escribe `wf.msc` y presiona Enter. Esto abrirá la consola de "Firewall de Windows con seguridad avanzada".

2.  **Crear una Nueva Regla de Entrada:**

      * En el panel de la izquierda, haz clic en **Reglas de entrada**.
      * En el panel de la derecha, haz clic en **Nueva regla...**.

3.  **Configurar la Regla:**

      * **Tipo de regla:** Selecciona `Puerto` y haz clic en `Siguiente`.
      * **Protocolo y puertos:**
          * Deja seleccionado `TCP`.
          * En `Puertos locales específicos`, escribe `9011` (o tu puerto de depuración configurado). Haz clic en `Siguiente`.
      * **Acción:** Selecciona `Permitir la conexión` y haz clic en `Siguiente`.
      * **Perfil:** Marca todos los perfiles (`Dominio`, `Privado`, `Público`) para asegurar que la regla funcione en cualquier red. Haz clic en `Siguiente`.
      * **Nombre:** Asigna un nombre descriptivo a la regla, por ejemplo, `Xdebug PHP-FPM (Puerto 9011)`. Puedes añadir una descripción si lo deseas. Haz clic en `Finalizar`.

Después de crear la regla, Xdebug debería poder conectarse a tu IDE sin problemas.