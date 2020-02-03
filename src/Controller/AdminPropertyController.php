<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    private $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * @Route("/admin/property", name="admin_property_index")
     */
    public function index()
    {
        $properties = $this->propertyRepository->findAll();

        return $this->render('admin/property/index.html.twig', [
            'properties' => $properties
        ]);
    }

    /**
     * @Route("admin/property/new", name="admin_property_new")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function new(Request $request, EntityManagerInterface $manager)
    {
        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($property);
            $manager->flush();

            $this->addFlash(
                'success',
                'Bien créé avec succès'
            );

            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin/property/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin_property_edit")
     * @param Property $property
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Property $property, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($property);
            $manager->flush();

            $this->addFlash(
                'success',
                'Bien modifié avec succès'
            );

            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/remove/{id}", name="admin_property_remove")
     * @param Property $property
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function remove(Property $property, EntityManagerInterface $manager)
    {
        $manager->remove($property);
        $manager->flush();

        $this->addFlash(
            'success',
            'Bien supprimé avec succès'
        );

        return $this->redirectToRoute('admin_property_index');
    }
}
