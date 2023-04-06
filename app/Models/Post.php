<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'category_id',
        'created_by',
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function scopeWithCommentsByCategoryId($query, $categoryId)
    {
        return $query->where('category_id', $categoryId)->with(['comments' => function ($query) {
            $query->with('user:name,id');
        }]);
    }
}
