<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $id
 * @property $producto
 * @property $descripcion
 * @property $activo
 * @property $id_users
 * @property $fecha_ins
 * @property $fecha_upd
 *
 * @property ProdCat[] $prodCats
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{
    
    // agregamos si queremos paginacion
    protected $perPage = 5;

    // como la tabla tiene fecha_ins y fecha_upd hay que agregar
    const CREATED_AT = 'fecha_ins';
    const UPDATED_AT = 'fecha_upd';    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['producto', 'descripcion', 'activo', 'id_users', 'fecha_ins', 'fecha_upd'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prodCats()
    {
        return $this->hasMany(\App\Models\ProdCat::class, 'id', 'id_productos');
    }
    
}
