<?php

namespace App\Http\Controllers;

use App\Mail\TransfertMail;
use App\Models\Membre;
use App\Models\Transfert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Eglise;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class TransfertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();

        $egliseId = $currentUser->eglise->id;
        $membres = Membre::where('id_eglise', $egliseId)->get();
        $egliseSources = Eglise::where('id','!=',$egliseId)->latest()->get();
        $districtId = $currentUser->eglise->district->id;
        $pasteurs = Membre::membersWithService(['Pasteur', 'Loholona'],$districtId,$egliseId);
                        
        // dd($pasteurs);
        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            if ($currentUser->eglise) {
                if ($request->ajax()) {
                    $data = Transfert::with(['egliseDest', 'egliseSource', 'membre', 'sourceResponsable','destinationResponsable'])
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
                            //    $btn = '
                            //     <div class="dropdown">
                            //         <a
                            //             class="dropdown-toggle"
                            //             href="javascript:void(0)"
                            //             role="button"
                            //             id="dropdownMenuicon"
                            //             data-bs-toggle="dropdown"
                            //             aria-expanded="false"
                            //         >
                            //         </a>
                            //         <ul class="dropdown-menu" aria-labelledby="dropdownMenuicon">
                            //             <li><a data-id="'.$row->id.'" class="dropdown-item details showMembre" href="javascript:void(0)"> <i class="fa fa-eye text-info pe-2"></i> Details</a></li>
                            //             <li><a data-id="'.$row->id.'" class="dropdown-item edit editMembre" href="javascript:void(0)"> <i class="fa fa-pencil text-warning pe-2"></i> Modifier</a></li>
                            //             <li><a data-id="'.$row->id.'" class="dropdown-item deleteMembre" href="javascript:void(0)"> <i class="fa fa-trash text-danger pe-2"></i> Supprimer</a></li>
                            //             <li><a data-id="'.$row->id.'" class="dropdown-item addBaptism" href="javascript:void(0)"> <i class="fa fa-plus text-dark pe-2"></i> Ajouter une date de baptême</a></li>
                            //             <li><a data-id="'.$row->id.'" class="dropdown-item asignService" href="javascript:void(0)"> <i class="fa fa-tasks text-success pe-2"></i> Assigner un service</a></li>
                            //             <li><a data-id="'.$row->id.'" class="dropdown-item transfertMembre" href="javascript:void(0)"> <i class="fa fa-share text-primary pe-2"></i> Transferer</a></li>
                            //         </ul>
                            //     </div>';
                            //     return $btn;
                            })
                            ->editColumn('nomComplet', function($row) {
                                return ($row->membre)
                                ? strtoupper($row->membre->nom) . (($row->membre->prenom) ? ' ' . ucwords($row->membre->prenom) : '')
                                : ucwords($row->membre_name);
                                                        })
                            ->editColumn('destination', function($row) {
                                return ($row->egliseDest) ? ucwords($row->egliseDest->nomEglise) : ucwords($row->egliseDest_name);
                            })
                            ->editColumn('source', function($row) {
                                return ($row->egliseSource) ? ucwords($row->egliseSource->nomEglise) : ucwords($row->egliseSource_name);
                            })
                            ->editColumn('dateDemande', function($row) {
                                return date('d/m/Y H:i', strtotime($row->date_demande_transfert));
                            })
                            ->editColumn('dateReponse', function($row) {
                                return ($row->date_reponse_demande) ? date('d/m/Y H:i', strtotime($row->date_reponse_demande)) : '';
                            })
                            ->editColumn('status', function($row) {
                                return match($row->status) {
                                    0 => 'Refusé',
                                    1 => 'En attente',
                                    2 => 'Accepté',
                                    default => 'Inconnu'
                                };
                                                            })
                            ->editColumn('responsableDestination', function($row) {
                                return ($row->destinationResponsable) ? ucwords($row->destinationResponsable->name) : ucwords($row->destination_responsable_name);
                            })
                            ->editColumn('responsableSource', function($row) {
                                return ($row->sourceResponsable) ? ucwords($row->sourceResponsable->name) : ucwords($row->source_responsable_name);
                            })
                            ->rawColumns(['action'])
                            ->make(true);
                }
            }

            return view('transferts.show',compact('membres','egliseSources','pasteurs'));

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

        if ($currentUser->hasRole(User::ROLE_ADMIN)) {
            $egliseDest_id = $currentUser->eglise->id;
            $source_responsable = User::where('id_eglise',$request->egliseSource_id)->first();
            $source_responsable_id = $source_responsable->id;
            $transfert = Transfert::updateOrCreate([

                'id' => $request->transfert_id

            ],

            [
                'egliseSource_id' => $request->egliseSource_id,
                'egliseDest_id' => $egliseDest_id,
                'membre_id' => $request->membre_id,
                'destination_responsable_id' => $currentUser->id,
                'source_responsable_id' => $source_responsable_id,
                'destination_pstOrLhl_id' => $request->pstOrLhl_id
            ]);
            if ($transfert) {
                $data["email"] = "fabie.lalaonantenaina@gmail.com";
                $data["title"] = "Fangatahana hifindra fiangonana (Demande de Transfert)";
                $data["body"] = "Test de transfert";
            
                $pdf = PDF::loadView('emails.transfertMail', $data);
                $data["pdf"] = $pdf;
    
                try {
                    Mail::to($data["email"])->send(new TransfertMail($data));
                    return response()->json(['success'=>'Transfert enregistré et envoyé avec succès']);
                } catch (\Throwable $th) {
                    dd($th);
                    //throw $th;
                }
            }
        }else {
            return redirect('dashboard');
        }
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
