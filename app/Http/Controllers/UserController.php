<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Response;
use App\Models\User;
use App\Models\UserPreference;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except'=>['index','show','login']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        if (is_object($users) && count($users)>0) {
            $data=[
            'status'=>'success',
            'code'=>200,
            'users'=>$users,
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
        try {
            DB::beginTransaction();
            /*Validaciones*/
            $validator=\Validator::make($request->all(), [
              'userName'=>'required|max:30',
              'userLastName'=>'required|alpha|max:50',
              'userMotherLastName'=>'required|alpha|max:50',
              'userNick'=>'required',
              'userPwd'=>'required',
              'userRolId'=>'required|numeric',
              //'userLastAccessIP'=>'required',
              //'userUniqueID'=>'required',
              'userEmail'=>'required|email|max:50',
              //'userToken'=>'required',
              //'userPhone'=>'required'
              'userUntil'=>'required'
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
                $user=new User();
                $user->fill($request->all());

                //Transaccion
                if ($user->save()) {

              //Llenamos la segunda tabla simultaneamente
                    $userPreference=new UserPreference();
                    $userPreference->userId=$user->userId;
                    $userPreference->directory='C:\testConfig\Executor';
                    $userPreference->language='ES';
                    $userPreference->notifications=0;
                    $userPreference->recording=0;
                    $userPreference->quality='SD';
                    $userPreference->save();

                    $data=[
                      'status'=>'success',
                      'code'=>200,
                      'message'=>'Usuario registrado correctamente'
                    ];

                    DB::commit();
                }
            }
        } catch (Exception $ex) {
            DB::rollback();
            $data=[
            'status'=>'danger',
            'code'=>404,
            'message'=>'Algo salio mal durante la transaccion: '.$ex
          ];
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
        $user=User::find($id);

        if (is_object($user)) {
            $data=[
              'status'=>'success',
              'code'=>200,
              'message'=>'Usuario encontrado',
              'user'=>$user
            ];
        } else {
            $data=[
              'status'=>'warning',
              'code'=>404,
              'message'=>'El usuario no se encuentra en la base de datos'
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
        'userName'=>'required|max:30',
        'userLastName'=>'required|alpha|max:50',
        'userMotherLastName'=>'required|alpha|max:50',
        'userNick'=>'required',
        'userRolId'=>'required|numeric',
        'userEmail'=>'required|email|max:50',
        'userPwd'=>'required',
        'userUntil'=>'required'
      ]);

        if ($validator->fails()) {
            $data=[
            'status'=> 'danger',
            'code'=> 400,
            'message'=>'Porfavor introduzca todos los campos',
            'errors'=>$validator->errors()
          ];
        } else {
            $user=User::find($id);
            //Comprobar que exista el usuario con ese id
            if (is_object($user)) {
                $user->fill($request->all());
                //Transaccion
                if ($user->save()) {
                    $data=[
                      'status'=>'success',
                      'code'=>200,
                      'message'=>'Usuario Actualizado correctamente'
                    ];
                }
            } else {
                $data=[
                  'status'=>'warning',
                  'code'=>404,
                  'message'=>'El usuario no se encuentra en la base de datos'
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
        $user=User::find($id);
        if (is_object($user)) {
            $user->destroy($id);
            $data=[
              'status'=>'success',
              'code'=>200,
              'message'=>'Usuario eliminado correctamente'
            ];
        /*
        Ver si debe eliminar el regitro de tbl_user_preferences
        */
        } else {
            $data=[
              'status'=>'warning',
              'code'=>404,
              'message'=>'El usuario no se encuentra en la base de datos'
            ];
        }
        return response()->json($data, $data['code']);
    }

    public function login(Request $request)
    {
        $jwtAuth=new \JwtAuth();
        // Recibir datos por POST y Validar los datos
        $validator=\Validator::make($request->all(), [
          'userEmail'=>'required|email',
          'userPwd'=>'required'
        ]);

        if ($validator->fails()) {
            $signup=[
              'estatus'=> 'error',
              'code'=> 400,
              'message'=> 'No se ha podido identificar a este usuario',
              'errors' => $validator->errors()
            ];
        } else {
            // Cifrar la password (PENDIENTE)
            //$pwd=hash('sha256', $request->password);

            // Devolver token
            $signup=$jwtAuth->signUp($request->userEmail, $request->userPwd);

            // Devolver datos, cuando ya tengo el token
            if (!empty($request->getToken)) {
                $signup=$jwtAuth->signUp($request->userEmail, $request->userPwd, true);
            }
        }
        return response()->json($signup, 200);
    }
}
