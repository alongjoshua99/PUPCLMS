<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;
    /* protected $fillable = [
        'computer_number',
        'computer_name',
        'os',
        'os_version',
        'processor',
        'memory',
        'storage',
           'ip_address',
        'created_at',
        'updated_at',
        'deleted_at',
    ]; */
    protected $guarded = [];

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class, 'computer_id');
    }

    public function logs()
    {
        return $this->hasMany(ComputerLog::class, 'computer_id');
    }

    public function isActive(){
        /* check if there is a student using this computer */
        /* get attendance logs today */
        $latestAttendanceLog = $this->attendanceLogs()
        ->whereDate('created_at', today())
        ->where('time_out', '=', null)
        ->first();
        if($latestAttendanceLog){
            return true;
        }
        return false;
    }
}
