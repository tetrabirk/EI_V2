<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 16-12-18
 * Time: 14:37
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     * @return Response
     */

    public function homepage():Response
    {
        $user = get_current_user();

        return $this->render('home.html.twig', array(
            'notifications' => [1,2,3],
            'quickaccess' => array(
                ['route'=>'route1','name'=>'name1'],
                ['route'=>'route2','name'=>'name2'],
                ['route'=>'route3','name'=>'name3']
            )
        ));
    }
    /**
     * @Route("/about", name="about")
     *
     * @return Response
     */

    public function about():Response
    {
        $user = get_current_user();
        dump('test');

        return $this->render('about.html.twig', array(
        ));
    }
}