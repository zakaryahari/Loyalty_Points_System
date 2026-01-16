<?php

namespace App\Controllers;

class BaseController {
    protected $db;
    protected $twig;

    public function __construct($db, $twig) {
        $this->db = $db;
        $this->twig = $twig;
    }

    public function render($template, $data = []) {
        echo $this->twig->render($template, $data);
    }
}