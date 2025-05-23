<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'sort_description',
        'status'
    ];

    public function getStatusAttribute($value): string
    {
        return $value ? 'incomplete' : 'complete';
    }
}
