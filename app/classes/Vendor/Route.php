<?

namespace App\Vendor;

abstract class Route{

    public function __invoke($parsed = array()){

        var_dump($parsed);

    }


}