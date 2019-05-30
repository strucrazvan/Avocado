<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $asd = "ma'Dick";
        print($asd);
        print("<br>");
        die("ASDSADSADSADSA");
        return $this->render('@UserBundle/Default/index.html.twig');
    }
}
