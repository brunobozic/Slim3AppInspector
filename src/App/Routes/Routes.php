<?php

$app->post("/api/v1/token", 'App\Endpoints\TokenEndpoint::getToken');



$app->get('/api/v1/user', 'App\Endpoints\UserEndpoint:all');
$app->get('/api/v1/user/{username}', 'App\Endpoints\UserEndpoint:one');


/* This is just for debugging, not usefull in real life. */
$app->get("/api/v1/dump", function ($request, $response, $arguments) {
	print_r($this->token);
});

$app->get("/api/v1/info", function ($request, $response, $arguments) {
	phpinfo();
});

// Protection from clever bastards
$app->get("/", function ($request, $response, $arguments) {
	print "Here be dragons";
});

$app->get('/api/v1/portal', 'App\Endpoints\PortalEndpoint:all');
$app->get('/api/v1/portal/{icao}', 'App\Endpoints\PortalEndpoint:get');
$app->post("/api/v1/portal", 'App\Endpoints\PortalEndpoint:create');
$app->patch("/api/v1/portal/{icao}", 'App\Endpoints\PortalEndpoint:patch');
$app->delete("/api/v1/portal/{icao}", 'App\Endpoints\PortalEndpoint:delete');
$app->put("/api/v1/portal/{icao}", 'App\Endpoints\PortalEndpoint:put');

$app->get('/api/v1/version', 'App\Endpoints\Base::getVersion');






//$app->get('/api/v1/auth', 'App\Endpoints\Auth::actionAuth');
//$app->get('/api/v1/hc', 'App\Endpoints\HealthCheckEndpoint::checkHealth');
//$app->get('/api/v1/hcpulse/portal/{icao}', 'App\Endpoints\PortalHCPulseEndpoint::fetchPerPortalPulseResult');
//$app->get('/api/v1/hcpulse/portals/', 'App\Endpoints\PortalHCPulseEndpoint::fetchAllPulseResults');