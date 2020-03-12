<?

namespace App\Route\Api\Entity;

class Rename
{

    private $dir = null;

    public function __invoke($data, &$response)
    {

        $path = $data['path'];
        $newName = $data['new_name'];

        $pathNewName = explode('/',str_replace('\\','/',$path));
        array_pop($pathNewName);
        $pathNewName = implode('\\',$pathNewName) . DIRECTORY_SEPARATOR . $newName;

        if(file_exists($path)){
            rename($path,$pathNewName);
        }

        $response['data']['renamed'] = true;




    }
}