<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TestRequest extends Model
{
    use HasUuids;

    protected $fillable = ['userId', 'packageId', 'status'];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function package()
    {
        return $this->belongsTo(TestPackage::class, 'packageId');
    }
}
