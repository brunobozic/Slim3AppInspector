<?php

namespace App\Endpoints;

use App\Repository\TokenRepository;
use App\Repository\UserRepository;

class LoginEndpoint extends EndpointBase
{
    private $userRepository;
    private $tokenRepository;

    /**
     * LoginEndpoint constructor.
     * @param UserRepository $userRepository
     * @param TokenRepository $tokenRepository
     */
    public function __construct(UserRepository $userRepository, TokenRepository $tokenRepository)
    {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
    }

    public function login($request, $response, $args)
    {
        $data = json_decode($request->getBody());

        $input = $request->getParsedBody();

        $validation = $this->v->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'username' => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            return $response->withHeader('Content-Type', 'text/json')->write(json_encode([

            ]));
        }

        $userName = $input['username'];
        $email = $input['email'];
        $password = $input['password'];
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

        // find the user in db
        $user = $this->userRepository->getOne($userName);

        // verify user name...
        if (!$user) {
            return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);
        }

        // verify password...
        if (!password_verify($password, $user->password)) {
            return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);
        }

        // generate a token
        $token = Auth::createToken($request);

        // store token in Db, assign expiration

        return $response->withHeader('Content-Type', 'text/json')->write(json_encode([
            'token' => $token,
        ]));
    }

    public function register($request, $response, $args)
    {
        $data = json_decode($request->getBody());

        $input = $request->getParsedBody();

        $validation = $this->v->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'username' => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if (!$validation) {
            return $response->withHeader('Content-Type', 'text/json')->write(json_encode([
                'error' => true, 'message' => $validation
            ]));
        }

        $userName = $input['username'];
        $email = $input['email'];
        $password = $input['password'];
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

        // find the user in db
        $user = $this->userRepository->getOne($userName);

        // verify user name...
        if ($user) {
            return $this->response->withJson(['error' => true, 'message' => 'User with the same name already exists.']);
        } else {
            if ($user->email == $email) {
                return $this->response->withJson(['error' => true, 'message' => 'User with the same email already exists.']);
            } else {
                // create a new user in Db
                $this->userRepository->insert($userName, $email, $passwordHashed);

                // generate a token
                $token = Auth::createToken($request);

                // store token in Db, assign expiration
                $userToStoreTokenFor = $this->userRepository->getOne($userName);


                $tokenStored = $this->tokenRepository . insert($token, $userToStoreTokenFor);

                // emit the token}
                return $response->withHeader('Content-Type', 'text/json')->write(json_encode([
                    'token' => $token,
                ]));
            }
        }
    }
}