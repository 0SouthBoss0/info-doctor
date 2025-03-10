<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';
    protected $fillable = ['first_name', 'last_name', 'middle_name', 'age', 'medical_history'];
}
