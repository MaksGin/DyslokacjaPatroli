<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Http\Request;
use League\Csv\Reader;
use App\Imports\PatrolsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Patrol;
use App\Models\Wydzial;
use App\Models\Sklad;
use Illuminate\Support\Facades\Auth;
class ExcelCSVController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function index($selectedDate,$id)
    {

       return view('import.excel-csv-import',['selectedDate' => $selectedDate,'id'=>$id]);
    }

    public function importCSVToDatabase($filePath,$selectedDate,$id)
    {
        $wydzialID = $id;


        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $user = Auth::user();
        $userID = $user->id;

        foreach ($csv->getRecords() as $record) {

            $czasPoczatkuSluzby = $record['Planowany czas początku służby'];
            $czasCzesci = explode(' ', $czasPoczatkuSluzby);
            $godzinaRozp = $czasCzesci[1];
            $datarozp = $czasCzesci[0];

            $czasKoncaSluzby = $record['Planowany czas końca służby'];
            $czaskon = explode(' ', $czasKoncaSluzby);
            $godzinaZak = $czaskon[1];

            //pobranie wydzialu z pliku csv
            $wydzial = $record['Jednostka wystawiająca'];




            $patrol = new Patrol;
            $patrol->kom = $wydzial;
            $patrol->data = $datarozp;
            $patrol->g_rozp = $godzinaRozp;
            $patrol->g_zak = $godzinaZak;
            $patrol->uwagi = $record['Wyposażenie'];
            $patrol->rejon = $record['Rejony'];
            $patrol->user_id = $userID;
            $patrol->krypt = $record['Kryptonim'];
            $patrol->save();

            $wydzialObj = Wydzial::where('nazwa', $wydzial)->first();

            //id stworzonego patrolu
            $patrolID = $patrol->id;

            // sklad z pliku csv
            $skladCSV = $record['Skład'];

            //zapis do bazy skladu
            $sklad = new Sklad();
            $sklad->id_patrolu = $patrolID;
            $sklad->nazwisko = $skladCSV;
            $sklad->imie = $skladCSV;
            $sklad->save();






            $patrol->wydzialy()->attach($wydzialID);




        }
        return redirect('excel-csv-file/{selectedDate}/{id}')->with('status', 'The file has been imported to the database.');
    }


    public function importExcelCSV(Request $request,$selectedDate,$id)
    {

        $validatedData = $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $filePath = $file->getPathname();

        // Wywołujemy funkcję importującą dane do bazy danych
        $this->importCSVToDatabase($filePath,$selectedDate,$id);

        return redirect('excel-csv-file/{selectedDate}/{id}')->with('status', 'The file has been imported to the database.');
    }


}




