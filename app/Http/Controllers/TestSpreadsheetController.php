<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;

class TestSpreadsheetController extends Controller
{
    protected $listeners = ["postAdded" => "render"];

    public function index()
    {
        $sheets = Sheets::spreadsheet(config("google.post_spreadsheet_id"))
            ->sheet(config("google.post_sheet_id"))
            ->get();
        $header = $sheets->pull(0);
        $posts = Sheets::collection($header, $sheets);
        $posts = $posts->reverse()->take(10);


        $data["sheet"] = $posts;

        if (!empty($data) && isset($data)) {
            $res["success"] = true;
            $res["message"] = "Berhasil melihat data";
            $res["data"] = $data;
            return response($res);
        } else {
            $res["success"] = false;
            $res["message"] = "Gagal melihat data";
            $res["data"] = [];
            return response($res);
        }

        return view("app", $res);
    }
}
