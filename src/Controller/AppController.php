<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Currency;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{
    public function index()
    {
        return $this->render('app/page.html.twig');
    }

    /**
     * @Rest\Get("api/currencies")
     */
    public function getCurrencies()
    {
        $token = $this->container->get('security.token_storage')->getToken();
        $current_user = $token->getUser();
        $restresult = $this->getDoctrine()->getRepository('App:Currency')->findAllCurrenciesForUser($current_user);
        if ($restresult === null) {
            return new View("there are no currencies for this user", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Post("api/currencies")
     */
    public function newCurrency(Request $request){
        $currency = new Currency();
        $currency->setAmount($request->get('amount'));
        $currency->setName($request->get('name'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($currency);
        $em->flush();

    }

    /**
     * @Rest\Put("api/currencies/{id}")
     */
    public function updateCurrency(Request $request,  Currency $currency){
        $data = json_decode($request->getContent(), true);
        $currency->setAmount($data['amount']);
        $currency->setName($data['name']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($currency);
        $em->flush();

    }

    /**
     * @Rest\Delete("api/currencies/{id}")
     */
    public function DeleteCurrency(Request $request, Currency $currency){
        $em = $this->getDoctrine()->getManager();
        $em->remove($currency);
        $em->flush();
    }

}