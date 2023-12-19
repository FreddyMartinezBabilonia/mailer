<?php
namespace App\Controllers;

class Templates {
    private $m;

    public function __construct(){
        $this->m = (new \Mustache_Engine(
            [
            'partials_loader' => new \Mustache_Loader_FilesystemLoader('views/partials'),
            ]
        ));
    }

    public function render($template, $data = []) {        
        $template = @file_get_contents('views/'. $template.'.html');
        if($template === false) {
            $template = file_get_contents('views/404.html');
        }
        return $this->m->render($template, $data);
    }

    public function getPageURL() {
        $url = explode('?', $_SERVER['REQUEST_URI']);
        return ($url[0] == '/' ? '/home' : $url[0]);
    }
}