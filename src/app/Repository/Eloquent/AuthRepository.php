<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\AuthRepositoryInterface;
use External\Foo\Auth\AuthWS;
use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
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

    public function fooAuthentication($request){
        try {
            $fooAuth = new AuthWS();
            $response = $fooAuth->authenticate($request->login, $request->password);
            $response = true;
        } catch (\Exception $e) {
             if($e->getMessage() == 'Authentication failed');
            $response = false;
        }
        return $response;
    }

    public function barAuthentication($request){
        $barAuth = new LoginService();
        $response = $barAuth->login($request->login, $request->password);
        return $response;
    }

    public function bazAuthentication($request){
        $bazAuth = new Authenticator();
        $response = $bazAuth->auth($request->login, $request->password);
        $url = get_class($response);
        if($url == "External\Baz\Auth\Responses\Success"){
            $pos = strrpos($url, 'Success');
            $id = $pos === false ? $url : substr($url, $pos + 0);
            return true;
        } else {
            $pos = strrpos($url, 'Failure');
            $id = $pos === false ? $url : substr($url, $pos + 0);
            return false;
        }
    }
}