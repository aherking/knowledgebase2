<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ExceptionController extends AbstractController
{

    public function showAction(FlattenException $exception)
    {
        $code = $exception->getStatusCode();
        $message = $exception->getMessage();

        return new Response($this->render('exception.html.twig',
            [
                'status_code' => $code,
                'message' => $message
            ]));
    }

}