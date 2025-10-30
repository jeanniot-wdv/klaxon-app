<?php
namespace App\Controllers\Admin;

use App\Models\Trajet;
use Core\Controller;
use Core\Middleware\AdminMiddleware;

class TrajetController extends Controller
{
    public function index(): void
    {
        AdminMiddleware::requireAdmin();
        $trajets = Trajet::getAllWithPagination(1, 100); // Tous les trajets sans pagination
        $this->render('admin/trajets/index', [
            'title' => 'Gestion des trajets',
            'trajets' => $trajets['trajets']
        ]);
    }
}
