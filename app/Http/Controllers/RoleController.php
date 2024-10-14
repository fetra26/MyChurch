<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            if ($request->ajax()) {
    
                $data = Role::latest()->get();
    
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
    
                               $btn = '<a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Modifier" class="edit btn btn-warning btn-sm editRole"><i class="fa fa-pencil text-white"></i></a>';
    
                               $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Supprimer" class="btn btn-danger btn-sm deleteRole"><i class="fa fa-trash"></i></a>';
    
                                return $btn;
                        })
                        ->editColumn('libelleRole', function($row) {
                            return ucfirst($row->libelleRole);
                        }) ->editColumn('created_at', function($row) {
                            return date('d/m/Y H:i', strtotime($row->created_at));
                        })
                        ->editColumn('updated_at', function($row) {
                            return date('d/m/Y H:i', strtotime($row->updated_at));
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
            return view('roles.show');
        }else {
            return redirect('dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            Role::updateOrCreate([

                        'id' => $request->role_id

                    ],

                    [

                        'libelleRole' => $request->libelleRole

                    ]);



            return response()->json(['success'=>'Role enregistré avec succès']);
            
        }else {
            return redirect('dashboard');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {

        }else {
            return redirect('dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $currentUser = Auth::user();
        
            if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            $role = Role::find($id);

            return response()->json($role);
        
        }else {
            return redirect('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $currentUser = Auth::user();
            
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
        Role::find($id)->delete();
        return response()->json(['success'=>'Role supprimé avec succès.']);
        
    }else {
        return redirect('dashboard');
    }
    }
}
