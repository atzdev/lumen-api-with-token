<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\User;
class UserController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
         ];

        $customMessages = [
             'required' => 'Please fill attribute :attribute'
        ];
        $this->validate($request, $rules, $customMessages);

        try {

            $username = $request->input('username');
            $email = $request->input('email');
            
            $password = app('hash')->make($request->input('password'));

            $save = User::create([
                'username'=> $username,
                'email'=> $email,
                'password'=> $password,
                'api_token'=> ''
            ]);
            $res['status'] = true;
            $res['message'] = 'Registration success!';
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $res['status'] = false;
            $res['message'] = $e->getMessage();
            return response($res, 500);
        }
    }

    public function get_user()
    {
        $user = User::all();
        if ($user) {
              $res['status'] = true;
              $res['message'] = $user;

              return response($res);
        }else{
          $res['status'] = false;
          $res['message'] = 'Cannot find user!';

          return response($res);
        }
    }
}