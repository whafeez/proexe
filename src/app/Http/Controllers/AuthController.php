<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\AuthRepositoryInterface;
use App\Repository\CompanyRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;
use App\JWT\TokenIssuer;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class AuthController extends Controller
{

    private $authRepository;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AuthRepositoryInterface $authRepository,CompanyRepositoryInterface $companyRepository) {

        $this->authRepository = $authRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(AuthRequest $request): JsonResponse
    {
        // TODO
        $login = explode('_',$request->login);
        $status = 'failure';
        switch ($login[0]) {
            case $login[0] === $this->companyRepository::$foo:
                if($this->authRepository->fooAuthentication($request)){
                    $status = 'success';
                }
                break;
            case $login[0] === $this->companyRepository::$bar:
                if($this->authRepository->barAuthentication($request)){
                    $status = 'success';
                }
                break;
            case $login[0] === $this->companyRepository::$baz:
                if($this->authRepository->bazAuthentication($request)){
                    $status = 'success';
                }
                break;
            default:
                $status = 'failure';
                break;
        }

        if($status == 'success') {
            $response = [
                'status' => $status,
                'token' => $this->respondWithToken()
            ];
        } else {
            $response = [
                'status' => $status
            ];
        }
        return response()->json($response);
    }

    protected function respondWithToken()
    {
        $configuration = Configuration::forSymmetricSigner(
            // You may use any HMAC variations (256, 384, and 512)
            new Sha256(),
            // replace the value below with a key of your own!
            InMemory::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
            // You may also override the JOSE encoder/decoder if needed by providing extra arguments here
        );
      $tokenIssuer = new TokenIssuer($configuration);
      return $tokenIssuer->issueToken();
    }
}
