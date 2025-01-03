<?php

function basePath($path = '') {
    return __DIR__ . '/' . $path;
}


function loadView($path, $data = []) {
    $viewPath = basePath("App/views/{$path}.view.php");
    if (file_exists($viewPath)){
        extract($data);
        require $viewPath;
    }
    else{
        echo "View {$path} not found";
    }
}

function loadPartials($path) {
    $partialPath = basePath("App/views/partials/{$path}.php");

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


function formatSalary($salary) {
    return '$' . number_format(floatval($salary));
}

?>



