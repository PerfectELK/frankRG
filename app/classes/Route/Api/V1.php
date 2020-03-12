<?

namespace App\Route\Api;

class V1 extends \App\Vendor\Route
{

    public function __invoke($parsed = array())
    {

        $data = $_POST;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $resp = $this->buildResponse();
            $className = "App\\Route\\Api\\";
            $className = $className . implode('\\',array_map(function($item){
                return ucfirst($item);
            },explode('_',$data['method'])));
            $class = new $className;
            $class($data, $resp);

            $this->echoResponse($resp);
        }
    }

    private function buildResponse()
    {
        $r = array(
            'data' => array(),
        );
        return $r;
    }

    private function echoResponse($r = array())
    {

        Header('Content-type: application/json;');
        Header('Access-Control-Allow-Credentials: true');

        Header('Access-Control-Allow-Methods: ' . implode(', ', array(
                'GET',
                'HEAD',
                'POST',
                'PUT',
                'DELETE',
                'TRACE',
                'OPTIONS',
            )));

        echo json_encode($r);
    }


}