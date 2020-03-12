<?


namespace App\Route\Api\Dirs;

class Create
{


    public function __invoke($data, &$response)
    {

        $directory = $data['path'].DIRECTORY_SEPARATOR.$data['dir_name'];
        mkdir($directory);
        $response['data']['created'] = true;

    }


}