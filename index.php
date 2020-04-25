<?php

    // error_reporting(E_ALL);
    // ini_set('display_errors', 'On');

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
       
        $bodyparam = $request->getParsedBody(); 
        $rjt_commander=$bodyparam['commander'];
        $rtj_reciver=$bodyparam['reciver'];
        $rtj_detail=$bodyparam['detail'];
        $rtj_type=$bodyparam['type'];
        $rtj_date=date("Y-m-d-H-i-s"); 
        $rtj_group=$bodyparam['group'];
        if($rjt_commander&$rtj_reciver&$rtj_detail&$rtj_type&$rtj_group){
            $conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);
            $result = $conn->query("INSERT INTO `sangkayabackenddb`.`rtj_tbl` (`rtj_commander`, `rtj_reciver`, `rtj_detail`, `rtj_type`, `rtj_date`, `rtj_group`)
            VALUES ('$rjt_commander', '$rtj_reciver', '$rtj_detail', '$rtj_type', '$rtj_date', '$rtj_group');");       
            $conn -> close();
            $response=json_encode($result,JSON_UNESCAPED_UNICODE);
            return $response;
        }
        else{
            $errmsg="ส่งตัวแปรมาไม่ครบจ้า";
            $response=json_encode($errmsg,JSON_UNESCAPED_UNICODE);
            return $response;

        }
        
    });

// Run app
$app->run();

// $app->post('/jtask', function ($request, $response, $args) {
       
//     $bodyparam = $request->getParsedBody(); //return with array
//     $bodyraw = $request->getBody();     //return with text stream

  
//     print_r($bodyparam) ;
//     echo $bodyraw;


// });

?>



