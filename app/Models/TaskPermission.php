<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'can_assign',
        'can_create',
        'permit_to'
    ];
}
