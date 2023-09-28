<?php

namespace App\Controllers;

use App\Utils\View;

class ViewController{


    public function index(){

        echo View::render('pages/index');

    }

}