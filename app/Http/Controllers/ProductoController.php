<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index() {
        return view("listado_productos");
    }

    public function create() {
        return "Creacion de un nuevo producto";
    }

    public function store(Request $request) {
        return "Producto guardado correctamente";
    }

    public function show($id) {
        // return view("show", ["id" => $id]); // forma 1 de pasar parametros a la vista (si aquí se pone "codigo" en vez de "id", en la vista se debe usar $codigo para acceder al valor)
        // return view("show")->with("id", $id); // forma 2 de pasar parametros a la vista
        $nombre = "Nombre del Producto $id";
        return view("show", compact("id", "nombre")); // forma 3 de pasar parametros a la vista
    }

    public function edit($id) {
        return "Editando producto";
    }

    public function update(Request $request, $id) {
        return "Producto actualizado correctamente";
    }

    public function destroy($id) {
        return "Producto eliminado correctamente";
    }
}
