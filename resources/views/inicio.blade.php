<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DOMINGOL</title>
    </head>
    <body>
        <h1> Hola mundo mundial!!! </h1>

        <a href="{{ route('productos.index') }}">
            Listado de Productos
        </a>

    </body>
</html>
