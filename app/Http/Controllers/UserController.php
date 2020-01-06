<?php

namespace App\Http\Controllers;

use App\Etiqueta;
use App\Evento;
use App\Permiso;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permisos = Permiso::all()->pluck('nombre','id');        
        return view('users.create',compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['unique:users', 'required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'permisos' => ['required', 'array', 'min:1'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->permisos()->attach($request->permisos);
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $permisos = Permiso::all()->pluck('nombre','id'); 
        return view('users.edit',compact('user','permisos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['unique:users,username,'.$user->id, 'required', 'string', 'max:255'],
            'email' => ['unique:users,email,'.$user->id,'required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:5', 'confirmed'],
            'permisos' => ['required', 'array', 'min:1'],
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $user->permisos()->detach();
        $user->permisos()->attach($request->permisos);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return "Eliminado";
    }
    public function provide()
    {
        return response()->json(User::select('id', 'name', 'email')->with('permisos')->get());
    }
}
