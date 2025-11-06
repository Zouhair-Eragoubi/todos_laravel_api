<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'priority',
        'category_id',
        'due_date',
        'tags',
        'completed'
    ];
    protected $casts = [
        'tags' => 'array',
        'due_date' => 'datetime',
        'completed' => 'boolean',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
