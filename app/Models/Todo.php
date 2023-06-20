<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $table = 'todos';

    protected $fillable = [
        'task',
        'user_id',
    ];

    protected $guarded = false;

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'todo_tags', 'todo_id', 'tag_id');
    }

    public function images()
    {
        return $this->hasOne( Image::class);
    }

    public function users()
    {
        return $this->belongsTo( User::class);
    }
}
