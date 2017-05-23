<?php

use App\ApiMiddleware\ApiAuditMiddleware;
use App\Token;
use Crell\ApiProblem\ApiProblem;
use Gofabian\Negotiation\NegotiationMiddleware;
use Micheh\Cache\CacheUtil;
use Slim\Csrf\Guard;
use Slim\Middleware\HttpBasicAuthentication;
use Slim\Middleware\JwtAuthentication;
use Tuupola\Middleware\Cors;
use Tuupola\Middleware\ServerTiming;
use Tuupola\Middleware\ServerTiming\Stopwatch;

$container = $app->getContainer();

$checkProxyHeaders = true; // Note: Never trust the IP address for security processes!
$trustedProxies = ['10.0.0.1', '10.0.0.2']; // Note: Never trust the IP address for security processes!
$app->add(new \RKA\Middleware\IpAddress($checkProxyHeaders, $trustedProxies));

$container[ "Stopwatch" ] = function ($container) {
	return new Stopwatch;
};

$container[ "ServerTiming" ] = function ($container) {
	return new ServerTiming($container[ "Stopwatch" ]);
};

//$container["DummyMiddleware"] = function ($container) {
//	return function ($request, $response, $next) {
//		usleep(200000);
//		return $next($request, $response);
//	};
//};

//$app->add("DummyMiddleware");


$container[ "HttpBasicAuthentication" ] = function ($container) {
	return new HttpBasicAuthentication([
		"logger"  => $container[ "logger" ],
		"path"    => "/token",
		"relaxed" => ["127.0.0.1", "localhost", "dev.example.com"],
		"error"   => function ($request, $response, $arguments) use ($container) {
			$myLogger = $container->get("logger");
			$myLogger->alert($arguments[ "message" ]);
			$problem = new ApiProblem($arguments[ "message" ], "about:blank");
			$problem->setStatus(401);

			return $response
				->withHeader("Content-type", "application/problem+json")
				->write($problem->asJson(true));
		},
		"users"   => [
			"test" => "test"
		]
	]);
};

$container[ "JwtAuthentication" ] = function ($container) {
	return new JwtAuthentication([
		"logger"      => $container[ "logger" ],
		"path"        => "/",
		"passthrough" => ["/api/v1/token", "/api/v1/info", "/api/v1/dump", "/api/v1/version", "/api/v1/hc", "/api/v1/dumptoken"],
		"secret"      => getenv('JWT_SECRET'),
		"secure"      => getenv('JWT_AUTH_SECURE'),
		"relaxed"     => ["127.0.0.1", "localhost", "dev.example.com"],
		"error"       => function ($request, $response, $arguments) use ($container) {
			$myLogger = $container->get("logger");
			$myLogger->critical($arguments[ "message" ]);
			$problem = new ApiProblem($arguments[ "message" ], "about:blank");
			$problem->setStatus(401);

			return $response
				->withHeader("Content-type", "application/problem+json")
				->write($problem->asJson(true));
		},
		"callback"    => function ($request, $response, $arguments) use ($container) {
			$container[ "token" ] = new Token();
			$container[ "token" ]->hydrate($arguments[ "decoded" ]);
		}
	]);
};

$container[ "Cors" ] = function ($container) {
	return new Cors([
		"logger"         => $container[ "logger" ],
		"origin"         => ["*"],
		"methods"        => ["GET", "POST", "PUT", "PATCH", "DELETE"],
		"headers.allow"  => ["Authorization", "If-Match", "If-Unmodified-Since"],
		"headers.expose" => ["Authorization", "Etag"],
		"credentials"    => true,
		"cache"          => 60,
		"error"          => function ($request, $response, $arguments) {
			$data[ "status" ] = "error";
			$data[ "message" ] = $arguments[ "message" ];

			return $response
				->withHeader("Content-Type", "application/json")
				->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		}
	]);
};

$container[ "Negotiation" ] = function ($container) {
	return new NegotiationMiddleware([
		"logger" => $container[ "logger" ],
		"accept" => ["application/json"]
	]);
};


$container[ "csrf" ] = function ($container) {
	return new Guard;
};

$container[ "cache" ] = function ($container) {
	return new CacheUtil;
};




$app->add("HttpBasicAuthentication");
$app->add("JwtAuthentication");
$app->add(new ApiAuditMiddleware($container));
$app->add("Cors");
$app->add("Negotiation");
$app->add("ServerTiming");

