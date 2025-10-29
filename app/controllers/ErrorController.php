<?php
namespace App\Controllers;

use Core\Controller;

class ErrorController extends Controller
{
    public function notFound(): void
    {
        $this->render('errors/404', ['title' => 'Page non trouvée']);
    }

    public function forbidden(): void
    {
        $this->render('errors/403', ['title' => 'Accès interdit']);
    }
}
