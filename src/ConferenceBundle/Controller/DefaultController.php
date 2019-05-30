<?php

namespace ConferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        die("test");
        return $this->render('ConferenceBundle:Default:index.html.twig');
    }
}
