<?php

namespace App\Utils;

class View{

    private static function getContentView(string $viewName){

        $file = __DIR__ . "/../../resources/views/$viewName.html";

        return file_exists($file) ? file_get_contents($file) : null;
    }

    public static function render(string $view, $vars = []){

        $contentView = self::getContentView($view);

        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        }, $keys);

        echo str_replace($keys, array_values($vars), $contentView);
    }

}