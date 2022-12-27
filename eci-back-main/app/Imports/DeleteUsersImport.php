<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeleteUsersImport implements ToModel, WithHeadingRow {
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row) {
        if (strlen($row['email'])) {
            User::where('email', $row['email'])->delete();
        } elseif (strlen($row['dni'])) {
            User::where('dni', $row['dni'])->delete();
        }
    }
}
