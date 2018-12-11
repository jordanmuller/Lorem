<?php

namespace App\Controller\Admin;

use App\Controller\Controller;
use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminPictureController extends AbstractController
{
    use Controller;

    public function delete(Picture $picture, Request $request)
    {
        // On récupère les data return par le call AJAX, sous forme string (JSON)
        $data = $request->getContent();
        // On parse le data sous forme d'array
        $data = json_decode($data, true);
        $propertyId = $picture->getProperty()->getId();

        // en PHP simple, on fait request->request->get('_token') pour récupérer le token du form, en ajax on utilise
        // $data['_token']
        // Le token est généré dans la vue (show.html.twig) via : data-token="{{ csrf_token('delete' ~ picture.id) }}"
        if ($this->isCsrfTokenValid('delete' . $picture->getId(), $data['_token'])) {
            $this->em->remove($picture);
            $this->em->flush();
            return new JsonResponse(['success' => 1]);

        } else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }
}