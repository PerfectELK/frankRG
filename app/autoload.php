<?

spl_autoload_register(function($class) {

    $class = str_replace(ucfirst('App') . '\\', '', $class);

    $ds = DIRECTORY_SEPARATOR;

    $file = __DIR__ . $ds . 'classes' . $ds . str_replace('\\', $ds, $class) . '.php';


    if (file_exists($file)) {
        require($file);
        return true;
    }

    return false;

});