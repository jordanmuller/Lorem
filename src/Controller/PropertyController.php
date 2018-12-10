<?php

namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Property;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;

class PropertyController extends AbstractController
{
    use Controller;

    /**
     * Index All properties page
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $propertySearch = new PropertySearch();
        // Handle process in our controller
        $form = $this->createForm(PropertySearchType::class, $propertySearch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataSearch = $form->getData();
            $properties = $this->getPagination(
                $this->repo->findSearchedVisibleQuery($dataSearch),
                $request
            );
        } else {
            $properties = $this->getPagination(
                $this->repo->findAllVisibleQuery(), 
                $request
            );
        }

        return $this->render('property/index.html.twig', [
            'current_nav' => 'properties',
            'form' => $form->createView(),
            'properties' => $properties
        ]);
    }

    /**
     * Show only one property
     * @param Property $property
     * @param Request $request
     * @return Response
     * @ParamConverter("property", class="App\Entity\Property")
     */
    public function show(Property $property, Request $request, ContactNotification $notification): Response
    {
        // ->find() is done automatically by Symfony
        // $property = $this->repo->find($property);

        $contact = new Contact();
        $contact->setProperty($property);

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $notification->notify($contact);
            $this->addFlash('success', 'Votre email a bien été envoyé');

            return $this->redirectToRoute('property_show', [
                'id' => $property->getId()
            ]);

        }

        return $this->render(
            'property/show.html.twig',
            [
                'current_menu' => 'properties',
                'property' => $property,
                'form' => $form->createView()
            ]
        );
    }

    private function getPagination($repositoryMethod, Request $request)
    {
        return $this->paginator->paginate(
            $repositoryMethod,
            $request->query->getInt('page', 1),
            12
        );
    }
}