<?php

namespace App\Http\Controllers;

use App\Models\Releve;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function getHours($date)
    {
        # code...

        $users = User::where("role", 1)->get();
        $mois = date("m", strtotime($date));
        $year = date("Y", strtotime($date));
        $data = [];

        foreach ($users as $user) {
            $duration = 0;
            $hours = 0;
            $minutes = 0;
            $rels = Releve::where('user_id', $user->id)
                ->whereMonth('date_systeme', $mois)
                ->whereYear('date_systeme', $year)
                ->get();
            if ($rels->count() > 0) {
                foreach ($rels as $r) {
                    $start = Carbon::parse($r->heure_d);
                    $end = Carbon::parse($r->heure_f);
                    $duration += $end->diffInMinutes($start);
                    $hours = floor($duration / 60);
                    $minutes = $duration - $hours * 60;
                }
            }
            array_push($data, ["nom" => $user->nom, "heures" => $hours . " heures et " . $minutes . " minutes"]);
        }
        return json_encode($data);
    }

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
        return redirect()->to("/login");
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
            $data["plainTextPassword"] = $req->password;
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
    public function edit(Request $req, $id)
    {
        try {
            // $customMessages = [
            //     'required' => 'Ce champ est requis.',
            //     'unique' => "Ce :attribute est déjà utilisé.",
            //     'min' => 'Le mot de passe doit comporter au moins :min caractères.',
            // ];
            // $data = $req->all();

            // $validate = Validator::make($req->all(), [
            //     'login' => "bail|required|unique:users",
            //     'password' => 'bail|min:8|required',
            //     'code' => 'bail|required|unique:users',
            // ], $customMessages);
            // if ($validate->fails()) {
            //     return   response(json_encode(["type" => "error", "message" => $validate->errors()]), 500);
            // }
            $user = User::find($id);
            $loginExists = User::where("login", $req->login)->where("id", "!=", $id)->first();
            if ($loginExists) {
                return   response(json_encode(["type" => "error", "message" => ["login" => ["Ce login est déjà utilisé."]]]), 500);
            }

            if ($req->has("password")) {
                $password = Hash::make($req->password);
                $user->password = $password;
                $user->plainTextPassword = $req->password;
            }
            $user->nom = $req->nom;
            $user->login = $req->login;
            $user->save();
            return response(json_encode(["type" => "success", "message" => "L'utilisateur est bien modifié"]), 201);
        } catch (\Throwable $th) {
            return response(json_encode(["type" => "error", "message" => $th->getMessage()]), 500);
        }
    }
    public function show($id)
    {
        # code...
        try {
            $user = User::find($id);

            return view("dashboard.pages.user.edit", ["user" => $user]);
        } catch (\Throwable $th) {
            return response(json_encode(["type" => "error", "message" => $th->getMessage()]), 500);
        }
    }
    public function destory($id)
    {
        # code...
        try {
            $user = User::find($id);
            $user->delete();
            return response(json_encode(["type" => "success", "message" => "Bien supprimé"]), 200);
        } catch (\Throwable $th) {
            return response(json_encode(["type" => "error", "message" => $th->getMessage()]), 500);
        }
    }

    public function rapports()
    {
        # code...
        $releves = Releve::where("user_id", Auth::user()->id)->orderBy("date_systeme", "desc")->orderBy("heure_d", "asc")->get();
        return view("dashboard.pages.caissier.releve", ["releves" => $releves]);
    }

    public function hours()
    {
        # code...
        $users = User::where("role", 1)->get();
        return view("dashboard.pages.user.hours", ["users" => $users]);
    }
}
