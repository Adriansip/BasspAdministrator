<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\models\ServiceSecurity;

class ServiceSecurityController extends Controller
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
        $services=ServiceSecurity::all();
        if (is_object($services) && count($services)>0) {
            $data=[
              'status'=>'success',
              'code'=>200,
              'services'=>$services,
              'message'=>'Peticion exitosa'
            ];
        } else {
            $data=[
              'status'=>'warning',
              'code'=>404,
              'message'=>'No hay registros'
            ];
        }
        $response=[];
        array_push($response, $data);
        return response()->json($response, $response[0]['code']);
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
          'expirationDate' => 'required|date  ',
          'executor_id' => 'required|numeric'
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
            $service=new ServiceSecurity();
            $service->fill($request->all());

            //Transaccion
            if ($service->save()) {
                $data=[
                      'status'=>'success',
                      'code'=>200,
                      'message'=>'Licencia registrada correctamente'
                ];
            }
        }
        $response=[];
        array_push($response, $data);
        return response()->json($response, $response[0]['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service=ServiceSecurity::find($id);

        if (is_object($service)) {
            $data=[
            'status'=>'success',
            'code'=>200,
            'message'=>'Licencia encontrada',
            'service'=>$service
          ];
        } else {
            $data=[
            'status'=>'warning',
            'code'=>404,
            'message'=>'La licencia no se encuentra en la base de datos'
          ];
        }
        $response=[];
        array_push($response, $data);
        return response()->json($response, $response[0]['code']);
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
        'expirationDate' => 'required|date  ',
        'executor_id' => 'required|numeric'
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
            $service=ServiceSecurity::find($id);
            if (is_object($service)) {
                $service->fill($request->all());
                //Transaccion
                if ($service->save()) {
                    $data=[
                      'status'=>'success',
                      'code'=>200,
                      'message'=>'Licencia actualizada correctamente'
                    ];
                }
            } else {
                $data=[
                  'status'=>'warning',
                  'code'=>404,
                  'message'=>'La licencia no se encuentra en la base de datos'
                ];
            }
        }
        $response=[];
        array_push($response, $data);
        return response()->json($response, $response[0]['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service=ServiceSecurity::find($id);
        if (is_object($service)) {
            $service->destroy($id);
            $data=[
              'status'=>'success',
              'code'=>200,
              'message'=>'Licencia eliminada correctamente'
            ];
        } else {
            $data=[
              'status'=>'warning',
              'code'=>404,
              'message'=>'La licencia no se encuentra en la base de datos'
            ];
        }
        $response=[];
        array_push($response, $data);
        return response()->json($response, $response[0]['code']);
    }
}
