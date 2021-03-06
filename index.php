<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);

//Required files
require_once('vendor/autoload.php');
require_once('model/db-functions.php');

//Create an instance of the Base class
$f3 = Base::instance();
$f3->set('DEBUG', 3);

//Connect to the database
$dbh = connect();

//Define a default route
$f3->route('GET /', function($f3) {

    $students = getStudents();
    $f3->set('students', $students);

    //load a template
    $template = new Template();
    echo $template->render('views/all-students.html');
});

//Define a route to add a student
$f3->route('GET|POST /add', function($f3) {

    //print_r($_POST);
    /*
     * Array (  [sid] => 5678
     *          [last] => Shin
     *          [first] => Jen
     *          [birthdate] => 2000-08-08
     *          [gpa] => 4.0
     *          [advisor] => 1
     *          [submit] => Submit )
     */

    if(isset($_POST['submit'])) {

        //Get the form data
        $sid = $_POST['sid'];
        $last = $_POST['last'];
        $first = $_POST['first'];
        $birthdate = $_POST['birthdate'];
        $gpa = $_POST['gpa'];
        $advisor = $_POST['advisor'];

        //Validate the data

        //Add the student
        $success = addStudent($sid, $last, $first, $birthdate,
            $gpa, $advisor);
        if($success) {
            $f3->reroute('/');
        }
    }

    //load a template
    $template = new Template();
    echo $template->render('views/add-student.html');
});

//Run fat free
$f3->run();
