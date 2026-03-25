<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

     /**
     * Relación Muchos a Muchos con Categorías
     */
    public function categorias(): BelongsToMany
    {
        // 1. Categoria::class -> El modelo al que se conecta
        // 2. 'prod_cat'       -> Tu tabla intermedia en PostgreSQL
        // 3. 'id_productos'   -> La FK que apunta a este modelo (Producto)
        // 4. 'id_categorias'  -> La FK que apunta al otro modelo (Categoria)
        return $this->belongsToMany(
            Categoria::class, 
            'public.prod_cat', 
            'id_productos', 
            'id_categorias'
        )
        ->withPivot('activo', 'id_users')
        ->withTimestamps('fecha_ins', 'fecha_upd');
    }


    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopeInactivo($query)
    {
        return $query->where('activo', false);
    }


}
