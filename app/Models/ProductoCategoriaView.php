<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la vista vw_productos_categorias
 */
class ProductoCategoriaView extends Model
{
    protected $table = 'vw_productos_categorias';

    protected $primaryKey = 'id';

    public $timestamps = false;

    // Es una vista → no se puede escribir
    public $incrementing = false;

    protected $guarded = [];

    protected $perPage = 7; // agregado para la paginación


    public function usuario() // Puedes llamarlo 'user' o 'usuario'
    {
        return $this->belongsTo(\App\Models\User::class, 'producto_id_users', 'id'); // Ponemos el nombre de la columna de la vista, nombre de la columna de la tabla users
    }    

}