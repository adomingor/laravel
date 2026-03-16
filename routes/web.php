<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return view('inicio');
});

                                        // 7 rutas necesarias de un circuito CRUD
/* 1 - Listado de registros */
Route::get('productos', [ProductoController::class, "index"])->name('productos.index');

/* 2 - Formulario de alta */
Route::get('productos/crear', function() {
    return "Form alta de productos";
});

/* 3 - Procesar el formulario de alta */
Route::post('productos', function() {
    return "Proceso de formulario de alta de productos";
});

/* 4 - Mostrar un registro */
Route::get('productos/{id}', function ($id) {
    return "Muestra los datos del producto $id";
});

/* 5 - Formulario de edición */
Route::get('productos/{id}/editar', function ($id) {
    return "Mustra el formulario de edición de un producto ($id)";
});

/* 6 - Procesar el formulario de edición */
Route::put('productos/{id}', function ($id) {
    return "Proceso del formulario de actualización de productos";
});

/* 7 - Eliminar un registro */
Route::delete('productos/{id}', function ($id) {
    return "Se procesa el borrado del producto";
});
                                        // FIN 7 rutas necesarias de un circuito CRUD