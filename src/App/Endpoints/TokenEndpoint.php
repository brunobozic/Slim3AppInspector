<?php
namespace App\Endpoints;

use App\Repository\UserRepository;
use DateTime;
use Firebase\JWT\JWT;
use Tuupola\Base62;

final class TokenEndpoint extends EndpointBase
{
	private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function getToken($request, $response, $args)
	{
		$requested_scopes = $request->getParsedBody();
		$valid_scopes = [
			"portal.create",
			"portal.read",
			"portal.update",
			"portal.delete",
			"portal.list",
			"portal.all"
		];

//		$scopes = array_filter($requested_scopes, function ($needle) use ($valid_scopes) {
//			return in_array($needle, $valid_scopes);
//		});

		$now = new DateTime();
		$future = new DateTime("now +2 hours");
		$server = $request->getServerParams();
		$jti = (new Base62)->encode(random_bytes(16));
		$payload = [
			"iat"   => $now->getTimeStamp(),
			"exp"   => $future->getTimeStamp(),
			"jti"   => $jti,
			"sub"   => $server[ "PHP_AUTH_USER" ],
			"scope" => $valid_scopes
		];
		$secret = getenv("JWT_SECRET");
		$token = JWT::encode($payload, $secret, "HS256");
		$data[ "token" ] = $token;
		$data[ "expires" ] = $future->getTimeStamp();

		return $response->withStatus(201)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
}