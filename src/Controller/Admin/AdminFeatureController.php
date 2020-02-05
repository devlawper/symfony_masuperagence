<?php

namespace App\Controller\Admin;

use App\Entity\Feature;
use App\Form\FeatureType;
use App\Repository\FeatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/feature")
 */
class AdminFeatureController extends AbstractController
{
    /**
     * @Route("/", name="admin_feature_index", methods={"GET"})
     * @param FeatureRepository $featureRepository
     * @return Response
     */
    public function index(  FeatureRepository $featureRepository): Response
    {
        return $this->render('admin/feature/index.html.twig', [
            'features' => $featureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_feature_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $feature = new Feature();
        $form = $this->createForm(FeatureType::class, $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feature);
            $entityManager->flush();

            return $this->redirectToRoute('admin_feature_index');
        }

        return $this->render('admin/feature/new.html.twig', [
            'feature' => $feature,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_feature_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Feature $feature
     * @return Response
     */
    public function edit(Request $request, Feature $feature): Response
    {
        $form = $this->createForm(FeatureType::class, $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_feature_index');
        }

        return $this->render('admin/feature/edit.html.twig', [
            'feature' => $feature,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_feature_remove")
     * @param Request $request
     * @param Feature $feature
     * @return Response
     */
    public function delete(Request $request, Feature $feature): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($feature);
        $entityManager->flush();

        return $this->redirectToRoute('admin_feature_index');
    }
}
