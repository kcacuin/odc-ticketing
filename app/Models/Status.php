<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    // protected $fillable = ['name', 'color_code'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
