<?php
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: *");
    require_once('controllers/CarroController.php');
    use controllers\CarroController;

    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents('php://input'), true);
    $carro = new CarroController();
    
    switch ($method) {
        case 'GET':
            if (isset($data['id'])) {
               $res = $carro->readById($data['id']);
               if (count($res) > 0) {
                echo json_encode($res);
               } else {
                echo json_encode(["menssage" => "No cars found"]);
               }
               
            } else {
                $res = $carro->read();
                if (count($res) > 0) {
                    echo json_encode($res);
                   } else {
                    echo json_encode(["menssage" => "No cars found"]);
                   } 
            }
            
            break;
        case 'POST':
            $res = $carro->create($data['marca'], $data['color'], $data['puertas'], $data['year']);
            echo $res;
            break;
        case 'PUT':
            $res = $carro->update($data['id'], $data['marca'], $data['color'], $data['puertas'], $data['year']);
            echo $res;
            break;
        case 'DELETE':
            if (isset($data['id'])) {
                $res = $carro->delete($data['id']);
                if ($res = true) {
                    echo json_encode(["menssage" => "Car deleted"]);
                } else {
                 echo json_encode(["menssage" => "The car could not be deleted"]);
                }
                
             } else {
                     echo json_encode(["menssage" => "No cars found"]);
             }
            break;
        

    }
    
?>