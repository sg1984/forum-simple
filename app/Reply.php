<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Reply extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'thread_id', 'user_id', 'body',
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isThisMine()
    {
        if( Auth::guest() ){
            return false;
        }

        return $this->creator->id == Auth::user()->id;
    }
}
