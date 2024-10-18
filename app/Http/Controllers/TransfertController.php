<?php

namespace App\Http\Controllers;

use App\Models\Membre;
use App\Models\Transfert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransfertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        
        $membres = Membre::all();
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            if ($currentUser->eglise) {
                $egliseId = $currentUser->eglise->id; 
                if ($request->ajax()) {
                    $data = Transfert::with(['eglise', 'membre', 'sourceResponsable','destinationResponsable'])
                                    ->whereHas('egliseSource', function($query) use ($egliseId) {
                                        $query->where('id', $egliseId); // Check if the source's eglise matches
                                    })
                                    ->orWhereHas('egliseDest', function($query) use ($egliseId) {
                                        $query->where('id', $egliseId); // Check if the destination's eglise matches
                                    })
                                    ->latest()
                                    ->get();
    
                    return DataTables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                               $btn = '
                                <div class="dropdown">
                                    <a
                                        class="dropdown-toggle"
                                        href="javascript:void(0)"
                                        role="button"
                                        id="dropdownMenuicon"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon">
                                        <li><a data-id="'.$row->id.'" class="dropdown-item details showMembre" href="javascript:void(0)"> <i class="fa fa-eye text-info pe-2"></i> Details</a></li>
                                        <li><a data-id="'.$row->id.'" class="dropdown-item edit editMembre" href="javascript:void(0)"> <i class="fa fa-pencil text-warning pe-2"></i> Modifier</a></li>
                                        <li><a data-id="'.$row->id.'" class="dropdown-item deleteMembre" href="javascript:void(0)"> <i class="fa fa-trash text-danger pe-2"></i> Supprimer</a></li>
                                        <li><a data-id="'.$row->id.'" class="dropdown-item addBaptism" href="javascript:void(0)"> <i class="fa fa-plus text-dark pe-2"></i> Ajouter une date de baptême</a></li>
                                        <li><a data-id="'.$row->id.'" class="dropdown-item asignService" href="javascript:void(0)"> <i class="fa fa-tasks text-success pe-2"></i> Assigner un service</a></li>
                                        <li><a data-id="'.$row->id.'" class="dropdown-item transfertMembre" href="javascript:void(0)"> <i class="fa fa-share text-primary pe-2"></i> Transferer</a></li>
                                    </ul>
                                </div>';
                                return $btn;
                            })
                            ->editColumn('nomComplet', function($row) {
                                return ($row->membre) ? (strtoupper($row->membre->nom). ($row->membre->prenom)? ' '. ucwords($row->membre->prenom) : '' ) : ucwords($row->membre_name);
                            })
                            ->editColumn('source', function($row) {
                                return ($row->egliseSource) ? ucwords($row->egliseSource->nomEglise) : ucwords($row->egliseSource_name);
                            })
                            ->editColumn('destination', function($row) {
                                return ($row->egliseDest) ? ucwords($row->egliseDest->nomEglise) : ucwords($row->egliseDest_name);
                            })
                            ->editColumn('libelleStat', function($row) {
                                return ($row->status) ? ucfirst($row->status->libelleStat) : '';
                            })
                            ->editColumn('adresse', function($row) {
                                return ($row->contact) ? ucfirst($row->contact->adresse) : '';
                            }) 
                            ->editColumn('sexe', function($row) {
                                return ($row->sexe == 0)? 'F' : 'H';
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
            }

            return view('transferts.show',compact('membres'));
            
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceMembre $serviceMembre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceMembre $serviceMembre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceMembre $serviceMembre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceMembre $serviceMembre)
    {
        //
    }
}
