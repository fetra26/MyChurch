<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Federation;
use Illuminate\Http\Request;

class FederationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Federation::with('contact')->latest()->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Details" class="details btn btn-info btn-sm showFederation"><i class="fa fa-eye text-white"></i></a>';
                           $btn = $btn.'<a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Modifier" class="edit btn btn-warning btn-sm editFederation"><i class="fa fa-pencil text-white"></i></a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Supprimer" class="btn btn-danger btn-sm deleteFederation"><i class="fa fa-trash"></i></a>';

                            return $btn;
                    })
                    ->editColumn('nomFed', function($row) {
                        return ucfirst($row->nomFed);
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

        return view('federations.show');
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
        $federation = Federation::updateOrCreate([

            'id' => $request->federation_id

        ],

        [
            'nomFed' => $request->nomFed,

        ]);

        $federation->contact()->associate($contact);

        $federation->save();

    return response()->json(['success'=>'Federation enregistrée avec succès']);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $federation = Federation::with('contact')->find($id);
        // dd($federation->contact);
        return response()->json($federation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $federation = Federation::with('contact')->find($id);
        return response()->json($federation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Federation $federation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $federation = Federation::find($id);
        $contact = $federation->contact();
        $federation->delete();
        $contact->delete();
        return response()->json(['success'=>'Federation supprimée avec succès.']);

    }
}
