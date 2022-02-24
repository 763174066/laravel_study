<?php

namespace App\Imports;

use App\Models\ExpressCom;
use Maatwebsite\Excel\Concerns\ToModel;

class ExpressComImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ExpressCom([
            //
            'name' => $row[0],
            'com' => $row[1],
        ]);
    }
}
