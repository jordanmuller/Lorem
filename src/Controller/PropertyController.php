<?php

namespace App\Controller;


use App\Entity\Property;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PropertyController extends AbstractController
{
    use Controller;

    public function index(): Response
    {
        $this->repo->findAllVisible();
        return $this->render('property/index.html.twig', [
            'current_nav' => 'properties'
        ]);
    }

    /**
     * Show only one property
     * @param Property $property
     * @ParamConverter("property", class="App\Entity\Property")
     * @return Response
     */
    public function show(Property $property): Response
    {
        // ->find() is done automatically by Symfony
        // $property = $this->repo->find($property);
        return $this->render(
            'property/show.html.twig',
            [
                'current_menu' => 'properties',
                'property' => $property
            ]
        );
    }
}