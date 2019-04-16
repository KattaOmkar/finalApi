<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../includes/DbOperations.php';

$app = new \Slim\App([
    'settings'=>[
        'displayErrorDetails'=>true
    ]
]);
// $app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
//     $name = $args['name'];
//     $response->getBody()->write("Hello, $name");

//     $db = new DbConnect;
//     if($db->connect() != NULL){
//         echo '\r  \n Connection Successful';
//     }else{
//         echo '\n Connection Failed!';
//     }

//     return $response;
// });
$app->post('/spend_up', function(Request $request, Response $response){
    $request_data = $request->getParsedBody();
    $date = $request_data['date'];
    $reason = $request_data['reason'];
    $amount = $request_data['amount'];

    $db = new DbOperations;
    $result = $db->createSpend($date,$reason,$amount);

    if($result == Added){
        $response->write(json_encode('Spend added successfully!'));

        return $response
                    ->withHeader('Content-type', 'application/json')
                    ->withStatus(201);
    }
    elseif($result == NotAdded){
        $response->write(json_encode('SPend Not Added Successfully'));

        return $response
                    ->withHeader('Content-type', 'application/json')
                    ->withStatus(201);
    }
    $response->write(json_encode('SPend Not Added Successfully'));

    // return $response->withHeader('Content-type','Application-json')
    //                 ->withStatus(401);
    

});

$app->post('/receive_up', function(Request $request, Response $response){
    $request_data = $request->getParsedBody();
    $date = $request_data['date'];
    $from_reason = $request_data['from_reason'];
    $amount = $request_data['amount'];

    $db = new DbOperations;
    $result = $db->createReceive($date,$from_reason,$amount);

    if($result == Added){
        $response->write(json_encode('Receive added successfully!'));

        return $response
                    ->withHeader('Content-type', 'application/json')
                    ->withStatus(201);
    }
    elseif($result == NotAdded){
        $response->write(json_encode('Receive Not Added Successfully'));

        return $response
                    ->withHeader('Content-type', 'application/json')
                    ->withStatus(201);
    }
    $response->write(json_encode('Receive Not Added Successfully'));

    // return $response->withHeader('Content-type','Application-json')
    //                 ->withStatus(401);
    

});

$app->get('/spending', function(Request $request, Response $response){
    $db = new DbOperations; 
    $spends = $db->getAllSpends();
    $response_data = array();
    //$response_data['error'] = false; 
    $response_data['spends'] = $spends; 
    $response->write(json_encode($response_data));
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);  

});

$app->get('/receiving', function(Request $request, Response $response){
    $db = new DbOperations; 
    $receives = $db->getAllReceives();
    $response_data = array();
    //$response_data['error'] = false; 
    $response_data['receives'] = $receives; 
    $response->write(json_encode($response_data));
    return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);  

});

$app->run();