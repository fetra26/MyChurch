<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Eglise;
use App\Models\Membre;
use App\Models\Service;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MembreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            $eglises = Eglise::latest()->get();
            $pasteurs = Membre::membersWithService('Pasteur');
            $status = Status::latest()->get();
            $services = Service::latest()->get();
            
            if ($request->ajax()) {
                $data = Membre::with('contact')->with('status')->with('eglise')->latest()->get();

                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){

                            $btn = '<a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Details" class="details btn btn-info btn-sm showMembre"><i class="fa fa-eye text-white"></i></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Modifier" class="edit btn btn-warning btn-sm editMembre"><i class="fa fa-pencil text-white"></i></a>';

                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Supprimer" class="btn btn-danger btn-sm deleteMembre"><i class="fa fa-trash"></i></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Ajouter une date de baptême" class="btn btn-dark btn-sm addBaptism"><i class="fa fa-plus text-white"></i></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Assigner un service" class="btn btn-success btn-sm asignService"><i class="fa fa-tasks text-white"></i></a>';

                            return $btn;
                        })
                        ->editColumn('nom', function($row) {
                            return ucfirst($row->nom);
                        })
                        ->editColumn('prenom', function($row) {
                            return ucfirst($row->prenom);
                        })
                        ->editColumn('sexe', function($row) {
                            return ($row->sexe == 0)? 'Femme' : 'Homme';
                        })
                        ->editColumn('datenais', function($row) {
                            return ($row->datenais) ? date('d/m/Y', strtotime($row->datenais)) : '';

                        })
                        ->editColumn('nomEglise', function($row) {
                            return ($row->eglise) ? ucfirst($row->eglise->nomEglise) : '';
                        })
                        ->editColumn('libelleStat', function($row) {
                            return ($row->status) ? ucfirst($row->status->libelleStat) : '';
                        })
                        ->editColumn('adresse', function($row) {
                            return ($row->contact) ? ucfirst($row->contact->adresse) : '';
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

            return view('membres.show',compact('eglises', 'pasteurs','status', 'services'));
            
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
            // dd($request);
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
            $datenais = ($request->datenais) ? Carbon::createFromFormat('d/m/Y', $request->datenais)->format('Y-m-d') : NULL;
            $membre = Membre::updateOrCreate(
                ['id' => $request->membre_id],
                [
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'sexe' => $request->sexe,
                'datenais' => $datenais,
            ]);
            $membre->contact()->associate($contact);

            $status = Status::find($request->status_id);

            $membre->status()->associate($status);

            $eglise = Eglise::find($request->eglise_id);
            
            $membre->eglise()->associate($eglise);
            $membre->save();

            return response()->json(['success'=>'Membre enregistré avec succès']);
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
        
            $membre = Membre::with('contact')->with('status')->with('eglise')->find($id);
            return response()->json($membre);
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
        
            $membre = Membre::with('contact')->with('status')->with('eglise')->find($id);
            return response()->json($membre);
        }else {
            return redirect('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Membre $membre)
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

            Membre::find($id)->delete();
            return response()->json(['success'=>'Membre supprimé avec succès.']);
        }else {
            return redirect('dashboard');
        }
    }
     
     /**
     * Store a newly created resource in storage.
     */
    public function addBaptism($id)
    {
        $currentUser = Auth::user();
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
        
            $membre = Membre::find($id);
            return response()->json($membre);
        }else {
            return redirect('dashboard');
        }
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function storeBaptism(Request $request)
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

            return response()->json(['success'=>'Bapteme enregistré avec succès']);
        }else {
            return redirect('dashboard');
        }
    }

    public function asignService(Request $request){
        $currentUser = Auth::user();
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
        
            $membre = Membre::find($request->id);
            // $service = Service::find($request->service_id);
            // $membre->services()->attach($service);

            return response()->json($membre);
        }else {
            return redirect('dashboard');
        }
    }
}
