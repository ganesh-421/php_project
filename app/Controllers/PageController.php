<?php

namespace App\Controllers;

class PageController
{
    public function landing()
    {
        require __DIR__ . '/../Views/front/landing.php';
    }
}
