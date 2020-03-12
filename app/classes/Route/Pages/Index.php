<?
namespace App\Route\Pages;

use App\Vendor\Route;
use App\Vendor\Tree;
use App\Viewer;

class Index extends Route {


    public function __invoke($parsed = array())
    {
        $viewer = Viewer::getInstance();

        $tree = Tree::buildTreeArray();

        $viewer->renderPage('index',['tree' => $tree]);
    }


}