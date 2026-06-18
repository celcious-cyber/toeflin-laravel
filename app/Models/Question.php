<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Question extends Model
{
    use HasUuids;

    protected $fillable = ['section', 'skillCategory', 'content', 'choices', 'answerKey', 'explanation', 'audioId', 'passageId', 'packageId'];
    public $timestamps = false;

    public function audio()
    {
        return $this->belongsTo(Audio::class, 'audioId');
    }

    public function passage()
    {
        return $this->belongsTo(Passage::class, 'passageId');
    }

    public function package()
    {
        return $this->belongsTo(TestPackage::class, 'packageId');
    }
}
