<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Add this property to cast is_completed as a boolean
    protected $fillable = ['title', 'is_completed'];

    // Cast the is_completed column as a boolean
    protected $casts = [
        'is_completed' => 'boolean',
    ];
}
