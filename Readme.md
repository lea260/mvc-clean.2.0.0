Claro, aquí tienes el contenido completo del `README.md` actualizado con todos los puntos del 1 al 14:

---

# Iniciando el Proyecto con Docker y Composer

Para poner en marcha este proyecto, sigue estos pasos:

---

### 1. Preparar Git y Clonar el Repositorio

Primero, configura Git para evitar problemas de fin de línea que pueden afectar archivos ejecutables en entornos Linux:

```bash
git config --global core.autocrlf true
```

Luego, clona el repositorio. Esto creará una carpeta llamada `mvc-clean.2.0.0` en tu directorio actual:

```bash
git clone git@github.com:lea260/mvc-clean.2.0.0.git
cd mvc-clean.2.0.0
```

Después de clonar, asegúrate de marcar el archivo `docker-entrypoint.sh` como ejecutable:

```bash
git update-index --chmod=+x docker-entrypoint.sh
```

---

### 2. Iniciar los Contenedores Docker

Inicia los servicios definidos en `docker-compose.yml`:

```bash
docker-compose up -d
```

---

### 3. Acceder al Contenedor PHP

```bash
docker exec -it php_container bash
```

---

### 4. Volcar la Autocarga de Composer

```bash
composer dump-autoload
```

---

### 5. Acceder a la Aplicación y phpMyAdmin

* **Aplicación:** [http://localhost:8080](http://localhost:8080)
* **phpMyAdmin:** [http://localhost:8081](http://localhost:8081)

---

### 6. Configurar la Base de Datos

1. Crear una base de datos (ej. `concesionaria`).
2. Importar `schema.sql`.
3. Importar `data.sql`.

---

### 7. Limpieza de Contenedores e Imágenes

```bash
docker compose down --rmi all        # Sin volúmenes  
docker compose down --rmi all -v     # Con volúmenes (¡borrará tus datos!)
```

---

### 8. Solución de Problemas con el Depurador (Xdebug)

1. Verifica que Xdebug esté cargado:

   ```bash
   php -i | grep xdebug
   ```

2. (Opcional) Probar conexión desde el contenedor:

   * Para Alpine:

     ```bash
     apk add telnet-client
     ```

   * Para Debian/Ubuntu:

     ```bash
     apt update && apt install telnet -y
     ```

   Luego:

   ```bash
   telnet host.docker.internal 9011
   ```

---

### 9. Configurar una Regla de Firewall para el Depurador (Windows 11)

Sigue estos pasos para permitir conexiones al puerto `9011` desde el contenedor hacia tu IDE.

1. Ejecuta `wf.msc`.
2. Crea una nueva **Regla de entrada**.
3. Usa el puerto TCP `9011`.
4. Permite la conexión en todos los perfiles.
5. Nómbrala `Xdebug PHP-FPM (Puerto 9011)`.

---

### 10. Debugger y Archivo `php.ini`

El contenedor PHP ya incluye la configuración necesaria para Xdebug. Aquí un resumen:

```ini
[xdebug]
zend_extension=xdebug.so
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.client_host=host.docker.internal
xdebug.client_port=9011
xdebug.discover_client_host=false
extension=pdo_mysql
display_errors = On
display_startup_errors = On
error_reporting = E_ALL
```

Esto permite que Xdebug se conecte a tu IDE en Windows 11 usando el host especial `host.docker.internal` y el puerto `9011`.

---

### 11. Configuración de Depuración en `.vscode/launch.json`

El archivo `.vscode/launch.json` ya está incluido en el repositorio. Define la configuración de depuración para PHP con Xdebug:

```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9011,
      "pathMappings": {
        "/var/www/html": "${workspaceFolder}/src"
      },
      "xdebugSettings": {
        "max_children": 128,
        "max_data": 512,
        "max_depth": 5
      }
    }
  ]
}
```

* **`port: 9011`** debe coincidir con lo definido en el `php.ini` del contenedor.
* **`pathMappings`** indica que `/var/www/html` (dentro del contenedor) corresponde a la carpeta `src` en tu entorno local (`${workspaceFolder}/src`).

> Esto es esencial ya que en `docker-compose.yml` se mapea así:
>
> ```yaml
> - ./src:/var/www/html
> ```

---

### 12. Configuraciones Adicionales de Visual Studio Code

Puedes importar configuraciones personales de desarrollo desde el siguiente Gist:

🔗 [https://gist.github.com/lea260](https://gist.github.com/lea260)

Este archivo contiene preferencias personales, como formato, tema, estilo de pestañas y otras opciones útiles para proyectos PHP con Docker. Puedes adaptarlo o extenderlo según tus necesidades en `.vscode/settings.json`.

#### Extensiones recomendadas:

| Extensión             | ID                                    | Función principal                       |
| --------------------- | ------------------------------------- | --------------------------------------- |
| **PHP Debug**         | `felixfbecker.php-debug`              | Depuración con Xdebug                   |
| **PHP Intelephense**  | `bmewburn.vscode-intelephense-client` | Autocompletado y análisis estático      |
| **Docker** (opcional) | `ms-azuretools.vscode-docker`         | Gestión de contenedores desde el editor |

Instalación rápida desde la terminal:

```bash
code --install-extension felixfbecker.php-debug
code --install-extension bmewburn.vscode-intelephense-client
code --install-extension ms-azuretools.vscode-docker
```

---

### 13. Archivos `.vscode` del Proyecto

La carpeta `.vscode` incluida en el repositorio contiene:

* `launch.json`: configuración del depurador con puerto `9011` y mapeo `/var/www/html` a `src`.
* (Opcional) Puedes añadir o modificar `settings.json` para adaptar VS Code a tus preferencias.
* Puedes agregar tus propias configuraciones según el estilo de trabajo que prefieras.

---

### 14. Solucionar error al iniciar `php_container`

Si al ingresar a [http://localhost:8080](http://localhost:8080) no se obtiene conexión, verifica los logs:

```bash
docker logs php_container
```

Si aparece el error:

```
exec /usr/local/bin/docker-entrypoint.sh: no such file or directory
```

Esto indica que el archivo tiene terminadores de línea incorrectos (CRLF en lugar de LF). Solución:

1. Cambia los saltos de línea de `CRLF` a `LF` en `docker-entrypoint.sh`.
2. Reconstruye el contenedor:

```bash
docker compose build --no-cache php
docker compose up -d
```

3. Luego verifica el contenedor PHP:

```bash
docker exec -it php_container bash
```

---

¿Deseas agregar también un punto sobre testing, rutas o controladores para cerrar el flujo de desarrollo?
