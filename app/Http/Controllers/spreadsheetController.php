<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatespreadsheetRequest;
use App\Http\Requests\UpdatespreadsheetRequest;
use App\Repositories\spreadsheetRepository;
use App\Http\Controllers\AppBaseController;
use Revolution\Google\Sheets\Facades\Sheets;
use Google_Client;
use Illuminate\Http\Request;
use Flash;
use Response;

class spreadsheetController extends AppBaseController
{
    /** @var  spreadsheetRepository */
    private $spreadsheetRepository;

    public function __construct(spreadsheetRepository $spreadsheetRepo)
    {
        $this->spreadsheetRepository = $spreadsheetRepo;
    }

    /**
     * Display a listing of the spreadsheet.
     *
     * @param Request $request
     *
     * @return Response
     */

     public function get_acceess_token(){
        $client = new \Google_Client();
        $client->setAuthConfig(config("google.service.file"));
        $client->setClientId(config("google.client_id"));
        $client->setClientSecret(config("google.client_secret"));
        $client->refreshToken(config("google.refreshToken"));
        $client->fetchAccessTokenWithRefreshToken(config("google.refreshToken"));

        return $client;
     }
     public function get_range($id)
     {
        $sheets = Sheets::spreadsheet(config("google.spreadsheet_id"))
        ->sheet(config("google.sheet_id"))
        ->get();
        $header = $sheets->pull(0);
        $posts = Sheets::collection($header, $sheets);
        $spreadsheet = $posts->all();
        $i = 1;
        foreach($spreadsheet as $key){
            $i++;
            if($key['id'] == $id){
                break;
            }
        }
        return $i;
     }

    public function index(Request $request)
    {
        // $spreadsheets = $this->spreadsheetRepository->all();
        $sheets = Sheets::spreadsheet(config("google.spreadsheet_id"))
        ->sheet(config("google.sheet_id"))
        ->get();
        $header = $sheets->pull(0);
        $posts = Sheets::collection($header, $sheets);
        $spreadsheets = $posts->sortBy("id")->all();


        return view('spreadsheets.index')
            ->with('spreadsheets', $spreadsheets);
    }

    /**
     * Show the form for creating a new spreadsheet.
     *
     * @return Response
     */
    public function create()
    {
        $data['gender'] = [
            "Male" => "Male",
            "Female" => "Female",
            "Female" => "Female",
            "Genderfluid" => "Genderfluid",
            "Bigender" => "Bigender",
            "Polygender" => "Polygender",
            "Agender" => "Agender",
            "Non-binary" => "Non-binary",
        ];

        return view('spreadsheets.create')->with('data', $data);
    }

    /**
     * Store a newly created spreadsheet in storage.
     *
     * @param CreatespreadsheetRequest $request
     *
     * @return Response
     */
    public function store(CreatespreadsheetRequest $request)
    {
        // $input = $request->all();

        $sheets = Sheets::spreadsheet(config("google.spreadsheet_id"))
        ->sheet(config("google.sheet_id"))
        ->get();
        $header = $sheets->pull(0);
        $posts = Sheets::collection($header, $sheets);
        $spreadsheets = $posts->sortBy("id")->last();

        $token = $this->get_acceess_token();

        $input['id'] = $spreadsheets['id']+1;
        $input['first_name'] = $request['first_name'];
        $input['last_name'] = $request['last_name'];
        $input['email'] = $request['email'];
        $input['gender'] = $request['gender'];
        $input['ip_address'] = $request['ip_address'];

        $create = Sheets::setAccessToken($token->getAccessToken())->sheet(config("google.sheet_id"))->append([$input]);

        if($create){

            Flash::success('Spreadsheet saved successfully.');
        }else{
            Flash::failed('Spreadsheet saved failed.');

        }


        return redirect(route('spreadsheets.index'));
    }

