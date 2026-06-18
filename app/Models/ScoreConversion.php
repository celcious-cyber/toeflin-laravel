<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreConversion extends Model
{
    protected $fillable = ['section', 'rawScore', 'scaledScore'];
    public $timestamps = false;
}
