<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable =[
        'content',
        'user_id'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
