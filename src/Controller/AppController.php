<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{
    public function index()
    {
        return $this->render('app/page.html.twig');
    }

    public function kek($keks)
    {
        return $this->render('app/kek.html.twig', ['keks' => $keks]);
    }

    public function getUser()
    {

    }

    /**
     * @Rest\Get("api/currencies")
     */
    public function getCurrencies()
    {
        $token = $this->container->get('security.token_storage')->getToken();
        $current_user = $token->getUser();
        $restresult = $this->getDoctrine()->getRepository('App:Currency')->findByCreatedBy($current_user);
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
}