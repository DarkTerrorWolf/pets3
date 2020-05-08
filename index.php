<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('model/validation-functions.php');

//F3 class
$f3 = Base::instance();

//$f3->set('colors', array('pink', 'green', 'blue'));

//Route
$f3->route('GET /', function () {
    //echo "<h1>Hello World!</h1>";
    $view = new Template();
    echo $view->render("views/home.html");
}
);

$f3->route('GET|POST /order', function ($f3) {
    $colors = array('Red','Blue','Brown','Pink','Black');
    $f3 ->set('colors',$colors);
    session_start();
    $_SESSION = array();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $animal = $_POST['animal'];
        $color = $_POST['color'];
        if (validString($animal)&& validColor($color)) {
            $_SESSION['animal'] = $animal;
            $_SESSION['color'] = $color;
            $f3->reroute('results');
        } else {
            $f3->set("errors['animal']", "Please enter an animal.");
        }
    }
    $template = new Template();
    echo $template->render('views/orderform.html');
}
);
$f3->route('GET /results', function () {
    $template = new Template();
    echo $template->render('views/results.html');
});
$f3->route('GET /order', function()
{
    $view = new Template();
    echo $view->render('views/orderform.html');
});

$f3->route('GET|POST /form2', function () {
    //echo "<h1>Hello World!</h1>";
    $view = new Template();
    echo $view->render("views/results.html");
    session_destroy();
}
);

$f3->run();