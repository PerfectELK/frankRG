<?

namespace App;

use App\Route\Api\V1;
use App\Route\Pages\Index;

class Router{


    public static function parseUrl(){
        $_ru = explode('?', ($_SERVER['REQUEST_URI']));
        $req_url = explode('/', urldecode($_ru[0]));
        $res = array_values(array_diff($req_url, array('', null)));

        return $res;
    }

    public function run($parsed){
        if(!count($parsed)){
            $class = new Index();
            $class($parsed);
        }else if(in_array('api', $parsed) && in_array('v1', $parsed)){
            $class = new V1();
            $class($parsed);
        }else{
            $className = 'App\\Route\\Pages\\' . implode('\\', array_map(function($item){
                return ucfirst($item);
            },$parsed));

            $ds = DIRECTORY_SEPARATOR;
            $dirFilePath = __DIR__ . "{$ds}Route{$ds}Pages{$ds}" . implode($ds, array_map(function($item){
                return ucfirst($item);
            },$parsed)) . '.php';

            if(file_exists($dirFilePath)){
                $class = new $className();
                $class($parsed);
            }

        }
    }

}