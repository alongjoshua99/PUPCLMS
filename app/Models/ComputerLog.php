<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerLog extends Model
{
    use HasFactory;
    /* protected $fillable = [
        'computer_id',
        'status',
        'description',
        'checked_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ]; */
    protected $guarded = [];

}
