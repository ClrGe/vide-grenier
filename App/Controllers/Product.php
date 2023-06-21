<?php

namespace App\Controllers;

use App\Models\Articles;
use App\Utility\Upload;
use Core\Controller;
use Core\View;
use Exception;

/**
 * Product controller
 */
class Product extends Controller
{

    /**
     * Affiche la page d'ajout
     * @return void
     */
    public function indexAction()
    {

        if(isset($_POST['submit'])) {

            try {
                $f = $_POST;     
                
                $file = $_FILES['picture'];

                if($file['error'] > 0){
                    throw new Exception("Erreur dans l'upload de cette image");
                }

                if ($file['size'] > 4000000) {
                    throw new Exception("File exceeds maximum size (4MB)");
                }

                $fileExtensionsAllowed = ['jpeg', 'jpg', 'png'];
                $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                
                if (!in_array(strtolower($fileExtension), $fileExtensionsAllowed)) {
                    throw new Exception("This file extension is not allowed. Please upload a JPEG or PNG file");
                }

                $f['user_id'] = $_SESSION['user']['id'];
                $id = Articles::save($f);

                // TODO: Validation
                $pictureName = Upload::uploadFile($file, $id, $fileExtension);
                
                Articles::attachPicture($id, $pictureName);

                header('Location: /product/' . $id);

                
            } catch (Exception $e){
                    print_r($e->getMessage());
            }
        }

        View::renderTemplate('Product/Add.html');
    }

    /**
     * Affiche la page d'un produit
     * @return void
     */
    public function showAction()
    {
        $id = $this->route_params['id'];

        try {
            Articles::addOneView($id);
            $suggestions = Articles::getSuggest();
            $article = Articles::getOne($id);
        } catch(Exception $e){
            var_dump($e);
        }

        View::renderTemplate('Product/Show.html', [
            'article' => $article[0],
            'suggestions' => $suggestions
        ]);
    }
}
