<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\models\Notification;

class NotificationsController extends Controller
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
        $notifications=Notification::all();
        if (is_object($notifications) && count($notifications)>0) {
            $data=[
              'status'=>'success',
              'code'=>200,
              'notifications'=>$notifications,
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
          'fecha' => 'required|date  ',
          'titulo' => 'required',
          'descripcion'=>'required'
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
            $notification=new Notification();
            $notification->fill($request->all());

            //Transaccion
            if ($notification->save()) {
                $data=[
                  'status'=>'success',
                  'code'=>200,
                  'message'=>'Notificacion registrada correctamente'
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
        $notification=Notification::find($id);

        if (is_object($notification)) {
            $data=[
              'status'=>'success',
              'code'=>200,
              'message'=>'Notificacion encontrada',
              'notification'=>$notification
            ];
        } else {
            $data=[
              'status'=>'warning',
              'code'=>404,
              'message'=>'La notificacion no se encuentra en la base de datos'
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
          'fecha' => 'required|date  ',
          'titulo' => 'required',
          'descripcion'=>'required'
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
            $notification=Notification::find($id);
            if (is_object($notification)) {
                $notification->fill($request->all());
                //Transaccion
                if ($notification->save()) {
                    $data=[
                      'status'=>'success',
                      'code'=>200,
                      'message'=>'Notificacion actualizada correctamente'
                    ];
                }
            } else {
                $data=[
                  'status'=>'warning',
                  'code'=>404,
                  'message'=>'La notificacion no se encuentra en la base de datos'
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
        $notification=Notification::find($id);
        if (is_object($notification)) {
            $notification->destroy($id);
            $data=[
              'status'=>'success',
              'code'=>200,
              'message'=>'Notificacion eliminada correctamente'
            ];
        } else {
            $data=[
              'status'=>'warning',
              'code'=>404,
              'message'=>'La notificacion no se encuentra en la base de datos'
            ];
        }
        $response=[];
        array_push($response, $data);
        return response()->json($response, $response[0]['code']);
    }
}
