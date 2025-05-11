<?php 

namespace App\Controller;

use NamCao\Framework\Controller\AbstractController;
use NamCao\Framework\Http\Response;

class HomeController extends AbstractController
{
   public function __construct()
   {
   }
   public function index(): Response {
      return $this->render('home.html.twig');
   }
}