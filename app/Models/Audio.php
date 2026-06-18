<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Audio extends Model
{
    use HasUuids;

    protected $fillable = ['fileUrl', 'transcript'];
    public $timestamps = false;
}
