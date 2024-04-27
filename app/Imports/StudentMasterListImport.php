<?php

namespace App\Imports;

use App\Models\StudentMasterList;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentMasterListImport implements ToModel, WithValidation
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new StudentMasterList([
            'student_id_number' => $row[0],
            'full_name' => $row[1],
        ]);
    }

    public function rules(): array
    {
        return [
          '0' => ['required', Rule::unique('student_master_lists', 'student_id_number')],
          '1' => ['required'],
        ];
    }
}
