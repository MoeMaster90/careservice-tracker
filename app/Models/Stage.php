<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(array $array)
 * @method static create([]|array $stageData)
 */
class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage_type_id',
        'patient_id',
        'extra_notes',
        'start',
        'end',
    ];

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function stageType()
    {
        return $this->hasOne(StageType::class);
    }

    public function treatments()
    {
        return $this->belongsToMany(Treatment::class);
    }
}
