<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rejon;
class RejonController extends Controller
{
    public function autocompleteRejon(Request $request)
    {
        $query = $request->get('term', '');

        $rejons = Rejon::where('nazwa', 'LIKE', '%' . $query . '%')->get();

        $data = [];
        foreach ($rejons as $rejon) {
            $data[] = [
                'id' => $rejon->id,
                'value' => $rejon->nazwa,
            ];
        }

        return response()->json($data);
    }

    public function index(){


        $rejony = Rejon::all();
        return view('Rejony.index',compact('rejony'));

    }

    public function store(Request $request){

        $data = $request->only(['nazwa']);

        $rejon = Rejon::create($data);


        $rejony = Rejon::all();

        return view('rejony.index',compact('rejony'));

    }

    public function destroy($id){

        $rejonToDelete = Rejon::find($id);

        $rejonToDelete->delete();

        return redirect()->route('rejony.index');

    }

    public function edit($id){

        $rejonToEdit = Rejon::find($id);

        return view('rejony.edit',compact('rejonToEdit'));
    }

    public function update(Request $request, $id){

        $validatedData = $request->validate([
            'nazwa' => 'required'
        ]);

        $rejon = Rejon::findorFail($id);

        $rejon->nazwa = $validatedData['nazwa'];
        $rejon->update();

        $rejony = Rejon::all();

        return view('rejony.index',compact('rejony'));
    }

}
