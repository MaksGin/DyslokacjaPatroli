<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kryptonim;
class KryptonimController extends Controller
{
    public function autocomplete1(Request $request)
    {
        $query = $request->get('term', '');

        $kryptonims = Kryptonim::where('nazwa', 'LIKE', '%' . $query . '%')->get();

        $data = [];
        foreach ($kryptonims as $kryptonim) {
            $data[] = [
                'id' => $kryptonim->id,
                'value' => $kryptonim->nazwa,
            ];
        }

        return response()->json($data);
    }
}
