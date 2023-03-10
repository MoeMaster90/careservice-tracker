<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(string[] $array)
 * @property mixed $id
 */
class StageType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
