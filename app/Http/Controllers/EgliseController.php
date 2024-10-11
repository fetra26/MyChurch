<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\District;
use App\Models\Eglise;
use App\Models\Membre;
use App\Models\Status;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class EgliseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            $districts = District::latest()->get();
            $types = Type::latest()->get();
            $status = Status::latest()->get();
            
            if ($request->ajax()) {
                $data = Eglise::with('contact')->with('district')->with('type')->latest()->get();

                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){

                            $btn = '<a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Details" class="details btn btn-info btn-sm showEglise"><i class="fa fa-eye text-white"></i></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Modifier" class="edit btn btn-warning btn-sm editEglise"><i class="fa fa-pencil text-white"></i></a>';

                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Supprimer" class="btn btn-danger btn-sm deleteEglise"><i class="fa fa-trash"></i></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Ajouter un membre" class="btn btn-dark btn-sm addMembre"><i class="fa fa-plus text-white"></i></a>';

                            return $btn;
                        })
                        ->editColumn('nomEglise', function($row) {
                            return ucfirst($row->nomEglise);
                        })
                        ->editColumn('libelleType', function($row) {
                            return ($row->type) ? ucfirst($row->type->libelleType) : '';
                        })
                        ->editColumn('adresse', function($row) {
                            return ($row->contact) ? ucfirst($row->contact->adresse) : '';
                        })
                        ->editColumn('nomDist', function($row) {
                            return ($row->district) ? ucfirst($row->district->nomDist) : '';
                        }) 
                        ->editColumn('created_at', function($row) {
                            return date('d/m/Y H:i', strtotime($row->created_at));
                        })
                        ->editColumn('updated_at', function($row) {
                            return date('d/m/Y H:i', strtotime($row->updated_at));
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }

            return view('eglises.show',compact('districts', 'types','status'));
            
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
            $eglise = Eglise::updateOrCreate([

                'id' => $request->eglise_id

            ],

            [
                'nomEglise' => $request->nomEglise,

            ]);

            $eglise->contact()->associate($contact);
            
            $district = null;
            $type = null;
            if ($request->district_id) {
                $district = District::find($request->district_id);
            }
            if ($district) {
                $eglise->district()->associate($district);
            }
            if ($request->type_id) {
                $type = Type::find($request->type_id);
            }
            if ($type) {
                $eglise->type()->associate($type);
            }
            $eglise->save();

            return response()->json(['success'=>'Eglise enregistrée avec succès']);
        }else {
            return redirect('dashboard');
        }        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
        
            $eglise = Eglise::with('contact')->with('district')->with('type')->find($id);
            return response()->json($eglise);
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
        
            $eglise = Eglise::with('contact')->with('district')->with('type')->find($id);
            return response()->json($eglise);
        }else {
            return redirect('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Eglise $eglise)
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
        
            $eglise = Eglise::find($id);
            $contact = $eglise->contact();
            $eglise->delete();
            $contact->delete();
            return response()->json(['success'=>'Eglise supprimée avec succès.']);
        }else {
            return redirect('dashboard');
        }
    }

    
     /**
     * Store a newly created resource in storage.
     */
    public function addMembre($id)
    {
        $currentUser = Auth::user();
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
        
            $eglise = Eglise::find($id);
            return response()->json($eglise);
        }else {
            return redirect('dashboard');
        }
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function storeMembre(Request $request)
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
            $datenais = Carbon::createFromFormat('d/m/Y', $request->datenais)->format('Y-m-d');
            $membre = new Membre([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'sexe' => $request->sexe,
                'datenais' => $datenais,
            ]);
            $membre->contact()->associate($contact);

            $status = Status::find($request->status_id);

            $membre->status()->associate($status);
            $membre->save();
            $eglise = Eglise::find($request->eglise_id);
            
            $eglise->membres()->save($membre);

            return response()->json(['success'=>'Membre enregistré avec succès']);
        }else {
            return redirect('dashboard');
        }
    }
}
