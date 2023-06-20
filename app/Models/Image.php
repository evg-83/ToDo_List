<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'todo_id',
        'image',
    ];

    protected $guarded = false;

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
