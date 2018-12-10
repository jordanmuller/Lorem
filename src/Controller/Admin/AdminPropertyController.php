<?php

namespace App\Controller\Admin;

use App\Controller\Controller;
use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{RedirectResponse, Request, Response};

class AdminPropertyController extends AbstractController
{
    use Controller;

    /**
     * @return Response
     */
    public function index(): Response
    {
        $properties = $this->repo->findAll();
        return $this->render(
            'admin/property/index.html.twig',
            ['properties' => $properties]
        );
    }

    /**
     * @return Response
     */
    public function save(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);

        if ($form->handleRequest($request) && $form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Well created with success');
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render(
            'admin/property/save.html.twig',
            [
                'property' => $property,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param Property $property
     * @return Response
     */
    public function update(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);

        if ($form->handleRequest($request) && $form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Well updated with success');
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render(
            'admin/property/update.html.twig',
            [
                'property' => $property,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param Property $property
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Well deleted with success');

        }
        return $this->redirectToRoute('admin_property_index');
    }
}
