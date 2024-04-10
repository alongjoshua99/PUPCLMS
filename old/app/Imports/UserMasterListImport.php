<?php
namespace App\Imports;

use App\Models\UserMasterList;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserMasterListImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validate the row data
        Validator::make($row, [
            'user_master_id' => [
                'required',
                Rule::unique('user_master_lists', 'user_master_id'), // Assuming your table is named 'user_master_lists'
                // Add other validation rules as needed
            ],
            // Add validation for other columns
        ])->validate();

        // Create a new UserMasterList model
        return new UserMasterList([
            'user_master_id' => $row['user_master_id'],
            // Add other columns as needed
        ]);
    }
}

?>