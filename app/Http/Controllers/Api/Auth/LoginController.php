<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Responses\Api\Response;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @param UserService $service
     *
     * @return Response
     */
    public function login(Request $request, UserService $service)
    {
        $data = $request->all();
        $validator = $this->validator($data);

        if ($validator->fails())
        {
            return Response::make()->setStatusCode(422)->addValidationErrors([$validator->errors()]);
        }

        /** @var User $user */
        $user = User::query()->where('email', $data['email'])->firstOrFail();

        if (!$service->checkPassword($user, $data['password']))
        {
            throw new BadRequestHttpException('Wrong email or password');
        }

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
        return Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
    }
}
