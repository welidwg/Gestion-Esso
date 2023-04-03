<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //

    public function index()
    {
        return view("dashboard.pages.user.index", ["users" => User::where("role", 1)->get()]);
    }
    public function rapport($id)
    {
        return view("dashboard.pages.user.rapport", ["id" => $id]);
    }
    public function auth(Request $req)
    {
        # code...
        try {
            $cred = ["login" => $req->login, "password" => $req->password];
            if (Auth::attempt($cred)) {
                return response(json_encode(["type" => "success", "message" => "Bien connecté", "user" => Auth::user(), "id" => Auth::user()->id]), 200);
            } else {
                return response(json_encode(["type" => "error", "message" => "Login ou mot de passe non valides !"]), 500);
            }
        } catch (\Throwable $th) {
            return response(json_encode(["type" => "error", "message" => $th->getMessage()]), 500);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->to("/");
    }
    public function store(Request $req)
    {
        try {
            $customMessages = [
                'required' => 'Ce champ est requis.',
                'unique' => "Ce :attribute est déjà utilisé.",
                'min' => 'Le mot de passe doit comporter au moins :min caractères.',
            ];

            $password = Hash::make($req->password);
            $data = $req->all();
            $data["password"] = $password;
            $validate = Validator::make($req->all(), [
                'login' => "bail|required|unique:users",
                'password' => 'bail|min:8|required',
                'code' => 'bail|required|unique:users',
            ], $customMessages);
            if ($validate->fails()) {
                return   response(json_encode(["type" => "error", "message" => $validate->errors()]), 500);
            }
            $user = User::create($data);
            return response(json_encode(["type" => "success", "message" => "L'utilisateur est bien ajouté"]), 201);
        } catch (\Throwable $th) {
            return response(json_encode(["type" => "error", "message" => $th->getMessage()]), 500);
        }
    }
}
