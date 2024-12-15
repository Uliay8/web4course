<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workshop extends Model
{
    use HasFactory;

    protected $table ='workshops';
    protected $fillable = [
        'name',
        'description',
        'cost',
        'number_of_seats',
        'type_id',
        'master_id',
        'time_id',
        'date',
    ];
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function hour()
    {
        return $this->belongsTo(Hour::class);
    }
    public function master()
    {
        return $this->belongsTo(User::class);
    }
    public function participants()
    {
        return $this->hasMany(Participant::class, 'workshop_id');
    }
}
