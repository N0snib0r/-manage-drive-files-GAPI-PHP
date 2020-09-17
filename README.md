# Google Drive API para PHP

## Esta APP puede: 
- Listar los archivos/carpetas que esten dentro de la carpeta de la APP
- Eliminar archivos/carpetas.
- Subir archivos a la carpeta de la APP.
- Descargar archivos.
- Mostrar contenido de tipo Media.
- Renombrar archivo/carpeta.
- Crear nueva carpeta.

## Requerimientos
- La API necesita de unas credenciales unicas de la App registrada en Google developers [Google developers](https://console.developers.google.com/)
- Descargar el [SDK de Google API para PHP](https://github.com/googleapis/google-api-php-client/releases) y desconprimirlo en raiz.
- Funcionamiento comprobado con las versiones **2.2.4** y **2.7.0 para PHP7.4**
### Pasos
1. Registrarse con una cuenta de google en [Google developers](https://console.developers.google.com/).
2. Crear un proyecto.
3. Buscar la API de Google que necesitas en el buscador **Google Drive API**, y activarla.
4. Crear la pantalla de consentimiento (Solo es necesario el nombre)
    - Solo es necesario el nombre de la App.
    - En caso de querer colocar mas información de la App (imagen, modo privado) requerira verificación.
5. Crear credenciales de tipo **ID de cliente OAuth**.
6. Dentro de la credencial;  llenar el campo **URIs** *ej: http://example/gg-drive/drive*.
7. Descargar las credenciales en formato JSON y guardarlo en la carpeta **credentials/**

## Configuración
### config/config.php
- Cambiar la ruta maestra por la ruta de tu directorio raiz.
### tokens/
- Crear la carpeta **tokens/** en raiz.
### libs/model.php
- Modificar *linea 9* con el nombre del SDK que se descargo y se encuentra en raiz.
### libs/connection.php
- *Line 9*: Colocar el nombre de las nuevas credenciales de la App (El nombre puede variar).

## Funcionamiento
- Para cargar la pantalla principal coloqeue la ruta: http://{SERVER}/{RAIZ}/main | *ej: http://example/gg-drive/drive*