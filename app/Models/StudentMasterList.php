<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMasterList extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id_number',
        'full_name',
    ];
}
