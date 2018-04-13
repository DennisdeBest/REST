<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function index()
    {
        return $this->render('app/page.html.twig');
    }

    public function kek($keks)
    {
        return $this->render('app/kek.html.twig', ['keks' => $keks]);
    }
}