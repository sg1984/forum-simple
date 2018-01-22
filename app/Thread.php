<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Thread extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'body', 'category',
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function path()
    {
        if( empty($this->id) ){
            throw new \Exception("The thread must be saved to have a path.");
        }

        return route('thread.show', [$this]);
    }

    public function getCreatedDate()
    {
        return $this->updated_at->format('d/m/Y');
    }

    public function getCreatedDateComplete()
    {
        return $this->updated_at->format('d/m/Y H:i');
    }

    public function isThisThreadMine()
    {
        if( Auth::guest() ){
            return false;
        }

        return $this->creator->id == Auth::user()->id;
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    public static function getAllCategories()
    {
        return self::query()
            ->distinct()
            ->get(['category'])
            ->pluck('category');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public static function getCountByCategory($category)
    {
        return self::byCategory($category)->count();
    }

    public function scopeBySearch($query, $searchTerm)
    {
        $searchTermLike = '%' . $searchTerm . '%';

        return $query
            ->where('title', 'like', $searchTermLike)
            ->orWhere('body', 'like', $searchTermLike)
            ->orWhere('category', 'like', $searchTermLike);
    }
}
