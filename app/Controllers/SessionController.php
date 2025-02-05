<?php

namespace App\Controllers;

class SessionController
{
    public function destroy()
    {
        session_destroy();
        header("Location: /login");
    }
}
