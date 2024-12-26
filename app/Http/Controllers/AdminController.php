<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Poste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function go_login(){
        return view('login_admin');
    }

    public function go_register(){
        $liste = Poste::all();
        return view('register_admin', compact('liste'));
    }

    public function get_ModifPage(){
        return view('modif_pass');
    }

    public function get_Next_Page(Request $request){
        $email = $request->input('email');
        return view('next_pass', compact('email'));
    }

    public function get_admin(Request $request){
        $admin = true;
        $employes = false;
        $technicien = false;
        $email = $request->input('email');
        $pass = $request->input('pass');
        $admin = DB::select("select * from utilisateur where email = '$email' and mot_de_passe = '$pass'");
        Session::put('adminstrateur',$admin);
        Session::put('technicient', $technicien);
        Session::put('employes', $employes);
        if($admin){
            return redirect()->route('acceuil_admin');
        }else{
            return redirect()->back()->with('error','Email ou mot de passe incorrecte');
        }
        
    }

    public function modifier_password(Request $request){
        $email = $request->input('email');
        $pass = $request->input('pass');
        $admin = DB::select("select * from utilisateur where email = '$email' limit 1");
        foreach($admin as $user){
            $update = "update utilisateur set mot_de_passe = '$pass' where id = '$user->id'";
            DB::update($update);
        }
        return redirect()->route('login')->with('success', 'Mot de passe modifié ✅');
    }

    public function insert_admin(Request $request){
        $nom = $request->input('nom');
        $email = $request->input('email');
        $pass = $request->input('pass');
        $role = $request->input('role');
        $id = (new Utilisateur())->createId();
        $admin = Utilisateur::create([
            'id' => $id,
            'nom'=>$nom,
            'email'=>$email,
            'mot_de_passe'=>$pass,
            'role' => $role,
            'date_creation' => Carbon::now()
        ]);
        return redirect()->route('login');
    }

    public function logout(Request $request){
        $request->session()->forget('admin');
        return redirect()->route('login');
    }
}
