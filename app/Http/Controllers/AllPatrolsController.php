<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Patrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//biblioteka Carbon do pracy z datami
class AllPatrolsController extends Controller
{
    public function index(Request $request)
    {
        $days = $request->input('days', 3);
        $startDate = Carbon::today(); //pobieram aktualna date
        $endDate = Carbon::today()->addDays($days); //dodajemy do bieżącej daty liczbę wpisana w zmiennej $days

        $patrols = Patrol::whereBetween('data', [$startDate, $endDate])
                        ->orderBy('data', 'asc') //sortowanie rosnąco po dacie
                        ->get();



        return view('allPatrols', compact('patrols', 'startDate'));
    }


}






