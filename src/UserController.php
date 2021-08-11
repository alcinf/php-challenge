<?php

//declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
require __DIR__ . '/../config/db.php';
use DB as DB;
use PDO as PDO;
use Slim\Factory\AppFactory;


class UserController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function store(Request $request, Response $response, array $args): Response
    {
        $contentType = $request->getHeaderLine('Content-Type');
        if (strstr($contentType, 'application/json')) {
            $params = json_decode(file_get_contents('php://input'));
        }else 
            $params = (object) array();
        $params->pass = password_hash($params->pass, PASSWORD_DEFAULT);
        //print_r($params->pass); exit;
    
        $sql = 'INSERT INTO users (name, email, pass) VALUES (:name, :email, :pass)';
    
        try {
            $db = new DB;
            $conn = $db->connect();
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $params->name);
            $stmt->bindParam(':email', $params->email);
            $stmt->bindParam(':pass', $params->pass);
    
            $result = $stmt->execute();
            
            $db = null;
    
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
    
        } catch (PDOException $e) {
            $error = array(
                'message' => $e->getMessage()
            );
    
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(401);
        }
    
    
        
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function login(Request $request, Response $response, array $args): Response
    {
        $contentType = $request->getHeaderLine('Content-Type');
        if (strstr($contentType, 'application/json')) {
            $params = json_decode(file_get_contents('php://input'));
        }else 
            $params = (object) array();
        //print_r($_SESSION); exit;
    
        $sql = 'SELECT * FROM users WHERE email = "'.$params->email.'"';
    
        try {
            $db = new DB;
            $conn = $db->connect();
    
            $stmt = $conn->query($sql);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            //print_r($user); exit;
    
            $db = null;

            if(password_verify($params->pass, $user->pass)){
                unset($user->pass);
                $_SESSION['user'] = $user;
                $result = array(
                    'status' => 200
                    ,'data' => array(
                        'message'=> 'User logged'
                        ,'user'=> $user
                    )
                );
            }else{
                unset($_SESSION['user']);
                $result = array(
                    'status' => 400
                    ,'data' => array(
                        'message'=> 'Invalid user or password.'
                        ,'user'=> $params
                    )
                );
            }
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus($result['status']);
    
        } catch (PDOException $e) {
            $error = array(
                'message' => $e->getMessage()
            );
    
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(401);
        }
    
    
        
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function logout(Request $request, Response $response, array $args): Response
    {
        unset($user->pass);
        $_SESSION['user'] = $user;
        $result = array(
            'status' => 200
            ,'data' => array(
                'message'=> 'User logout'
            )
        );
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus($result['status']);
    }




}
