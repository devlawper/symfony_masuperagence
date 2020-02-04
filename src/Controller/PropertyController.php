<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/biens", name="property_index")
     * @param PropertyRepository $propertyRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PropertyRepository $propertyRepository, PaginatorInterface $paginator, Request $request)
    {
        $search = new PropertySearch();

        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump('ouii');
        }

        $property = $paginator->paginate(
            $propertyRepository->findAllVisible($search),
            $request->query->getInt('page', 1),
            12
            );

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $property,
            'form' => $form->createView()
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
