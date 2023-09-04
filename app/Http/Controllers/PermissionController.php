<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
    
class PermissionController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','store']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    public function create()
    {
        $permission = Permission::get();
        return view('permissions.create',compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            
        ]);
    
        $role = Permission::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Permisja dodana prawidłowo');
    }
    public function index(){
        return view('permissions.index');
    }

    public function show()
    {
        $permissions = Permission::all();
    
        return view('permissions.show', compact('permissions'));
    }
    

    public function destroySelected(Request $request)
    {
        $selectedPermissions = $request->input('selectedPermissions', []);

        // Usuń zaznaczone uprawnienia
        Permission::whereIn('id', $selectedPermissions)->delete();

        return redirect()->back()->with('success', 'Zaznaczone uprawnienia zostały usunięte.');
    }

    
}
