<?php

/*
 * This file is part of the NavBundle.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace NavBundle\E2e\TestBundle\Controller;

use NavBundle\E2e\TestBundle\Entity\Contact;
use NavBundle\Registry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
final class CreateController
{
    /**
     * @Route("/contacts/create", name="create", methods={"GET", "POST"})
     */
    public function __invoke(Registry $registry, Environment $twig, RouterInterface $router, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $contact = new Contact();
            $contact->type = 'Person';
            foreach ($request->request->get('contact') as $key => $value) {
                $contact->{$key} = empty($value) ? null : $value;
            }
            $registry->getManagerForClass(Contact::class)->create($contact);

            return new RedirectResponse($router->generate('edit', ['no' => $contact->no]));
        }

        return new Response($twig->render('create.html.twig'));
    }
}