<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasUlids;
    protected $fillable = [
        'name',
        'stock',
        'price',
    ];
    use HasFactory;
}
