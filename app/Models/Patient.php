<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(string[] $array)
 */
class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
