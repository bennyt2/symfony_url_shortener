<?php

namespace App\Controller;

use App\Entity\Redirect;
use App\Form\RedirectType;
use App\Service\SlugBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{
    /**
     * @Route("/", name="redirect_index")
     *
     * @param Request     $request
     * @param SlugBuilder $slugBuilder
     *
     * @return Response
     */
    public function index(Request $request, SlugBuilder $slugBuilder)
    {
        $redirect = new Redirect();

        $form = $this->createForm(RedirectType::class, $redirect);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Redirect $redirect */
            $redirect = $form->getData();

            // Generate the slug.
            if (!$redirect->getSlug()) {
                $redirect->setSlug($slugBuilder->createSlug());
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($redirect);
            $em->flush();

            return $this->redirectToRoute('redirect_view', ['redirect' => $redirect->getSlug()]);
        }

        return $this->render('redirect/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/view/{redirect}", name="redirect_view")
     * @Entity("redirect", expr="repository.findOneBySlug(redirect)")
     *
     * @param Request  $request
     * @param Redirect $redirect
     *
     * @return Response
     */
    public function view(Request $request, Redirect $redirect)
    {
        return $this->render('redirect/view.html.twig', [
            'redirect' => $redirect,
        ]);
    }

    /**
     * @Route("/{redirect}", name="redirect_send")
     * @Entity("redirect", expr="repository.findOneBySlug(redirect)")
     *
     * @param Request  $request
     * @param Redirect $redirect
     *
     * @return Response
     */
    public function sendToRedirect(Request $request, Redirect $redirect)
    {
        return $this->redirect($redirect->getUrl());
    }
}
