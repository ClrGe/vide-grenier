<?php


namespace App\Controllers;

use App\Config;
use App\Model\UserRegister;
use App\Models\Articles;
use App\Utility\Hash;
use App\Utility\Session;
use Core\Controller;
use Core\View;
use Exception;
use http\Env\Request;
use http\Exception\InvalidArgumentException;


/**
 * User controller
 */

/**
 * @OA\Info(title="API", version="0.1")
 * @OA\Server(url="http://localhost:8080")
 * @OA\SecurityScheme(
 *     securityScheme="session",
 *     type="apiKey",
 *     in="header",
 *     name="PHPSESSID"
 * )
 */


class User extends Controller
{
     public function loginAction()
    {
        if(isset($_POST['submit'])){
            $f = $_POST;
            $this->login($f);

            // Si login OK, redirige vers le compte
            header('Location: /account');
        }

        View::renderTemplate('User/login.html');
    }


    public function registerAction()
    {
        if(isset($_POST['submit'])){
            $f = $_POST;

            if($f['password'] !== $f['password-check']){
                // display error
                throw new InvalidArgumentException('Les mots de passe ne correspondent pas');
            }

            // validation

            $this->register($f);

            if ($this->login($f)){
                header('Location: /account');
            }

        }

        View::renderTemplate('User/register.html');
    }

    /**
     * Affiche la page du compte
     */

    /**
     * @OA\Get(
     *     path="/account",
     *     @OA\Response(response="200", description="Display the user account"),
     *     security={{"session":{}}},
     *     tags={"User"}
     *     )
     */
     public function accountAction()
    {
        $articles = Articles::getByUser($_SESSION['user']['id']);

        View::renderTemplate('User/account.html', [
            'articles' => $articles
        ]);
    }
    /*
     * Fonction privée pour enregister un utilisateur
     */
    /**
     * @OA\Post(
     *     path="/register",
     *     @OA\Response(response="200", description="Register"),
     *     tags={"User"},
     *     @OA\RequestBody(
     *         description="Register",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="username",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password-check",
     *                     type="string"
     *                 ),
     *                 example={"email": "c@g.c", "username": "c", "password": "c", "password-check": "c"}
     *        ) ) ) ) )
     */

    private function register($data)
    {
        try {
            // Generate a salt, which will be applied to the during the password
            // hashing process.
            $salt = Hash::generateSalt(32);

            $userID = \App\Models\User::createUser([
                "email" => $data['email'],
                "username" => $data['username'],
                "password" => Hash::generate($data['password'], $salt),
                "salt" => $salt
            ]);

            return $userID;

        } catch (Exception $ex) {
            // TODO : Set flash if error : utiliser la fonction en dessous
            /* Utility\Flash::danger($ex->getMessage());*/
        }
    }


    // swagger-php
    /**
     * @OA\Post(
     *     path="/login",
     *     @OA\Response(response="200", description="Login"),
     *     tags={"User"},
     *     @OA\RequestBody(
     *         description="Login",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="password", type="string"),
     *                 @OA\Property(property="remember", type="boolean"),
     *             )
     *         )
     *     )
     * )
     */
    private function login($data)
    {
        try {
            if (!isset($data['email'])) {
                throw new Exception('TODO');
            }

            $user = \App\Models\User::getByLogin($data['email']);

            if (Hash::generate($data['password'], $user['salt']) !== $user['password']) {
                return false;
            }

            // Set cookie if remember me is checked
            if (isset($data['remember'])) {
                $cookie = 'remember_me';
                setcookie($cookie, $user['id'], time() + (86400 * 30), "/");
            }


            $_SESSION['user'] = array(
                'id' => $user['id'],
                'username' => $user['username'],
            );

            return true;

        } catch (Exception $ex) {
            // TODO : Set flash if error
            /* Utility\Flash::danger($ex->getMessage());*/
        }
    }


    /**
     * Logout: Delete cookie and session. Returns true if everything is okay,
     * otherwise turns false.
     * @access public
     * @return boolean
     * @since 1.0.2
     */

    /** @OA\Get(
     *     path="/logout",
     *     tags={"User"},
     *     @OA\Response(response="200", description="Logout")
     * )
     */
    private function logout()
    {
        setcookie('remember_me', null, -1, '/');
        unset($_COOKIE['remember_me']);

        // Destroy all data registered to the session.
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header ("Location: /");

        return true;
    }
}