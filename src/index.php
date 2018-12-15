<?php

namespace SwooleTest;

require_once 'bootstrap.php';

use SwooleTest\Response as GQLResponse;

/** @var \Swoole\Http\Server $http */
$http = new \swoole_http_server("localhost", 9501);

$http->on('request', function (\Swoole\Http\Request $request, $response) {

    if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
        $rawBody     = $request->rawContent();
        $requestData = json_decode($rawBody ?: '', true);
    } else {
        $requestData = $request->post;
    }

    $query = isset($requestData['query']) ? $requestData['query'] : null;
    $variables = isset($requestData['variables']) ? $requestData['variables'] : null;

    $gqlResponse = new GQLResponse([
        'query' => $query,
        'variables' => $variables
    ]);

    $result = json_encode($gqlResponse->get());

    $response->end($result);
});

$http->start();





