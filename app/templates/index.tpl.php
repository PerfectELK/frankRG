<?
$tree = $param['tree'];

?>
<main>
    <div class="tree-container">
        <?
        echo \App\Vendor\Tree::renderTree($tree);
        ?>
    </div>
    <input style="display: none;" type="file" class="pelk__file-upload">
</main>