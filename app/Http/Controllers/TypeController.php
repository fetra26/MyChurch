<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Type::latest()->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Modifier" class="edit btn btn-warning btn-sm editType"><i class="fa fa-pencil text-white"></i></a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip" data-id="'.$row->id.'" title="Supprimer" class="btn btn-danger btn-sm deleteType"><i class="fa fa-trash"></i></a>';

                            return $btn;
                    })
                    ->editColumn('libelleType', function($row) {
                        return ucfirst($row->libelleType);
                    }) ->editColumn('created_at', function($row) {
                        return date('d/m/Y H:i', strtotime($row->created_at));
                    })
                    ->editColumn('updated_at', function($row) {
                        return date('d/m/Y H:i', strtotime($row->updated_at));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('types.show');
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
            Type::updateOrCreate([

                        'id' => $request->type_id

                    ],

                    [

                        'libelleType' => $request->libelleType

                    ]);



            return response()->json(['success'=>'Statut enregistré avec succès']);
    }


    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $type = Type::find($id);

        return response()->json($type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Type::find($id)->delete();
        return response()->json(['success'=>'Type supprimé avec succès.']);
    }
}
