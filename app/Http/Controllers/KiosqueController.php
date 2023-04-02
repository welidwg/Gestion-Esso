<?php

namespace App\Http\Controllers;

use App\Models\Kiosque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KiosqueController extends Controller
{
    //
    public function store(Request $req)
    {
        # code...
        try {
            $data = $req->all();
            $data["date_d"] = date("Y-m-d H:i", strtotime($data["date_d"]));
            $data["date_f"] = date("Y-m-d H:i", strtotime($data["date_f"]));
            $data["date_today"] = date("Y-m-d");
            $data["user_id"] = Auth::user()->id;
            Kiosque::create($data);
            return response(json_encode(["type" => "success", "message" => "Operation bien effectuée."]), 201);
        } catch (\Throwable $th) {
            return response(json_encode(["type" => "error", "message" => $th->getMessage()]), 500);
        }
    }
}
