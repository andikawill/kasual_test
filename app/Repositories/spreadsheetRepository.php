<?php

namespace App\Repositories;

use App\Models\spreadsheet;
use App\Repositories\BaseRepository;

/**
 * Class spreadsheetRepository
 * @package App\Repositories
 * @version November 21, 2021, 10:24 am UTC
*/

class spreadsheetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        '[first_name,',
        '[last_name,',
        '[gender,',
        '[email,',
        '[ip_address,'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return spreadsheet::class;
    }
}
