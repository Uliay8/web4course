<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'Staff';
    protected $fillable = ['staff'];

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class, 'staff');
    }

    public function persons()
    {
        return $this->hasMany(Person::class, 'staff');
    }
}
