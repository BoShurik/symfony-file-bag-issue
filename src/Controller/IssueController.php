<?php
/**
 * User: boshurik
 * Date: 24.12.19
 * Time: 15:39
 */

namespace App\Controller;

use App\Form\Type\IssueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class IssueController extends AbstractController
{
    public function __invoke(Request $request)
    {
        $form = $this->createForm(IssueType::class, $this->buildData(), [
            'action' => $this->generateUrl('index'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                dump($form->getData());
            }
        }

        return $this->render('issue/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function buildData(): array
    {
        return [
            'files' => [
                new File(__DIR__.'/../../fixtures/1.txt'),
                new File(__DIR__.'/../../fixtures/2.txt'),
                new File(__DIR__.'/../../fixtures/3.txt'),
            ],
        ];
    }
}
