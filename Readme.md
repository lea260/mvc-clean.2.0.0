## Iniciando el Proyecto con Docker y Composer

Para poner en marcha este proyecto, sigue estos pasos:

### 1. Acceder al Contenedor PHP

Primero, necesitas acceder al entorno PHP dentro de tu contenedor Docker. Esto te permitirá ejecutar comandos de Composer y otras operaciones relacionadas con PHP.

```bash
docker exec -it php_container bash
```
Este comando ejecuta un shell interactivo (`-it`) dentro del contenedor llamado `php_container`.

### 2. Volcar la Autocarga de Composer

Una vez dentro del contenedor, el siguiente paso es "volcar" la autocarga de Composer. Esto es crucial después de instalar o actualizar dependencias, ya que regenera el mapa de clases para que Composer sepa dónde encontrar todos los archivos de tu proyecto.

```bash
composer dump-autoload
```

**Nota:** Es importante ejecutar `composer dump-autoload` siempre que añadas nuevas clases, cambies el namespace de alguna existente, o instales nuevas librerías para asegurar que tu proyecto funcione correctamente.