<?php

//declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
require __DIR__ . '/../config/db.php';
use DB as DB;
use PDO as PDO;
use Slim\Factory\AppFactory;

class StockController
{
    /**
     * StockController constructor.
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
    public function query(Request $request, Response $response, array $args): Response
    {
        if(!isset($_SESSION['user'])){
            $result = array(
                'status' => 401
                ,'data' => array(
                    'message'=> 'No user logged'
                )
            );
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus($result['status']);
        }
        $code = $request->getQueryParams()['q'];
        $data = $this->get_code_data($code);


        $sql = 'INSERT INTO stock (user_id, name, symbol, open, high, low, close) 
                VALUES (:user_id, :name, :symbol, :open, :high, :low, :close)';

        //print_r($_SESSION['user']->id); exit;
        try {
            $db = new DB;
            $conn = $db->connect();
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $_SESSION['user']->id);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':symbol', $data['symbol']);
            $stmt->bindParam(':open', floatval($data['open']));
            $stmt->bindParam(':high', floatval($data['high']));
            $stmt->bindParam(':low', floatval($data['low']));
            $stmt->bindParam(':close', floatval($data['close']));
    
            $result = $stmt->execute();
            
            $db = null;
    
        } catch (PDOException $e) {
            $error = array(
                'message' => $e->getMessage()
            );
    
            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(401);
        }

        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    }

    private function post_curl($_url, $_data = array()) {
        $mfields = '';
        foreach($_data as $key => $val) { 
           $mfields .= $key . '=' . $val . '&'; 
        }
        rtrim($mfields, '&');
        $pst = curl_init();
     
        curl_setopt($pst, CURLOPT_URL, $_url);
        curl_setopt($pst, CURLOPT_POST, count($_data));
        curl_setopt($pst, CURLOPT_POSTFIELDS, $mfields);
        curl_setopt($pst, CURLOPT_RETURNTRANSFER, 1);
     
        $res = curl_exec($pst);
     
        curl_close($pst);
        return $res;
     }

     private function get_code_data($code){
        $url = 'https://stooq.com/q/l/?s='.$code.'&f=sd2t2ohlcvn&h&e=csv';
        $result = $this->post_curl($url);

        $lines = explode("\n", $result);
        $head = explode(',', trim($lines[0]));
        $row = explode(',', trim($lines[1]));
        $array = array();
        foreach($head as $key => $index)
            $array[strtolower($index)] = $row[$key];
        //echo '<pre>'; print_r($array);
        $new = array(
             'name' => $array['name']
            ,'symbol' => $array['symbol']
            ,'open' => $array['open']
            ,'high' => $array['high']
            ,'low' => $array['low']
            ,'close' => $array['close']
        );
        return $new;
     }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function history(Request $request, Response $response, array $args): Response
    {
        if(!isset($_SESSION['user'])){
            $result = array(
                'status' => 401
                ,'data' => array(
                    'message'=> 'No user logged'
                )
            );
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus($result['status']);
        }
    
        $sql = 'SELECT date, name, symbol, open, high, low, close FROM stock WHERE user_id = "'.$_SESSION['user']->id.'"';
    
        try {
            $db = new DB;
            $conn = $db->connect();
    
            $stmt = $conn->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            $db = null;
            //print_r($result); exit;

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


}
