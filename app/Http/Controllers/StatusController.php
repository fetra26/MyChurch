<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Status::latest()->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Modifier" class="edit btn btn-warning btn-sm editStatus"><i class="fa fa-pencil text-white"></i></a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Supprimer" class="btn btn-danger btn-sm deleteStatus"><i class="fa fa-trash"></i></a>';

                            return $btn;
                    })
                    ->editColumn('libelleStat', function($row) {
                        return ucfirst($row->libelleStat);
                    }) ->editColumn('created_at', function($row) {
                        return date('d/m/Y H:i', strtotime($row->created_at));
                    })
                    ->editColumn('updated_at', function($row) {
                        return date('d/m/Y H:i', strtotime($row->updated_at));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('status.show');
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
            Status::updateOrCreate([

                        'id' => $request->status_id

                    ],

                    [

                        'libelleStat' => $request->libelleStat

                    ]);



            return response()->json(['success'=>'Statut enregistré avec succès']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $status = Status::find($id);

        return response()->json($status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Status::find($id)->delete();
        return response()->json(['success'=>'Statut supprimé avec succès.']);
    }
}
