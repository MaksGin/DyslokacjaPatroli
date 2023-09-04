<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patrol;
use App\Http\Controllers\Input;
use Wnikk\LaravelAccessRules\Facades\AccessRules;
use App\Models\Sklad;
use Illuminate\Support\Facades\DB;
use App\Models\Wydzial;
use App\Models\Kryptonim;
use App\Models\Rejon;
use Illuminate\Support\Facades\Auth;

use PDF;
use Carbon\Carbon;
class PatrolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getPatrolsByDate(Request $request)
    {
        $selectedDate = $request->input('selected_date'); //z kalendarza wybieram date i przekazuje do zmiennej $selectedDate


        $currentUser = auth()->user();
        $role = $currentUser->roles()->pluck('name'); //pobieram wszystkie role uzytkownika


        if ($role === 'Koordynator') { //jesli ma role koordynator to wyswietl wsszystko
            $wydzialy = Wydzial::all();

        } else {  //uzytkownik bedzie mial dostep tylko do wydzialow do ktorych zostal przypisany
            $wydzialy = $currentUser->wydzialy;
        }

        $patrols = Patrol::whereDate('data', $selectedDate)->get();

        // Sortujemy dane po godzinie rozpoczęcia
        $sortedPatrols = $patrols->sortBy('g_rozp');
        $patrolSklady = [];
        foreach ($patrols as $patrol) {
            $sklad = Sklad::where('id_patrolu', $patrol->id)->get();
            $patrolSklady[$patrol->id] = $sklad;
        }






        return view('patrols', ['patrols' => $sortedPatrols, 'selectedDate' => $selectedDate, 'wydzialy' => $wydzialy,'patrolSklady' => $patrolSklady]);
    }

    //dodawanie patrolu
    public function create($selectedDate,$id)
    {
        $user = Auth::user();
        $wydzialy = $user->wydzialy()->get();



        return view('create',  ['selectedDate' => $selectedDate, 'wydzialy' => $wydzialy,'id'=>$id]);
    }

    public function edit($id){

        $patrol = Patrol::find($id);
        return view('edit', ['patrol' => $patrol]); //przekazanie danych patrolu do widoku

    }

    public function destroy($id)
    {
        $patrol = Patrol::findOrFail($id);

        $selectedDate = $patrol['data'];

        $currentUser = auth()->user();
        $role = $currentUser->roles()->pluck('name'); //pobieram wszystkie role uzytkownika

        if ($role === 'Koordynator') { //jesli ma role koordynator to wyswietl wsszystko
            $wydzialy = Wydzial::all();

        } else {  //uzytkownik bedzie mial dostep tylko do wydzialow do ktorych zostal przypisany
            $wydzialy = $currentUser->wydzialy;
        }

        $patrol->delete();
        $patrols = Patrol::whereDate('data', $selectedDate)->get();

        $patrolSklady = [];
        foreach ($patrols as $patrol) {
            $sklad = Sklad::where('id_patrolu', $patrol->id)->get();
            $patrolSklady[$patrol->id] = $sklad;
        }
        // Sortujemy dane po godzinie rozpoczęcia
        $sortedPatrols = $patrols->sortBy('g_rozp');

        return view('patrols', ['patrols' => $sortedPatrols,'wydzialy' => $wydzialy,'patrolSklady' => $patrolSklady,'selectedDate'=>$selectedDate])->with('success', 'Patrol usunięty prawidłowo.');

    }


    public function store(Request $request)
    {
        $data = $request->only(['kom', 'data', 'g_rozp', 'g_zak', 'uwagi', 'rejon']);
        $data['user_id'] = auth()->id();

        $data['krypt'] = $request->input('krypt');

        if ($data['krypt']) {


            $kryptonim = Kryptonim::where('nazwa',$data['krypt'])->first();

            if(!$kryptonim){
                $kryptonim = Kryptonim::create([
                    'nazwa' => $data['krypt'],
                    'created_by' => auth()->user()->name,
                ]);
            }

            $data['krypt'] = $kryptonim->nazwa;
        }
        if ($data['rejon']) {


            $rejon = Rejon::where('nazwa',$data['rejon'])->first();

            if(!$rejon){
                $rejon = Rejon::create([
                    'nazwa' => $data['rejon'],
                    'created_by' => auth()->user()->name,
                ]);
            }

            $data['rejon'] = $rejon->nazwa;
        }


        $wydzialId = $request->input('wydzial_id');

        $patrol = Patrol::create($data);

        // przypisz do wydzialu nowo stworzony patrol
        $patrol->wydzialy()->attach($wydzialId);

        $selectedDate = $data['data'];
        $patrols = Patrol::whereDate('data', $selectedDate)->get();

        $patrolSklady = [];
        foreach ($patrols as $patrol) {
            $sklad = Sklad::where('id_patrolu', $patrol->id)->get();
            $patrolSklady[$patrol->id] = $sklad;
        }

        $user = Auth::user();
        $wydzialy = $user->wydzialy()->get(); // wszystkie wydzialy uzytkownika

        // Sortujemy dane po godzinie rozpoczęcia
        $sortedPatrols = $patrols->sortBy('g_rozp');

        // Przekazujemy posortowane dane do widoku
        return view('patrols', [
            'patrols' => $sortedPatrols,
            'wydzialy' => $wydzialy,
            'patrolSklady' => $patrolSklady,
            'selectedDate' => $selectedDate
        ]);
    }


    public function update(Request $request, $id)
    {

    // Walidacja
    $validatedData = $request->validate([

        'data' => 'required|date',
        'g_rozp' => 'required',
        'g_zak' => 'required',
        'uwagi' => 'required',
        'rejon' => 'required',
        'krypt' => 'required',
    ]);


    $currentUser = auth()->user();
        $role = $currentUser->roles()->pluck('name'); //pobieram wszystkie role uzytkownika


        if ($role === 'Koordynator') { //jesli ma role koordynator to wyswietl wsszystko
            $wydzialy = Wydzial::all();

        } else {  //uzytkownik bedzie mial dostep tylko do wydzialow do ktorych zostal przypisany
            $wydzialy = $currentUser->wydzialy;
        }


    //Pobranie patrolu
    $patrol = Patrol::findOrFail($id);

    //$patrol->kom = $validatedData['kom'];
    $patrol->data = $validatedData['data'];
    $patrol->g_rozp = $validatedData['g_rozp'];
    $patrol->g_zak = $validatedData['g_zak'];
    $patrol->uwagi = $validatedData['uwagi'];
    $patrol->rejon = $validatedData['rejon'];
    $patrol->krypt = $validatedData['krypt'];

    // Zapisanie zmian w bazie danych
    //Patrol::save();
    $patrol->update();


    $selectedDate = $patrol['data'];
    $patrols = Patrol::whereDate('data', $selectedDate)->get();


    $patrolSklady = [];
    foreach ($patrols as $patrol) {
        $sklad = Sklad::where('id_patrolu', $patrol->id)->get();
        $patrolSklady[$patrol->id] = $sklad;
    }

    // Sortujemy dane po godzinie rozpoczęcia
    $sortedPatrols = $patrols->sortBy('g_rozp');

    return view('patrols', ['patrols' => $sortedPatrols,'wydzialy' => $wydzialy,'patrolSklady' => $patrolSklady,'selectedDate'=>$selectedDate])->with('success', 'Patrol zaktualizowany prawidłowo.');


    }

    public function showSklad($id)
    {
        try {
            $patrol = Patrol::findOrFail($id);
            $sklad = Sklad::where('id_patrolu', $id)->get();
            $selectedDate = $patrol['data'];
            $patrols = Patrol::whereDate('data', $selectedDate)->get();

            return view('sklad.show', ['patrol' => $patrol, 'sklad' => $sklad, 'selected_date' => $selectedDate]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('sklad.index')->with('error', 'Nie znaleziono składu dla tego patrolu.');
        } catch (\Exception $e) {
            return redirect()->route('sklad.index')->with('error', 'Wystąpił błąd podczas wyświetlania składu.');
        }
    }
    public function showAllSklad($id)
    {
        try {
            $patrol = Patrol::findOrFail($id);
            $sklad = Sklad::where('id_patrolu', $id)->get();
            $selectedDate = $patrol['data'];
            $patrols = Patrol::whereDate('data', $selectedDate)->get();

            return view('sklad.show', ['patrol' => $patrol, 'sklad' => $sklad, 'selected_date' => $selectedDate]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('sklad.index')->with('error', 'Nie znaleziono składu dla tego patrolu.');
        } catch (\Exception $e) {
            return redirect()->route('sklad.index')->with('error', 'Wystąpił błąd podczas wyświetlania składu.');
        }
    }







    public function exportPDF($selectedDate)
    {

        if (empty($selectedDate)) {
            $selectedDate = Carbon::now()->format('d-m-Y');
        }

        $currentUser = auth()->user();
        $role = $currentUser->roles()->pluck('name');

        if ($role === 'Koordynator') {
            $wydzialy = Wydzial::all();
        } else {
            $wydzialy = $currentUser->wydzialy;
        }

        $patrols = Patrol::whereDate('data', $selectedDate)->get();



        //dd($brakSkladu);





        $tableData = [
            'patrols' => $patrols,
            'selectedDate' => $selectedDate,
            'wydzialy' => $wydzialy,

        ];



        $pdf = PDF::loadView('generujPDF', $tableData);

        // Pobierz PDF z danymi tabeli jako plik "patrols.pdf"
        return $pdf->download("patrole z dnia $selectedDate.pdf");

        //return view('generujPDF', ['patrols' => $patrols,'wydzialy' => $wydzialy, 'selectedDate'=> $selectedDate]);
    }

}
