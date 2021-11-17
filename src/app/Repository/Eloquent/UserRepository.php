<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $userData = $request->only(['name', 'email', 'password']);
        $postData['name'] = ucwords($userData['name']);
        $postData['email'] = $userData['email'];
        $postData['password'] = app('hash')->make($userData['password']);
        $user = $this->create($postData);
        return $user;
    }

    public function generateToken($user)
    {
        $user->api_token = Str::random(60);
        $user->save();

        return $user->api_token;
    }
}