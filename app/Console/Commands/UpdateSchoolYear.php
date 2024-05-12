<?php

namespace App\Console\Commands;

use App\Models\SchoolYear;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateSchoolYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:school-year';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update School Year';

    /**
     * Execute the console command.
     */




    public function handle()
    {
        $currentDate = Carbon::now();

        // Get the current school year with its associated semester
        $currentSchoolYear = SchoolYear::where('is_active', true)->with('semester')->first();

        // Check if the current date is not within the start and end dates of the current school year
        if (!$currentDate->between($currentSchoolYear->start_date, $currentSchoolYear->end_date)) {
            // Update the active school year
            $newSchoolYear = SchoolYear::where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->orderBy('start_date', 'asc')
                ->first();

            // Set the new school year as active
            $newSchoolYear->update(['is_active' => true]);

            // Update the current semester based on the new school year
            $currentSchoolYear = $newSchoolYear;
        }

        // Get the current semester associated with the current school year
        $currentSemester = $currentSchoolYear->semester;

        // Check if the current date is not within the start and end dates of the current semester
        if (!$currentDate->between($currentSemester->start_date, $currentSemester->end_date)) {
            // Update the current semester
            // Update the current semester
            $newSemester = Semester::where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->orderBy('start_date', 'asc')
                ->first();


            // Update the current semester in the active school year
            $currentSchoolYear->update(['semester_id' => $newSemester->id]);

            // Update the current semester object
            $currentSemester = $newSemester;
        }

        // Output or log the updated school year and semester
        $this->info('Updated school year: ' . $currentSchoolYear->name);
        $this->info('Updated semester: ' . $currentSemester->name);
    }
}
