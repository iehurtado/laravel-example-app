<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Un Post.
 * 
 * @property int $id Identificador
 * @property int $author_id Identificador del Autor
 * @property string $title Título
 * @property string $body Contenido
 * @property string $paragraphs Contenido dividido en párrafos
 * @property string $abstract Resumen del post (hasta 140 caracteres)
 * @property \DateTime $created_at Fecha de Creación
 * @property \DateTime $updated_at Fecha de Actualización
 * @property User $author Autor del post
 */
class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'author_id',
        'title',
        'body',
    ];
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    /**
     * Devuelve los párrafos que forman el contenido
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getParagraphsAttribute()
    {
        return collect(explode(PHP_EOL, $this->attributes['body']));
    }
    
    public function getAbstractAttribute()
    {
        $body = $this->attributes['body'];
        
        if (strlen($body) <= 140) {
            return $body;
        }
        
        $first140 = substr($body, 0, 140);
        return "$first140 [...]";
    }
}
