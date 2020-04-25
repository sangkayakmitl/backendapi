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

        $rtj_commander=$bodyparam['commander'];
        $rtj_reciver=$bodyparam['reciver'];
        $rtj_detail=$bodyparam['detail'];
        $rtj_type=$bodyparam['type'];
        $rtj_date=date("Y-m-d-H-i-s"); 
        $rtj_group=$bodyparam['group'];

        if($rtj_commander&$rtj_reciver&$rtj_detail&$rtj_type&$rtj_group){
            $conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);
            $result = $conn->query("INSERT INTO `sangkayabackenddb`.`rtj_tbl` (`rtj_commander`, `rtj_reciver`, `rtj_detail`, `rtj_type`, `rtj_date`, `rtj_group`)
            VALUES ('$rtj_commander', '$rtj_reciver', '$rtj_detail', '$rtj_type', '$rtj_date', '$rtj_group');");       
            $conn -> close();
            $status = $response->getStatusCode();
            $response=json_encode($status,JSON_UNESCAPED_UNICODE);
            return $response;
        }
        else{
            $status = array('status' => "missing variable");
            $response=json_encode($status,JSON_UNESCAPED_UNICODE);
            return $response;
        }
    });

    $app->put('/jtask/{id}', function ($request, $response, $args) {
        $bodyparam = $request->getParsedBody(); 
        $rtj_id = $args['id'];
        $rtj_commander=$bodyparam['commander'];
        $rtj_reciver=$bodyparam['reciver'];
        $rtj_detail=$bodyparam['detail'];
        $rtj_type=$bodyparam['type'];
        $rtj_date=date("Y-m-d-H-i-s"); 
        $rtj_group=$bodyparam['group'];

        if($rtj_commander&$rtj_reciver&$rtj_detail&$rtj_type&$rtj_group){
            $conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);
            if($rtj_commander)  {$result = $conn->query("update rtj_tbl set rtj_commander = '$rtj_commander' where rtj_id = '$rtj_id'");}
            if($rtj_reciver)    {$result =   $conn->query("update rtj_tbl set rtj_reciver = '$rtj_reciver' where rtj_id = '$rtj_id'");}
            if($rtj_detail)     {$result = $conn->query("update rtj_tbl set rtj_detail = '$rtj_detail' where rtj_id = '$rtj_id'");}
            if($rtj_type)       {$result = $conn->query("update rtj_tbl set rtj_type = '$rtj_type' where rtj_id = '$rtj_id'");}
            if($rtj_group)      {$result = $conn->query("update rtj_tbl set rtj_group = '$rtj_group' where rtj_id = '$rtj_id'");}

            $result = $conn->query("update rtj_tbl set rtj_date = '$rtj_date' where rtj_id = '$rtj_id'");
            $conn -> close();
            $status = $response->getStatusCode();
            $response=json_encode($status,JSON_UNESCAPED_UNICODE);
            return $response;
        }
        else{
            $status = array('status' => "missing variable");
            $response=json_encode($status,JSON_UNESCAPED_UNICODE);
            return $response;
        }
    });

    $app->delete('/jtask/{id}', function ($request, $response, $args) {
        $bodyparam = $request->getParsedBody(); 
        $rtj_id = $args['id'];
        $rtj_confirm=$bodyparam['confirm'];

        if($rtj_confirm){
            $conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);
            if($rtj_confirm == "yes")  {
                $result = $conn->query("delete from rtj_tbl where `rtj_id` = '$rtj_id'");
            }
            else{
                $status = array('status' => "confirm action wrong");
                $response=json_encode($status,JSON_UNESCAPED_UNICODE);
                return $response;
            }
            $conn -> close();
            $status = $response->getStatusCode();
            $response=json_encode($status,JSON_UNESCAPED_UNICODE);
            return $response;
        }
        else{
            $status = array('status' => "please confirm action");
            $response=json_encode($status,JSON_UNESCAPED_UNICODE);
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