<?

namespace App;

class Viewer{

    public static $__instance = null;

    private function __construct()
    {

    }

    public static function getInstance()
    {

        $c = static::class;

        if(is_null($c::$__instance)) {
            $c::$__instance = new $c();
        }

        return $c::$__instance;

    }

    public function renderPage($page,$param = []){
        $this->tpl('_/header');
        $this->tpl($page, $param);
        $this->tpl('_/footer');
    }


    public function tpl($tpl = '', $param = array())
    {

        if($tpl) {

            $ds = DIRECTORY_SEPARATOR;

            $tpl_file = __DIR__ . $ds . '..' .$ds . 'templates' . $ds . $tpl . '.tpl.php';

            if (file_exists($tpl_file)) {

                require($tpl_file);

            }
        }
    }



}