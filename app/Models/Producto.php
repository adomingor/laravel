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
    // como la tabla tiene fecha_ins y fecha_upd hay que agregar
    const CREATED_AT = 'fecha_ins';
    const UPDATED_AT = 'fecha_upd';    
    
    // agregamos si queremos paginacion (ahora la está usando del modelo de la vista app\Models\ProductoCategoriaView.php)
    // protected $perPage = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = ['producto', 'descripcion', 'activo', 'id_users', 'fecha_ins', 'fecha_upd'];
    protected $fillable = ['producto', 'descripcion', 'activo', 'id_users'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prodCats()
    {
        return $this->hasMany(\App\Models\ProdCat::class, 'id', 'id_productos');
    }
    
    public function user() // Puedes llamarlo 'user' o 'usuario'
    {
        return $this->belongsTo(\App\Models\User::class, 'id_users', 'id'); // Ponemos el nombre de la columna de la vista, nombre de la columna de la tabla users
    }    

}
