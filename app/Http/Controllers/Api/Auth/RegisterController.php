<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Responses\Api\Response;
use App\Services\UserService;

class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @param UserService $service
     *
     * @return Response
     */
    public function register(RegisterRequest $request, UserService $service)
    {
        $user = $service->create($request->name,  $request->email,  $request->password);

        $token = $service->createToken($user);

        return Response::make(['token' => $token], 200);
    }
}
