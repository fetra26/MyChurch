<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Federation;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();

        if ($currentUser->hasRole(User::ROLE_ADMIN) || $currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            $federations = Federation::with('contact')->latest()->get();
            $missions = Mission::with('contact')->latest()->get();
            if ($request->ajax()) {

                $data = District::with('mission')->with('federation')->latest()->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){

                            $btn = '<a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Details" class="details btn btn-info btn-sm showDistrict"><i class="fa fa-eye text-white"></i></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Modifier" class="edit btn btn-warning btn-sm editDistrict"><i class="fa fa-pencil text-white"></i></a>';

                            $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Supprimer" class="btn btn-danger btn-sm deleteDistrict"><i class="fa fa-trash"></i></a>';

                                return $btn;
                        })
                        ->editColumn('nomDist', function($row) {
                            return ucfirst($row->nomDist);
                        })
                        ->editColumn('federation', function($row) {
                            return ($row->federation) ? ucfirst($row->federation->nomFed) : '-';
                        })
                        ->editColumn('mission', function($row) {
                            return ($row->mission) ? ucfirst($row->mission->nomMiss) : '-';
                        })
                        ->editColumn('created_at', function($row) {
                            return date('d/m/Y H:i:s', strtotime($row->created_at));
                        })
                        ->editColumn('updated_at', function($row) {
                            return date('d/m/Y H:i:s', strtotime($row->updated_at));
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }

            return view('districts.show',compact('federations', 'missions'));

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
            $request->validate([
                'federation_id' => 'nullable|exists:federations,id',
                'mission_id' => 'nullable|exists:missions,id',
            ], [
                'federation_id.exists' => 'Federation invalide.',
                'mission_id.exists' => 'Mission invalide.',
            ]);

            // Ensure that only one of them is provided
            if ($request->federation_id && $request->mission_id) {
                return response()->json(['error'=>"Vous pouvez seulement choisir l'une des fédérations ou des missions."],400);
            }            
            if (!$request->federation_id && !$request->mission_id) {
                return response()->json(['error'=>"Veuillez choisir l'une des fédérations ou des missions."],400);
            }
            $federation = null;
            $mission = null;
            if ($request->federation_id) {
                $federation = Federation::find($request->federation_id);
            }
            if ($request->mission_id) {
                $mission = Mission::find($request->mission_id);
            }
            $district = District::updateOrCreate([

                'id' => $request->district_id

            ],

            [
                'nomDist' => $request->nomDist,
            ]);
            if ($federation && !$mission) {
                // If federation is selected, associate it and dissociate mission
                $district->mission()->dissociate();
                $district->federation()->associate($federation);
            } elseif ($mission && !$federation) {
                // If mission is selected, associate it and dissociate federation
                $district->federation()->dissociate();
                $district->mission()->associate($mission);
            } else {

            }
            $district->save();

            return response()->json(['success'=>'District enregistré avec succès']);
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

            $district = District::with('federation')->with('mission')->find($id);
            return response()->json($district);
        }else {
            return redirect('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, District $district)
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

            $district = District::find($id)->delete();
            return response()->json(['success'=>'District supprimé avec succès.']);
        }else {
            return redirect('dashboard');
        }
    }
}
