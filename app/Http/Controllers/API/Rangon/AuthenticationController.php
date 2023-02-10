<?php

namespace App\Http\Controllers\API\Rangon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rangon\Auth\LoginRequest;
use App\Repositories\Rangon\AuthenticationRepository;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    protected $repo;

    public function __construct(AuthenticationRepository $repo)
    {
        $this->repo = $repo;
    }

    //
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if ($auth = $this->repo->login($validated)) {
            return $this->successResponse($auth);
        }

        return $this->errorResponse('The credentials provided does not match with our record.');
    }

    public function logout(Request $request)
    {
        if ($auth = $this->repo->logout()) {
            return $this->successResponse([], ['message'    =>  'Logged out!']);
        }
        return $this->errorResponse('Logging out failed');
    }
}
