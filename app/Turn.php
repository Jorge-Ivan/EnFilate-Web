<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'user_id', 'name', 'document', 'consult_type'
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
