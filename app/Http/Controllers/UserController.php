<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use App\Model\Users;

class UserController extends Controller

{

  public function __construct()

   {

     //  $this->middleware('auth:api');

   }


   public function register(Request $request)

   {
      $rules = [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
      ];

      $customMessages = [
          'required' => 'Please fill attribute :attribute'
      ];
      $this->validate($request, $rules, $customMessages);

      try {
          $hasher = app()->make('hash');
          $username = $request->input('name');
          $email = $request->input('email');
          $password = $hasher->make($request->input('password'));

          $save = Users::create([
              'name'=> $username,
              'email'=> $email,
              'password'=> $password,
              'api_key'=> ''
          ]);
          $res['status'] = true;
          $res['message'] = 'Registration success!';
          return response($res, 200);
      } catch (\Illuminate\Database\QueryException $ex) {
          $res['status'] = false;
          $res['message'] = $ex->getMessage();
          return response($res, 500);
      }
   }


   /**

    * Display a listing of the resource.

    *

    * @return \Illuminate\Http\Response

    */

   public function authenticate(Request $request)

   {

       $this->validate($request, [

       'email' => 'required',

       'password' => 'required'

        ]);

      $user = Users::where('email', $request->input('email'))->first();

     if(Hash::check($request->input('password'), $user->password)){

          $apikey = base64_encode(str_random(40));

          Users::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;

          return response()->json(['status' => 'success','api_key' => $apikey]);

      }else{

          return response()->json(['status' => 'fail'],401);

      }

   }

}    

?>