<?php

function basePath($path = '') {
    return __DIR__ . '/' . $path;
}


function loadView($path) {
    $viewPath = basePath("views/{$path}.view.php");
    if (file_exists($viewPath)){
        require $viewPath;
    }
    else{
        echo "View {$path} not found";
    }
}

function loadPartials($path) {
    $partialPath = basePath("views/partials/{$path}.php");

    if (file_exists($partialPath)){
        require $partialPath;
    }
    else{
        echo "Partial {$path} not found";
    }
}

function inspect($value){
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

function inspectAndDie($value){
    echo "<pre>";
    die(var_dump($value));
    echo "</pre>";
}


?>



