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

    protected $perPage = 5; // agregado para la paginación
}
