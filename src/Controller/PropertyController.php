<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/biens", name="property_index")
     * @param PropertyRepository $propertyRepository
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(PropertyRepository $propertyRepository, EntityManagerInterface $manager)
    {
        $property = $propertyRepository->findAllVisible();

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property_show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @param PropertyRepository $propertyRepository
     * @return Response
     */
    public function show(Property $property, string $slug, PropertyRepository $propertyRepository)
    {
        if ($property->getSlug() !== $slug) {
            $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property
        ]);
    }
}
