<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    protected $table = 'Vacancy';
    protected $fillable = ['firm', 'staff'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

}