    /**
     * Display the specified spreadsheet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        // $spreadsheet = $this->spreadsheetRepository->find($id);

        $sheets = Sheets::spreadsheet(config("google.spreadsheet_id"))
            ->sheet(config("google.sheet_id"))
            ->get();
        $header = $sheets->pull(0);
        $posts = Sheets::collection($header, $sheets);
        $spreadsheet = $posts->get($id);


        // print_r($range);

        if (empty($spreadsheet)) {
            Flash::error('Spreadsheet not found');

            return redirect(route('spreadsheets.index'));
        }

        return view('spreadsheets.show')->with('spreadsheet', $spreadsheet);
    }

    /**
     * Show the form for editing the specified spreadsheet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $get_range = $this->get_range($id);

        $range = 'A'.$get_range.':'.'F'.$get_range;
        $sheets = Sheets::spreadsheet(config("google.spreadsheet_id"))
            ->sheet(config("google.sheet_id"))
            ->get();
        $header = $sheets->pull(0);
        $posts = Sheets::collection($header, $sheets);
        $data['spreadsheet'] = $posts->get($get_range-1);
        // echo $get_range.' | '.$id;
        // print_r($data['spreadsheet']);exit();

        $data['gender'] = [
            "Male" => "Male",
            "Female" => "Female",
            "Female" => "Female",
            "Genderfluid" => "Genderfluid",
            "Bigender" => "Bigender",
            "Polygender" => "Polygender",
            "Agender" => "Agender",
            "Non-binary" => "Non-binary",
        ];

        if (empty($data['spreadsheet'])) {
            Flash::error('Spreadsheet not found');

            return redirect(route('spreadsheets.index'));
        }

        return view('spreadsheets.edit')->with('data', $data);
    }

    /**
     * Update the specified spreadsheet in storage.
     *
     * @param int $id
     * @param UpdatespreadsheetRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatespreadsheetRequest $request)
    {
        $get_range = $this->get_range($id);

        $range = 'A'.$get_range.':'.'F'.$get_range;
        $sheets = Sheets::spreadsheet(config("google.spreadsheet_id"))
            ->sheet(config("google.sheet_id"))
            ->get();
        $header = $sheets->pull(0);
        $posts = Sheets::collection($header, $sheets);
        $spreadsheet = $posts->get($get_range-1);
        if (empty($spreadsheet)) {
            Flash::error('Spreadsheet not found');

            return redirect(route('spreadsheets.index'));
        }
        $input = [
            (int)$id,
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->gender,
            $request->ip_address
        ];
        // $get_range = $this->get_range($id);

        $range = 'A'.$get_range;
        $token = $this->get_acceess_token();
            $spreadsheet =Sheets::setAccessToken($token->getAccessToken())->sheet(config("google.sheet_id"))->range($range)->update([$input]);

        Flash::success('Spreadsheet updated successfully.');

        return redirect(route('spreadsheets.index'));
    }

    /**
     * Remove the specified spreadsheet from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $get_range = $this->get_range($id);

        $range = 'A'.$get_range.':'.'F'.$get_range;
        $sheets = Sheets::spreadsheet(config("google.spreadsheet_id"))
            ->sheet(config("google.sheet_id"))
            ->get();
        $header = $sheets->pull(0);
        $posts = Sheets::collection($header, $sheets);
        $spreadsheet = $posts->get($get_range-1);
        $token = $this->get_acceess_token();

        if (empty($spreadsheet)) {
                Flash::error('Spreadsheet not found');

                return redirect(route('spreadsheets.index'));
        }
            $input = [
                '',
                '',
                '',
                '',
                '',
                ''
            ];
            $get_range = $this->get_range($id);

            $range = 'A'.$get_range;
            $spreadsheet =Sheets::setAccessToken($token->getAccessToken())->sheet(config("google.sheet_id"))->range($range)->update([$input]);

        Flash::success('Spreadsheet deleted successfully.');

        return redirect(route('spreadsheets.index'));
    }
}
