<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Categoria
 *
 * @property int $id
 * @property string $categoria
 * @property bool $activo
 * @property int|null $id_users
 * @property \Carbon\Carbon|null $fecha_ins
 * @property \Carbon\Carbon|null $fecha_upd
 */
class Categoria extends Model
{
    protected $table = 'categorias';

    protected $primaryKey = 'id';

    public $timestamps = true;

    const CREATED_AT = 'fecha_ins';
    const UPDATED_AT = 'fecha_upd';

    protected $fillable = [
        'categoria',
        'activo',
        'id_users',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_ins' => 'datetime',
        'fecha_upd' => 'datetime',
    ];

    /**
     * Relación directa con la tabla pivote
     */
    public function prodCats(): HasMany
    {
        return $this->hasMany(ProdCat::class, 'id_categorias');
    }

    /**
     * Relación muchos a muchos con productos
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(
            Producto::class,
            'prod_cat',
            'id_categorias',
            'id_productos'
        )
        ->withPivot(['id', 'activo', 'id_users', 'fecha_ins', 'fecha_upd'])
        ->withTimestamps();
    }

    /**
     * Scope para activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}