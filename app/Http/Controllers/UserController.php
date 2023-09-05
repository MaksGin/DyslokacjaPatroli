<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use App\Models\Wydzial;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(20);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 20);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required|array',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        // Przypisanie ról do użytkownika
        $user->assignRole($request->input('roles'));

        // słownik
        $roleToWydzialMap = [

            'KoordynatorWPI' => 'Wydział Patrolowo Interwencyjny',
            'KoordynatorRuchuD' => 'Wydział Ruchu Drogowego',
            'KoordynatorRD' => 'Rewir Dzielnicowych',
            'KoordynatorWK' => 'Wydział Kryminalny',
            'KoordynatorWP' => 'Wydział Prewencji',
            'KoordynatorKPP' => 'Kierownictwo KPP Jarosław',
            'KoordynatorKPW' => 'Posterunek Policji w Wiązownicy',
            'KoordynatorRadymno' => 'Komisariat Policji w Radymnie',
            'KoordynatorPruchnik' => 'Posterunek Policji w Pruchniku',
            'KoordynatorPG' => 'Wydział dw. z Przestępczością Gospodarczą',
            'Komendant' => 'wszystkieWydzialy',
        ];



        foreach ($request->input('roles', []) as $roleName) {

            if (isset($roleToWydzialMap[$roleName])) { //sprawdzenie czy dla danej roli istnieje przypisane w słowniku
                $wydzialNazwa = $roleToWydzialMap[$roleName];

                //jesli nazwa wydzialu jest pusta to znaczy ze dodalem komendanta, przypisz mu wszystkie wydzialy
                if ($roleName  === 'Komendant') {

                    $wydzialy = Wydzial::all();
                    $wydzialyIds = $wydzialy->pluck('id')->toArray();
                    foreach ($wydzialyIds as $wydzial) {
                        $user->wydzialy()->attach($wydzial);
                    }



                } else {
                    $wydzial = Wydzial::where('nazwa', $wydzialNazwa)->first();
                    if ($wydzial) {
                        $user->wydzialy()->attach($wydzial); //przypisuje uzytk do wydzialu w tabeli user_wydzial na podstawie roli
                    }
                }
            }
        }

        return redirect()->route('users.index')
                        ->with('success', 'User created successfully');
    }



    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }


    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();



        return view('users.edit', compact('user', 'roles', 'userRole'));
    }



    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required|array',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $user = User::find($id);

        //wyczysci wszystkie role uzytkownika
        $user->roles()->detach();

        $user->assignRole($request->input('roles'));
        //cysci wszystkie przypisania w tablicy user_wydzialy dla ID usera edytowanego
        $user->wydzialy()->detach();
        // słownik
        $roleToWydzialMap = [

            'KoordynatorWPI' => 'Wydział Patrolowo Interwencyjny',
            'KoordynatorWRD' => 'Wydział Ruchu Drogowego',
            'KoordynatorRD' => 'Rewir Dzielnicowych',
            'KoordynatorWK' => 'Wydział Kryminalny',
            'KoordynatorWP' => 'Wydział Prewencji',
            'KoordynatorKPP' => 'Kierownictwo KPP Jarosław',
            'KoordynatorKPW' => 'Posterunek Policji w Wiązownicy',
            'KoordynatorRadymno' => 'Komisariat Policji w Radymnie',
            'KoordynatorPruchnik' => 'Posterunek Policji w Pruchniku',
            'KoordynatorPG' => 'Wydział dw. z Przestępczością Gospodarczą',
            'Komendant' => null,
        ];


        foreach ($request->input('roles', []) as $roleName) {
            if (isset($roleToWydzialMap[$roleName])) { //sprawdzenie czy dla danej roli istnieje przypisane w słowniku
                $wydzialNazwa = $roleToWydzialMap[$roleName];
                //jesli nazwa wydzialu jest pusta to znaczy ze dodalem komendanta, przypisz mu wszystkie wydzialy
                if ($wydzialNazwa === null) {

                    $wydzialy = Wydzial::all();
                    $user->wydzialy()->attach($wydzialy);
                } else {
                    $wydzial = Wydzial::where('nazwa', $wydzialNazwa)->first();
                    if ($wydzial) {
                        $user->wydzialy()->attach($wydzial); //przypisuje uzytk do wydzialu w tabeli user_wydzial na podstawie roli
                    }
                }
            }

        }




        return redirect()->route('users.index')
                        ->with('success', 'Użytkownik zaktualizowany pomyślnie');
    }




    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','Użytkownik usunięty pomyślnie');
    }
}
