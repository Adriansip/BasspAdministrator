<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\models\CatStepProc;

class CatStepProcController extends Controller
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
        $function=CatStepProc::all()->load('plataform');
        if (is_object($function) && count($function)>0) {
            $data=[
          'status'=>'success',
          'code'=>200,
          'functions'=>$function,
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
        /*Validaciones*/
        $validator=\Validator::make($request->all(), [
            'procId'=>'required|numeric',
            'testPlataformId'=>'required|numeric',
            'available'=>'required|boolean',
            'stepProcName'=>'required|max:25',
            'hint'=>'required',
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
            $function=new CatStepProc();
            $function->fill($request->all());

            if ($function->save()) {
                $data=[
                    'status'=>'success',
                    'code'=>200,
                    'message'=>'Funcion registrada correctamente'
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
        $function=CatStepProc::find($id);

        if (is_object($function)) {
            $data=[
              'status'=>'success',
              'code'=>200,
              'message'=>'Funcion encontrada',
              'function'=>$function
            ];
        } else {
            $data=[
              'status'=>'warning',
              'code'=>404,
              'message'=>'La funcion no se encuentra en la base de datos'
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
        /*Validaciones*/
        $validator=\Validator::make($request->all(), [
          'procId'=>'required|numeric',
          'testPlataformId'=>'required|numeric',
          'available'=>'required|boolean',
          'stepProcName'=>'required|max:25',
          'hint'=>'required',
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
            $function=CatStepProc::find($id);

            if (is_object($function)) {
                $function->fill($request->all());

                if ($function->save()) {
                    $data=[
                      'status'=>'success',
                      'code'=>200,
                      'message'=>'Funcion actualizada correctamente'
                    ];
                }
            } else {
                $data=[
                  'status'=>'warning',
                  'code'=>404,
                  'message'=>'La funcion no se encuentra en la base de datos'
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
        $function=CatStepProc::find($id);
        if (is_object($function)) {
            $function->destroy($id);
            $data=[
              'status'=>'success',
              'code'=>200,
              'message'=>'Funcion eliminada correctamente'
            ];
        /*
        Ver si debe eliminar el regitro de tbl_user_preferences
        */
        } else {
            $data=[
              'status'=>'warning',
              'code'=>404,
              'message'=>'La funcion no se encuentra en la base de datos'
            ];
        }
        return response()->json($data, $data['code']);
    }
}
