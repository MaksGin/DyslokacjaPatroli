<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wydzial;
use App\Models\Sklad;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
class WydzialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wydzialy = Wydzial::all();
        return view('wydzial.index', compact('wydzialy'));
    }

    public function edit($id)
    {
        $wydzial = Wydzial::findOrFail($id);
        $wydzialy = Wydzial::all();
        $users = User::all();
        
        return view('wydzial.edit', compact('wydzial', 'wydzialy', 'users'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nazwa' => 'required',
        ]);

        $wydzial = Wydzial::findOrFail($id);
        $wydzial->nazwa = $validatedData['nazwa'];
        $wydzial->save();

        $userId = $request->input('user');

        if ($userId) {
            $wydzial->users()->syncWithoutDetaching([$userId]);
        }

        return redirect('/wydzial')->with('success', 'Wydział zaktualizowany pomyślnie.');
    }


    
    
    
    public function destroy($id)
    {
        $wydzial = Wydzial::findOrFail($id);
        
        $wydzial->delete();
        return redirect()->route('wydzial.index')->with('success', 'Wydzial usunięty pomyślnie');
    }

    //dodawanie patrolu
    public function create()
    {
        return view('wydzial.create');
    }

    public function store(Request $request)
    {
    
        $validatedData = $request->validate([
            'nazwa' => 'required',
        ]);

        
        $wydzial = new Wydzial();
        $wydzial->nazwa = $validatedData['nazwa'];
        $wydzial->save();

        // Przekierowanie z powrotem na listę wydziałów
        return redirect('/wydzial')->with('success', 'Wydział stworzony pomyślnie.');
    }

    /*
    public function sklad($id)
    {
        $wydzial = Wydzial::findOrFail($id);
        // Pobierz ID ról o podanych nazwach
        $roleIds = Role::whereIn('name', ['Koordynator', 'KoordynatorWPI', 'KoordynatorWRD'])->pluck('id');

        //$users = DB::select('select users.name as name, users.id as id from users, user_wydzial, roles, wydzialy where users.id=user_wydzial.user_id and user_wydzial.wydzial_id=wydzialy.id and user_wydzial.wydzial_id=roles.id and wydzialy.id='.+$id);
        return view('wydzial.sklad', compact('wydzial', 'users'));
    }
*/
    public function sklad($id)
    {
        $wydzial = Wydzial::findOrFail($id);
        $usersRoles = $wydzial->users()->with('roles')->get();
        // Pobierz ID ról o podanych nazwach
        $roleIds = Role::whereIn('name', ['Koordynator', 'KoordynatorWPI', 'KoordynatorWRD','KoordynatorRD','KoordynatorWK','KoordynatorWP',
        'KoordynatorKPP'])->pluck('id');

        $users = User::whereHas('roles', function ($query) use ($roleIds) {
            $query->whereIn('roles.id', $roleIds);
        })
        ->whereHas('wydzialy', function ($query) use ($id) {
            $query->where('wydzialy.id', $id);
        })
        ->get(['users.id', 'users.name']);

        return view('wydzial.sklad', compact('wydzial', 'users','usersRoles'));
    }

    public function userWydzial(Request $request, $id)
    {
        $wydzial = Wydzial::findOrFail($id);
        $userId = $request->input('user');

        if ($userId) {
            $user = User::findOrFail($userId);
            $wydzial->users()->syncWithoutDetaching([$user->id]);
        }
        $wydzial_id = $wydzial->id; // Przypisanie wartości wydzial_id

        return redirect('/wydzial/'. $wydzial_id .'/sklad')->with('success', 'Przypisanie użytkownika do wydziału zostało zaktualizowane.');
       
    }

  

    


}
