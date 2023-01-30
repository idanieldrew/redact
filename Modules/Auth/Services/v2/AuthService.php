<?php

namespace Module\Auth\Services\v2;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Module\Auth\Services\AuthService as Service;
use Module\Auth\Services\v2\Email\ForgetPasswordEmail;
use Module\Token\Repository\v1\TokenRepository;
use Module\User\Models\User;
use Module\User\Repository\v1\UserRepository;
use stdClass;

class AuthService extends Service
{
    /**
     *Create new user
     *
     * @param $request
     * @return array
     */
    public function store($request): array
    {
        $user = $this->model()->create([
            'username' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return [
            'status' => 'success',
            'code' => Response::HTTP_CREATED,
            'message' => 'Successfully registered',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ];
    }

    /**
     * try to login
     *
     * @param $request
     * @return null
     */
    public function login($request): array
    {
        $user = User::whereEmail($request->email)->first();

        // Check exist user
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->response(
                'error',
                Response::HTTP_UNAUTHORIZED,
                'invalid email or password',
                null
            );
        }

        $token = $user->createToken('test')->plainTextToken;

        return $this->response(
            'success',
            Response::HTTP_OK,
            'Successfully login',
            ['user' => $user, 'token' => $token]
        );
    }

    /**
     * Forget password
     *
     * @param  string  $field
     * @return array
     */
    public function forgetPassword(string $field)
    {
        $data = filter_var($field, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // check exist user
        $user = (new UserRepository)->getCustomRow($data, $field);
        if (! $user) {
            return $this->response('fail', Response::HTTP_UNAUTHORIZED, 'email not found', null);
        }

        $token = Str::random(5);
        $request = new stdClass();
        $request->token = $token;
        $request->data = $data;
        $request->field = $field;
        $request->type = "$data verified";
        (new TokenRepository())->store($user, $request);

        (new ForgetPassword)->forgetPassword(new ForgetPasswordEmail($user, $token));

        return $this->response('success', Response::HTTP_OK, 'send token for forgot password', null);
    }

    public function verfyToken(string $token)
    {
        $res = (new TokenRepository)->existToken($token);

        return $res ?
            $this->response('success', '200', 'correct', null) :
            $this->response('fail', '404', 'incorrect', null);
    }

    /**
     * Return array
     *
     * @param  string  $status
     * @param  int  $code
     * @param  string  $message
     * @param $data
     * @return array
     */
    private function response(string $status, int $code, string $message, $data): array
    {
        return [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data ?: null,
        ];
    }
}
