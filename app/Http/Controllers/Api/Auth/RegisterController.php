<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Responses\Api\Response;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * @param Request $request
     * @param UserService $service
     *
     * @return Response
     */
    public function register(Request $request, UserService $service)
    {
        $data = $request->all();
        $validator = $this->validator($data);

        if ($validator->fails())
        {
            return Response::make()->setStatusCode(422)->addValidationErrors([$validator->errors()]);
        }

        $user = $service->create($data['name'],  $data['email'],  $data['password']);

        $token = $service->createToken($user);

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
