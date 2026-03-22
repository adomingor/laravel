<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProdCat
 *
 * Tabla pivote extendida (con atributos propios)
 *
 * @property int $id
 * @property int $id_productos
 * @property int $id_categorias
 * @property bool $activo
 * @property int|null $id_users
 * @property \Carbon\Carbon|null $fecha_ins
 * @property \Carbon\Carbon|null $fecha_upd
 */
class ProdCat extends Model
{
    protected $table = 'prod_cat';

    protected $primaryKey = 'id';

    public $timestamps = true;

    const CREATED_AT = 'fecha_ins';
    const UPDATED_AT = 'fecha_upd';

    protected $fillable = [
        'id_productos',
        'id_categorias',
        'activo',
        'id_users',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_ins' => 'datetime',
        'fecha_upd' => 'datetime',
    ];

    /**
     * Relación con Producto
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_productos');
    }

    /**
     * Relación con Categoria
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categorias');
    }

    /**
     * Scope para activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}