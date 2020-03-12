<?

namespace App\Route\Api\Entity;

class Delete
{

    private $dir = null;

    public function __invoke($data, &$response)
    {

        if ($data['type'] == 'file') {
            unlink($data['path']);
        } else {
            $this->dir = $data['path'];
            $tree = $this->buildTreeArray();
            if(!count($tree)){
                rmdir($this->dir);
            }else{
                $this->removeDirs($tree);
                rmdir($this->dir);
            }

        }
        $response['data']['removed'] = true;

    }

    private function removeDirs($tree)
    {


        foreach ($tree as $element) {

            if ($element['type'] == 'file') {
                unlink($element['path']);
            }else{
                if(count($element['children'])){
                    $this->removeDirs($element['children']);
                }
                rmdir($element['path']);
            }


        }

    }

    private function buildTreeArray($dir = '')
    {
        $ds = DIRECTORY_SEPARATOR;
        $arr = [];
        if (!strlen($dir)) {
            $dir = $this->dir.$ds;
        }

        if (is_dir($dir)) {
            $__dir = opendir($dir);
            while (($file = readdir($__dir)) !== false) {
                if ($file == '.' || $file == '..') continue;
                if (is_dir($dir . $file)) {
                    $arr[] = [
                        'name' => $file,
                        'type' => 'dir',
                        'path' => $dir . $file,
                        'children' => $this->buildTreeArray($dir . $file . $ds)
                    ];
                }
                if (is_file($dir . $file)) {
                    $arr[] = [
                        'name' => $file,
                        'type' => 'file',
                        'path' => $dir . $file
                    ];
                }
            }
            closedir($__dir);


        }
        return $arr;


    }


}