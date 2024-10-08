<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Contact;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
        
            if ($request->ajax()) {

                $data = Mission::with('contact')->latest()->get();

                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){

                            $btn = '<a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Details" class="details btn btn-info btn-sm showMission"><i class="fa fa-eye text-white"></i></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Modifier" class="edit btn btn-warning btn-sm editMission"><i class="fa fa-pencil text-white"></i></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Supprimer" class="btn btn-danger btn-sm deleteMission"><i class="fa fa-trash"></i></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Ajouter un district" class="btn btn-dark btn-sm addDistrict"><i class="fa fa-plus text-white"></i></a>';
                            
                            return $btn;
                        })
                        ->editColumn('nomMiss', function($row) {
                            return ucfirst($row->nomMiss);
                        })
                        ->editColumn('adresse', function($row) {
                            return ucfirst($row->contact->adresse);
                        })
                        ->editColumn('email', function($row) {
                            return $row->contact->email;
                        })
                        ->editColumn('telMobile', function($row) {
                            return $row->contact->telMobile;
                        }) ->editColumn('created_at', function($row) {
                            return date('d/m/Y H:i', strtotime($row->created_at));
                        })
                        ->editColumn('updated_at', function($row) {
                            return date('d/m/Y H:i', strtotime($row->updated_at));
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }

            return view('missions.show');
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
        
            $contact = Contact::updateOrCreate([

                'id' => $request->contact_id

            ],

            [
                'adresse' => $request->adresse,
                'email' => $request->email,
                'telMobile' => $request->telMobile,
                'telFixe' => $request->telFixe,
                'BP' => $request->BP,
                'codePost' => $request->codePost,

            ]);
            $mission = Mission::updateOrCreate([

                'id' => $request->mission_id

            ],

            [
                'nomMiss' => $request->nomMiss,

            ]);

            $mission->contact()->associate($contact);

            $mission->save();

            return response()->json(['success'=>'Mission enregistrée avec succès']);
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
            
            $mission = Mission::with('contact')->find($id);
            return response()->json($mission);
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
            
            $mission = Mission::with('contact')->find($id);
            return response()->json($mission);
        }else {
            return redirect('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mission $mission)
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
        
            $mission = Mission::find($id);
            $contact = $mission->contact();
            $mission->delete();
            $contact->delete();
            return response()->json(['success'=>'Mission supprimée avec succès.']);
        }else {
            return redirect('dashboard');
        }
    }

    
     /**
     * Store a newly created resource in storage.
     */
    public function addDistrict($id)
    {
        $currentUser = Auth::user();
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
        
            $mission = Mission::with('contact')->find($id);
            return response()->json($mission);
        }else {
            return redirect('dashboard');
        }
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function storeDistrict(Request $request)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            // dd($request);
            $district = new District(['nomDist' => $request->nomDist]);
 
            $mission = Mission::find($request->mission_id);
            
            $mission->districts()->save($district);

            return response()->json(['success'=>'District enregistré avec succès']);
        }else {
            return redirect('dashboard');
        }
    }
}
