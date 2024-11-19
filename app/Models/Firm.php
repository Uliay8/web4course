<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    use HasFactory;

    protected $table = 'Firm';
    protected $fillable = ['name', 'address'];

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class, 'firm');
    }
}
