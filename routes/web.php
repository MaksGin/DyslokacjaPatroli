<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PatrolController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\WydzialController;
use App\Http\Controllers\SkladController;
use App\Http\Controllers\AllPatrolsController;
use App\Http\Controllers\ExcelCSVController;
use App\Http\Controllers\KryptonimController;
use App\Http\Controllers\RejonController;

Auth::routes();

// Main Page
Route::get('/main', function () {
    return view('main');
})->middleware(['auth'])->name('main');


Route::middleware(['auth'])->group(function () {

    //Lista podpowiedzi dla kryptonimów
    Route::get('/autocomplete1', [KryptonimController::class,'autocomplete1'])->name('autocomplete1');

    //Lista podpowiedzi dla rejonów
    Route::get('/autocompleteRejon',[RejonController::class,'autocompleteRejon'])->name('autocompleteRejon');

    //Sklady
    Route::get('/sklady',[SkladController::class,'showSklady'])->name('showSklady');
    Route::post('/savekryptonim',[SkladController::class,'storeKrypt'])->name('storeKrypt');

    //Patrole
    Route::post('/patrols', [PatrolController::class,'getPatrolsByDate'])->name('patrols.getByDate');
    Route::get('/patrols', [PatrolController::class,'getPatrolsByDate'])->name('patrols.getByDate');

    //tworzenie patrolu do konkretnego wydzialu
    Route::get('/patrol/create/{selectedDate}/{id}', [PatrolController::class, 'create'])->name('patrol.create1');

    // Wyświetlanie formularza dodawania patrolu
    Route::get('/patrol/create/{selectedDate}', [PatrolController::class, 'create'])->name('patrol.create');

    // Zapisywanie nowego patrolu
    Route::post('/patrol', [PatrolController::class, 'store'])->name('patrol.store');

    //formularz dodawania wydziału
    Route::get('/wydzial/create', [WydzialController::class, 'create'])->name('wydzial.create');
    Route::post('/wydzial', [WydzialController::class, 'store'])->name('wydzial.store');

    //przejscie do dodawania uzytkownika do wydzialu
    Route::get('/wydzial/{id}/sklad', [WydzialController::class, 'sklad'])->name('wydzial.sklad');


    //Obsługa rejonów
    Route::get('/rejony',[RejonController::class,'index'])->name('rejony.index');
    Route::delete('/rejon/destroy/{id}',[RejonController::class,'destroy'])->name('rejon.destroy');
    Route::get('/rejon/{id}/edit',[RejonController::class,'edit'])->name('rejon.edit');
    Route::patch('/rejon/{id}',[RejonController::class,'update'])->name('rejon.update');
    Route::post('/rejon',[RejonController::class,'store'])->name('rejon.create');

    // Edycja Patrolu
    Route::get('/patrol/{id}/edit', [PatrolController::class, 'edit'])->name('patrol.edit');
    Route::patch('/patrol/{id}', [PatrolController::class, 'update'])->name('patrol.update');

    //Usuwanie patrolu
    Route::delete('/patrol/{id}', [PatrolController::class, 'destroy'])->name('patrol.destroy');
    Route::get('/patrol/{id}', [PatrolController::class, 'destroy'])->name('patrol.destroy');

    //Aktualizacja Wydzialu
    Route::patch('/wydzial/{id}', [WydzialController::class, 'update'])->name('wydzial.update');

    //pokaż skład patrolu
    Route::get('/patrol/{id}/sklad', [PatrolController::class, 'showSklad'])->name('patrol.sklad');

    //pokaz skład w widoku Komendanta
    Route::get('/patrolAll/{id}/sklad', [PatrolController::class, 'showAllSklad'])->name('patrolAll.sklad');

    //Dodaj skład patrolu
    Route::get('/sklad/create/{patrol_id?}', [SkladController::class, 'create'])->name('sklad.create');

    //usun czlonka patrolu
    Route::delete('/sklad/destroy/{patrol_id?}', [SkladController::class, 'destroy'])->name('sklad.destroy');
    Route::delete('/sklad/destroy1/{patrol_id?}/{selectedDate}', [SkladController::class, 'destroy1'])->name('sklad.destroy1');

    //edycja czlonka patrolu
    Route::get('/sklad/{id}/edit',[SkladController::class,'edit'])->name('sklad.edit');
    Route::patch('/sklad/{id}', [SkladController::class, 'update'])->name('sklad.update');

    Route::post('/sklad', [SkladController::class, 'store'])->name('sklad.store');

    //pdf
    //Route::get('/patrols/pdf', [PatrolController::class, 'exportPDF'])->name('patrols.export.pdf');
    Route::get('/patrols/pdf/{selectedDate}', [PatrolController::class, 'exportPDF'])->name('patrols.export.pdf');

    //Przypisanie do wydzialu
    Route::post('/userWydzial/{wydzial}', [WydzialController::class, 'userWydzial'])->name('userWydzial');

    //Widok wszystkich patroli dla komendanta
    Route::get('/all-patrols', [AllPatrolsController::class, 'index'])->middleware(['auth'])->name('allPatrols.index');

    //usuwanie zaznaczonych permisji
    Route::delete('permissions/destroySelected', [PermissionController::class, 'destroySelected'])->name('permissions.destroySelected');

    Route::get('permissions/show2', [PermissionController::class, 'show'])->name('permissions.show2');

    //import csv
    Route::get('excel-csv-file/{selectedDate}/{id}', [ExcelCSVController::class, 'index'])->name('import.excel');
    Route::post('import-excel-csv-file/{selectedDate}/{id}', [ExcelCSVController::class, 'importExcelCSV']);
    Route::get('export-excel-csv-file/{slug}', [ExcelCSVController::class, 'exportExcelCSV']);

});



Route::get('/', function () {
    return view('welcome');
});



//Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');












Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('wydzial', WydzialController::class);
});


