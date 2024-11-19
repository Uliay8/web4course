<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'Person';
    protected $fillable = ['fio', 'staff', 'phone', 'stage', 'image', 'created_at', 'updated_at'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
