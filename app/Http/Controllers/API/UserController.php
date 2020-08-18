<?php

namespace App\Http\Controllers\API;

use App\Role;
use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'occupation' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'integer', 'min:12'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $encryptedPassword = Hash::make($request->password);

        $user = new User;

        try{
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->occupation = $request->occupation;
            $user->institution = $request->institution;
            $user->password  = $encryptedPassword;

            $user->save();

            $role = Role::select('id')->where('name', 'user')->first();
            $user->roles()->attach($role);

            return response()->json([
                'success' => true,
                'message' => 'Registration Successful'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success'=> false,
                'message' => 'Registration Unsuccessful',
                'error' => ''.$e
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'institution' => 'required|string|max:255',
            'phone' => 'required|integer|min:12',
            'password' => 'sometimes|string|min:8',
            'occupation' => 'required|string|max:255',
        ]);

        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return ["Message" => "User Deleted"];
    }
}
