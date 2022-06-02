<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\MemberLoginResource;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->validated())) {
            return response()->json(
                [
                    'status' => 'error',
                    'error' => 'Email or password is incorrect, please try again',
                    'code' => JsonResponse::HTTP_UNAUTHORIZED,
                ],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }
        return $this->createNewToken($token);
    }

    public function logout()
    {
        auth()->logout();
        $mess = 'Member successfully signed out';

        return $this->responeJson(0, 200, $mess);
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'status' => 'success',
            'code' => JsonResponse::HTTP_OK,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'data' => new MemberLoginResource(auth()->user()),
        ], JsonResponse::HTTP_OK);
    }

    public function changePassword(ChangePassRequest $request)
    {
        if (auth()->id()) {
            $memberId = auth()->id();
            $member = Member::where('id', $memberId)->first();
            if (!Hash::check($request->old_password, $member->password)) {
                $mess = [
                    'old_password' => 'The password is incorrect',
                ];
                return $this->responeJson(1, 422, $mess);
            }
            $member->update(
                ['password' => bcrypt($request->new_password)]
            );
            $mess = 'Member successfully changed password';
            return $this->responeJson(0, 201, $mess);
        } else {
            $mess = 'Unauthorized';
            return $this->responeJson(1, 401, $mess);
        }

    }

    public function responeJson($type, $code, $message)
    {
        $data = null;
        $status = null;
        if ($type == 0) {
            $data = 'message';
            $status = 'success';
        } else {
            $data = 'error';
            $status = 'error';
        }
        return response()->json([
            'status' => $status,
            'code' => $code,
            $data => $message,
        ], $code);
    }
}
