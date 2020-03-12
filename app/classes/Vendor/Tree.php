<?
namespace App\Vendor;


class Tree{

    public static function buildTreeArray($dir = ''){
        $ds = DIRECTORY_SEPARATOR;
        $arr = [];
        $is_first = false;
        if(!strlen($dir)){
            $is_first = true;
            $dir = "{$_SERVER['DOCUMENT_ROOT']}{$ds}var{$ds}repository{$ds}";
            $__arr = [
                [
                    'name' => '/',
                    'type' => 'dir',
                    'path' => $dir,
                    'children' => [],
                    'is_root' => true,
                ]
            ];
            $arr = &$__arr[0]['children'];
        }

        if(is_dir($dir)){

            $__dir = opendir($dir);
            while(($file = readdir($__dir)) !== false){
                if($file == '.' || $file == '..') continue;
                if(is_dir($dir.$file)){
                    $arr[] = [
                        'name' => $file,
                        'type' => 'dir',
                        'path' => $dir.$file,
                        'children' => static::buildTreeArray($dir.$file.$ds)
                    ];
                }
                if(is_file($dir.$file)){
                    $arr[] = [
                        'name' => $file,
                        'type' => 'file',
                        'path' => $dir.$file
                    ];
                }
            }
            closedir($__dir);


        }
        return ($is_first) ? $__arr : $arr;


    }


    public static function renderTree($treeArr){
        $html = '<ul class="tree">';
        foreach ($treeArr as $element){
            if($element['type'] == 'file'){
                $downloadLink = strstr($element['path'],'var');
                $shortName = mb_substr($element['name'],0, 15);

                $__html = "<li class='file'>";
                $name = "<i class='fas fa-file-alt'></i><p data-destination='{$element['path']}' class='pelk__name' title='{$element['name']}'>{$shortName}</p>";
                $download = "<a title='Download file' href='$downloadLink' download><i class='fas fa-save'></i></a>";
                $remove = "<a title='Remove file' class='remove remove__file' data-destination='{$element['path']}' href='javascript:void(0)'><i class='fas fa-trash-alt'></i></a>";
                $__html .= "{$name}{$download}{$remove}</li>";
            }else{
                $__html = "<li class='dir'>";
                $name = "<i class='fas fa-folder'></i><p title='{$element['name']}' data-destination='{$element['path']}' class='pelk__name'>{$element['name']}</p>";
                $createDir = "<a title='Create dir' class='pelk__create-dir' data-destination='{$element['path']}'><i class='fas fa-plus'></i></a>";
                $uploadFile = "<a title='Upload file' href='javascript:void(0)' class='pelk__upload-file' data-destination='{$element['path']}'><i class='fas fa-file-upload'></i></a>";
                $remove = (!$element['is_root']) ? "<a title='Remove dir' class='remove remove__dir' data-destination='{$element['path']}' href='javascript:void(0)'><i class='fas fa-trash-alt'></i></a>" : '';
                $children = (count($element['children'])) ? static::renderTree($element['children']) : '';
                $__html .= "{$name}{$createDir}{$uploadFile}{$remove}{$children}</li>";
            }
            $html .= "{$__html}";
        }
        $html .= "</ul>";

        return $html;
    }


}