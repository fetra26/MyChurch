<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Service::latest()->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" title="Modifier" class="edit btn btn-warning btn-sm editService"><i class="fa fa-pencil text-white"></i></a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-bs-toggle="tooltip"  data-id="'.$row->id.'" dtitle="Supprimer" class="btn btn-danger btn-sm deleteService" id="deleteService"><i class="fa fa-trash"></i></a>';

                            return $btn;
                    })
                    ->editColumn('libelleServ', function($row) {
                        return ucfirst($row->libelleServ);
                    }) ->editColumn('created_at', function($row) {
                        return date('d/m/Y H:i', strtotime($row->created_at));
                    })
                    ->editColumn('updated_at', function($row) {
                        return date('d/m/Y H:i', strtotime($row->updated_at));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('services.show');
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
        $service = Service::updateOrCreate([

            'id' => $request->service_id

        ],

        [

            'libelleServ' => $request->libelleServ

        ]);

        // dd($service);


            return response()->json(['success'=>'Service enregistré avec succès']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::find($id);

        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Service::find($id)->delete();
        return response()->json(['success'=>'Service supprimé avec succès.']);
    }
}
