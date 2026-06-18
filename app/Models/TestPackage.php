<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TestPackage extends Model
{
    use HasUuids;

    protected $fillable = [
        'id',
        'name',
        'type',
        'status',
        'questions',
        'durations',
        'instruction_listening',
        'instruction_structure',
        'instruction_reading'
    ];
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'questions' => 'json',
            'durations' => 'json',
        ];
    }
}
