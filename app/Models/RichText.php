<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RichText extends Model
{
    use HasFactory;
    protected $fillable = [
        'record_type',
        'record_id',
        'field',
        'body',
    ];

    public function record()
    {
        return $this->morphTo();
    }

}
