<?

namespace App\Route\Api\Tree;


use App\Vendor\Tree;

class Get{

    public function __invoke($data,&$response)
    {

        $tree = Tree::renderTree(Tree::buildTreeArray());

        $response['data']['tree'] = $tree;

    }


}