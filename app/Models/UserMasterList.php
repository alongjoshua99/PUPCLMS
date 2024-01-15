<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMasterList extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_master_id',
        'user_full_name',
        'status',
        'updated_by',
    ];
}
