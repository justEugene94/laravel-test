<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Responses\Api\Response;
use App\Models\User;
use App\Services\UserService;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @param UserService $service
     *
     * @return Response
     */
    public function login(LoginRequest $request, UserService $service)
    {
        $data = $request->getData();

        /** @var User $user */
        $user = User::query()->where('email', $data['email'])->firstOrFail();

        if (!$service->checkPassword($user, $data['password']))
        {
            throw new BadRequestHttpException('Wrong email or password');
        }

        $token = $service->createToken($user);

        return Response::make(['token' => $token], 200);
    }
}
