<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatespreadsheetAPIRequest;
use App\Http\Requests\API\UpdatespreadsheetAPIRequest;
use App\Models\spreadsheet;
use App\Repositories\spreadsheetRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class spreadsheetController
 * @package App\Http\Controllers\API
 */

class spreadsheetAPIController extends AppBaseController
{
    /** @var  spreadsheetRepository */
    private $spreadsheetRepository;

    public function __construct(spreadsheetRepository $spreadsheetRepo)
    {
        $this->spreadsheetRepository = $spreadsheetRepo;
    }

    /**
     * Display a listing of the spreadsheet.
     * GET|HEAD /spreadsheets
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $spreadsheets = $this->spreadsheetRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($spreadsheets->toArray(), 'Spreadsheets retrieved successfully');
    }

    /**
     * Store a newly created spreadsheet in storage.
     * POST /spreadsheets
     *
     * @param CreatespreadsheetAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatespreadsheetAPIRequest $request)
    {
        $input = $request->all();

        $spreadsheet = $this->spreadsheetRepository->create($input);

        return $this->sendResponse($spreadsheet->toArray(), 'Spreadsheet saved successfully');
    }

    /**
     * Display the specified spreadsheet.
     * GET|HEAD /spreadsheets/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var spreadsheet $spreadsheet */
        $spreadsheet = $this->spreadsheetRepository->find($id);

        if (empty($spreadsheet)) {
            return $this->sendError('Spreadsheet not found');
        }

        return $this->sendResponse($spreadsheet->toArray(), 'Spreadsheet retrieved successfully');
    }

    /**
     * Update the specified spreadsheet in storage.
     * PUT/PATCH /spreadsheets/{id}
     *
     * @param int $id
     * @param UpdatespreadsheetAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatespreadsheetAPIRequest $request)
    {
        $input = $request->all();

        /** @var spreadsheet $spreadsheet */
        $spreadsheet = $this->spreadsheetRepository->find($id);

        if (empty($spreadsheet)) {
            return $this->sendError('Spreadsheet not found');
        }

        $spreadsheet = $this->spreadsheetRepository->update($input, $id);

        return $this->sendResponse($spreadsheet->toArray(), 'spreadsheet updated successfully');
    }

    /**
     * Remove the specified spreadsheet from storage.
     * DELETE /spreadsheets/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var spreadsheet $spreadsheet */
        $spreadsheet = $this->spreadsheetRepository->find($id);

        if (empty($spreadsheet)) {
            return $this->sendError('Spreadsheet not found');
        }

        $spreadsheet->delete();

        return $this->sendSuccess('Spreadsheet deleted successfully');
    }
}
