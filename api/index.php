<?php
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: *");
    require_once('controllers/ProductController.php');
    use controllers\ProductController;

    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents('php://input'), true);
    $product = new ProductController();
    if (isset($_POST['method'])) {
        $method = $_POST['method'];
    }
    
    switch ($method) {
        case 'GET':
            if (isset($data['id'])) {
               $res = $product->readById($data['id']);
               if (count($res) > 0) {
                echo json_encode($res);
               } else {
                echo json_encode(["menssage" => "No products found"]);
               }
               
            } else {
                $res = $product->read();
                if (count($res) > 0) {
                    echo json_encode($res);
                   } else {
                    echo json_encode(["menssage" => "No products found"]);
                   } 
            }
            
            break;
        case 'POST':
            $res = $product->create($_POST['nombre'], $_POST['precio'], $_POST['stock']);
            echo $res;
            break;
        case 'PUT':
            $res = $product->update($_POST['id'], $_POST['nombre'], $_POST['precio'], $_POST['stock']);
            echo $res;
            break;
        case 'DELETE':
            if (isset($_POST['id'])) {
                $res = $product->delete($_POST['id']);
                if ($res = true) {
                    echo json_encode(["menssage" => "products deleted"]);
                } else {
                 echo json_encode(["menssage" => "The products could not be deleted"]);
                }
                
             } else {
                     echo json_encode(["menssage" => "No products found"]);
             }
            break;
        

    }
    
?>