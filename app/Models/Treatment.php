<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereIn(string $string, mixed $treatments)
 * @method static firstOrCreate(array $array)
 */
class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
