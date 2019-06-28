<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\models\AdminSupport;

class AdminSupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except'=>['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminSupports=AdminSupport::all();
        if (is_object($adminSupports) && count($adminSupports)>0) {
            $data=[
              'status'=>'success',
              'code'=>200,
              'adminSupports'=>$adminSupports,
              'message'=>'Peticion exitosa'
            ];
        } else {
            $data=[
              'status'=>'warning',
              'code'=>404,
              'message'=>'No hay registros'
            ];
        }
        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=\Validator::make($request->all(), [
          'fch' => 'required|date  ',
          'tipo' => 'required',
          'usuario'=>'required',
          'descripcion'=>'required',
          'tecnico'=>'required',
          'fch_entrega'=>'required|date',
          'horas'=>'required'
        ]);

        if ($validator->fails()) {
            $data=[
              'status'=>'danger',
              'code'=>400,
              'message'=>'Porfavor introduzca todos los campos',
              'errors'=>$validator->errors(),
              'request'=>$request
            ];
        } else {
            $adminSupport=new AdminSupport();
            $adminSupport->fill($request->all());

            //Transaccion
            if ($adminSupport->save()) {
                $data=[
                  'status'=>'success',
                  'code'=>200,
                  'message'=>'Horas de soporte registradas correctamente'
                ];
            }
        }
        return response()->json($data, $data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $adminSupport=AdminSupport::find($id);

        if (is_object($adminSupport)) {
            $data=[
              'status'=>'success',
              'code'=>200,
              'message'=>'Registro encontrado',
              'adminSupport'=>$adminSupport
            ];
        } else {
            $data=[
              'status'=>'warning',
              'code'=>404,
              'message'=>'El registro no se encuentra en la base de datos'
            ];
        }
        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator=\Validator::make($request->all(), [
          'fch' => 'required|date  ',
          'tipo' => 'required',
          'usuario'=>'required',
          'descripcion'=>'required',
          'tecnico'=>'required',
          'fch_entrega'=>'required|date',
          'horas'=>'required'
        ]);

        if ($validator->fails()) {
            $data=[
              'status'=>'danger',
              'code'=>400,
              'message'=>'Porfavor introduzca todos los campos',
              'errors'=>$validator->errors(),
              'request'=>$request
            ];
        } else {
            $adminSupport=AdminSupport::find($id);
            if (is_object($adminSupport)) {
                $adminSupport->fill($request->all());
                //Transaccion
                if ($adminSupport->save()) {
                    $data=[
                      'status'=>'success',
                      'code'=>200,
                      'message'=>'Registro actualizado correctamente'
                    ];
                }
            } else {
                $data=[
                  'status'=>'warning',
                  'code'=>404,
                  'message'=>'El registro no se encuentra en la base de datos'
                ];
            }
        }
        return response()->json($data, $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adminSupport=AdminSupport::find($id);
        if (is_object($adminSupport)) {
            $adminSupport->destroy($id);
            $data=[
              'status'=>'success',
              'code'=>200,
              'message'=>'Registro eliminado correctamente'
            ];
        } else {
            $data=[
              'status'=>'warning',
              'code'=>404,
              'message'=>'El registro no se encuentra en la base de datos'
            ];
        }
        return response()->json($data, $data['code']);
    }
}
