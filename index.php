<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    define("HOST", "192.168.1.101");
    define("USERNAME", "sangkayabackenddba");
    define("PASSWORD", "4^g-ksbo");
    define("DBNAME", "sangkayabackenddb");
 
    require 'vendor/autoload.php';
    // Create and configure Slim app
    $config = ['settings' => [
        'addContentLengthHeader' => false,
    ]];
    $app = new \Slim\App($config);

    // Define app routes
    $app->get('/jtask/{id}', function ($request, $response, $args) {
        $id = $args['id'];
        $conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);
        $result = $conn->query('select * from rtj_tbl where rtj_id='.$id);
        $data = $result->fetch_assoc();
        $conn -> close();
        $response=json_encode($data,JSON_UNESCAPED_UNICODE);
        return $response;
    });

    $app->get('/jtask', function ($request, $response, $args) {
        $conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);
        $result = $conn->query('select * from rtj_tbl');
        while ($row = $result->fetch_assoc()){
            $data[]=$row;
        }
        $conn -> close();
        $response=json_encode($data,JSON_UNESCAPED_UNICODE);
        return $response;
    });

    $app->post('/jtask', function ($request, $response, $args) {
       
        $bodyparam = $request->getParsedBody(); //return with array
        $bodyraw = $request->getBody();     //return with text stream

      
        print_r($bodyparam) ;
        echo $bodyraw;


    });



// Run app
$app->run();


?>