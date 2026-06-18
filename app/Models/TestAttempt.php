<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TestAttempt extends Model
{
    use HasUuids;

    protected $fillable = ['userId', 'packageId', 'date', 'durationSeconds', 'answers', 'rawScores', 'scaledScores', 'totalScore'];
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'answers' => 'json',
            'rawScores' => 'json',
            'scaledScores' => 'json',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function package()
    {
        return $this->belongsTo(TestPackage::class, 'packageId');
    }
}
