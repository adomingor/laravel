<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Producto;
use App\Models\ProductoCategoriaView;
use App\Models\Categoria;

class ProductoController extends Controller
{

    private function obtenerTexto($request)
    {
        return $request->producto ?: 'El registro';
    }
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request): View
    // {
    //     // $productos = ProductoCategoriaView::all();
    //     // return view('producto.index', compact('productos'));

    //     $productos = ProductoCategoriaView::paginate();
    //     // dd($productos->perPage()); // Esto te confirmará exactamente qué número está usando Laravel

    //     return view('producto.index', compact('productos'))
    //          ->with('i', ($request->input('page', 1) - 1) * $productos->perPage());
    // }


    public function index(Request $request)
    {
        $search = $request->input('search');
        $modelo = new ProductoCategoriaView;

        // 1. Paginado dinámico
        $perPageInput = $request->input('per_page', $modelo->getPerPage());
        $perPage = ($perPageInput === 'all') ? $modelo->count() ?: 1 : (int)$perPageInput;

        // 2. Consulta con unaccent para ignorar tildes
        // AGREGAMOS with('usuario') aquí
        $productos = ProductoCategoriaView::with('usuario') 
            ->when($search, function ($query, $search) {
                $term = '%' . $search . '%';
                return $query->whereRaw("unaccent(producto) ILIKE unaccent(?)", [$term])
                            ->orWhereRaw("unaccent(descripcion) ILIKE unaccent(?)", [$term])
                            ->orWhereRaw("unaccent(categorias) ILIKE unaccent(?)", [$term]);
            })
            ->orderBy('producto', 'desc')
            ->paginate($perPage)
            ->appends($request->all());

        return view('producto.index', compact('productos', 'search'))
            ->with('i', ($request->input('page', 1) - 1) * $productos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     * Modificamos para que se pueda elegir las categorias
     */
    public function create(): View
    {
        $producto = new Producto();
        // return view('producto.create', compact('producto'));
         $categorias = Categoria::where('activo', true)->get();

        return view('producto.create', compact('producto', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request): RedirectResponse
    {
        $producto = Producto::create($request->validated());

        // 2. Guardamos la relación en la tabla muchos a muchos (prod_cat)
        // sync recibe el array de IDs del Select2 o de los checkboxes y gestiona la tabla intermedia
        if ($request->has('id_categorias')) {
            // Preparamos los datos extra para cada categoría seleccionada
            $categoriasConDatosExtra = [];
            foreach ($request->id_categorias as $id) {
                $categoriasConDatosExtra[$id] = [
                    'id_users' => auth()->id(), // El ID del usuario actual
                    'activo'   => true,         // Valor por defecto
                ];
            }
        }

        // Sincronizamos con los valores para la tabla intermedia
        $producto->categorias()->sync($categoriasConDatosExtra);

        $texto = $this->obtenerTexto($request);

        return Redirect::route('productos.index')
            ->with('success', __('DadoAlta', ['_txt' => $texto]));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $producto = Producto::find($id);

        return view('producto.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto): View
    {
        // 1. Cargamos todas las categorías activas para llenar el Select2
        $categorias = Categoria::where('activo', true)->get();

        // 2. Cargamos la relación para que el formulario sepa cuáles marcar
        $producto->load('categorias');

        return view('producto.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, Producto $producto): RedirectResponse
    {
        $producto->update($request->validated());

        $texto = $this->obtenerTexto($request);
        return Redirect::route('productos.index')
            ->with('success', __('Grabado', ['_txt' => $texto]))
            ->with('toast_time', 6000);
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // Elimina relaciones en la tabla pivote
        $producto->categorias()->detach();

        // Ahora sí elimina el producto
        $producto->delete();

        return redirect()->back()->with('eliminated', 'El producto fue eliminado correctamente');
    }
    // App\Models\Producto.php
    /**
     * Agregamos la funcion para que muestre las categorias
     */
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'prod_cat', 'id_productos', 'id_categorias')
                    ->withPivot('activo', 'id_users') // Campos extra de tu tabla intermedia
                    ->withTimestamps('fecha_ins', 'fecha_upd');
    }

}