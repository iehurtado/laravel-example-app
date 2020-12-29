# Información General
Esta es una aplicación de ejemplo, que incluye una parte web y una api muy sencillas.
Es una suerte de tablón donde los usuarios pueden escribir cosas y comentar publicaciones de otros usuarios.
La app se complementa con el paquete <a href="https://github.com/iehurtado/laravel-example-package">laravel-example-package</a> que provee el modelo para los comentarios.

# Estructura del Proyecto
La estructura es la típica de un proyecto Laravel, como se explica <a href="https://laravel.com/docs/8.x/structure">aquí</a>

# Instalación
1. Crear una base de datos para el proyecto (a criterio)

2. Parado en la raíz del proyecto, ejecutar:
```
$ composer install
```

3. Modificar el archivo .env creado en la raíz del proyecto con los parámetros requeridos para la base de datos.

4. Ejecutar:
```
$ php artisan migrate --seed
```

En este último paso deberían haberse generado las tablas con algunos datos de prueba. Entre ellos, tres usuarios:
- email: usuario@app.com, password: abc123123, rol: ninguno
- email: moderador@app.com, password: abc123123, rol: 'moderator'
- email: admin@app.com, password: abc123123, rol: 'admin'
