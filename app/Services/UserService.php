<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    public function create(string $name, string $email, string $password): User
    {
        /** @var User $user */
        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return $user;
    }

    /**
     * @param User $user
     *
     * @return string
     */
    public function createToken(User $user): string
    {
        return $user->createToken('Laravel Password Grant Client')->accessToken;
    }

    /**
     * @param User $user
     * @param string $password
     *
     * @return bool
     */
    public function checkPassword(User $user, string $password): bool
    {
       return Hash::check($password, $user->password);
    }
}
