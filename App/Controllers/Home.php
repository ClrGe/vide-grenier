<?php

namespace App\Controllers;

use App\Models\Articles;
use Core\Controller;
use Core\View;
use Exception;

/**
 * Home controller
 */
class Home extends Controller
{

    /**
     * Affiche la page d'accueil
     *
     * @return void
     * @throws Exception
     */

    /**
     * @OA\Get (
     *     path="/",
     *     @OA\Response(response="200", description="Display the home page"),
     *     tags={"Home"}
     *)
     */
    public function indexAction()
    {

        View::renderTemplate('Home/index.html', []);
    }
}
