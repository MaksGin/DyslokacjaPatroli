<?php

namespace App\Http\Controllers;
use stdClass;
use Illuminate\Http\Request;
use App\Models\Patrol;
use App\Models\Sklad;
use App\Models\Kryptonim;
use App\Models\KryptSklad;
class SkladController extends Controller
{
    //dodawanie patrolu
    public function create($patrol_id = null)
    {
        $patrol = null;

        if ($patrol_id) {
            $patrol = Patrol::find($patrol_id);
        }

        return view('sklad.create', compact('patrol'));
    }

    public function store(Request $request)
    {
        //walidacja
        $validatedData = $request->validate([
            'patrol_id' => 'required',
            'imie' => 'required',
            'nazwisko' => 'required',
        ]);

        // Pobranie identyfikatora patrolu
        $patrol_id = $validatedData['patrol_id'];

        //nowy obiekt sklad wypełniamy go danymi z formularza
        $sklad = new Sklad();
        $sklad->id_patrolu = $patrol_id;
        $sklad->imie = $validatedData['imie'];
        $sklad->nazwisko = $validatedData['nazwisko'];
        $sklad->save();

        return redirect('/patrol/' . $patrol_id . '/sklad')->with('success', 'Osoba została dodana do składu.');
    }

    public function destroy($id) {

        $sklad = Sklad::findOrFail($id);
        $patrol_id = $sklad->id_patrolu; // Pobieramy identyfikator patrolu przed usunięciem rekordu
        $sklad->delete();

        return redirect('/patrol/' . $patrol_id . '/sklad')->with('success', 'Osoba została usunięta ze składu.');
    }


    public function destroy1($id,$selectedDate)
    {
        $sklad = Sklad::findOrFail($id);
        $patrol_id = $sklad->id_patrolu;

        $sklad->delete();


        $currentUser = auth()->user();
        $role = $currentUser->roles()->pluck('name'); //pobieram wszystkie role uzytkownika


        if ($role === 'Koordynator') { //jesli ma role koordynator to wyswietl wsszystko
            $wydzialy = Wydzial::all();

        } else {  //uzytkownik bedzie mial dostep tylko do wydzialow do ktorych zostal przypisany
            $wydzialy = $currentUser->wydzialy;
        }

        $patrols = Patrol::whereDate('data', $selectedDate)->get();

        $patrolSklady = [];
        foreach ($patrols as $patrol) {
            $sklad = Sklad::where('id_patrolu', $patrol->id)->get();
            $patrolSklady[$patrol->id] = $sklad;
        }


        $sortedPatrols = $patrols->sortBy('g_rozp');
        return view('patrols', ['patrols' => $sortedPatrols,'wydzialy' => $wydzialy,'patrolSklady' => $patrolSklady,'selectedDate'=>$selectedDate])->with('success', 'Członek patrolu usunięty prawidłowo.');

    }

    public function edit($id)
    {

        $sklad = Sklad::findOrFail($id);
        $patrol = Patrol::findOrFail($sklad->id_patrolu); // Pobranie obiektu Patrol

        return view('sklad.edit', ['sklad' => $sklad, 'patrol' => $patrol]); // Przekazanie danych członka patrolu i patrolu do widoku

    }

    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'patrol_id' => 'required',
            'imie' => 'required',
            'nazwisko' => 'required',
        ]);


        $patrol_id = $validatedData['patrol_id'];


        $sklad = Sklad::where('id_patrolu', $patrol_id)->first();


        if (!$sklad) {
            return redirect()->route('sklad.show', ['id' => $patrol_id])->with('error', 'Nie znaleziono członka patrolu.');
        }


        $sklad->imie = $validatedData['imie'];
        $sklad->nazwisko = $validatedData['nazwisko'];
        $sklad->save();

        return redirect('/patrol/' . $patrol_id . '/sklad')->with('success', 'Osoba została usunięta ze składu.');
    }

    public function showSklady(){

        $kryptSklads = KryptSklad::all();
        $sklads = Sklad::all();

        return view('sklad.przypiszKrypt',compact('sklads','kryptSklads'));
    }

    public function storeKrypt(Request $request)
    {
        $request->validate([
            'osoba' => 'required|exists:sklads,id',
            'kryptonim' => 'required|string|max:255',
        ]);


        $kryptonim = Kryptonim::create([
            'nazwa' => $request->input('kryptonim'),
            'created_by' => auth()->user()->name,
        ]);

        // Pobranie wybranej osoby ze składu
        $osoba = Sklad::find($request->input('osoba'));

        // Utworzenie nowego rekordu w tabeli krypt_sklad i powiązanie z kryptonimem i osobą ze składu
        KryptSklad::create([
            'krypt_id' => $kryptonim->id,
            'sklad_id' => $osoba->id,
        ]);

        // Powrót do odpowiedniego widoku po pomyślnym zapisaniu
        return redirect()->back()->with('success', 'Kryptonim został zapisany!');
    }





}
