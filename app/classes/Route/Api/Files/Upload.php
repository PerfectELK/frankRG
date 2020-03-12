<?


namespace App\Route\Api\Files;

class Upload{


    public function __invoke($data,&$response)
    {

        $uploadDir = $data['path'];

        $uploadFile = $uploadDir .DIRECTORY_SEPARATOR. basename($_FILES['file']['name']);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            $response['data']['uploaded'] = true;
        } else {
            $response['data']['uploaded'] = false;
        }

    }


}