<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    protected $fillable = ['slot'];

    public function workshops()
    {
        return $this->hasMany(Workshop::class, 'time_id');
    }
}
