<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Responses\Api\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);

        if ($validator->fails())
        {
            return Response::make(null, 422)->addValidationErrors([$validator->errors()]);
        }

        /** @var User $user */
        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return Response::make(['token' => $token], 200);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'required' => 'This field is required.',
        ];

        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ], $messages);
    }
}
