<?php
namespace App\Controller;

use App\Entity\Idea;
use App\Form\IdeaType;
use DateTime;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IdeaController extends AbstractController
{
    /**
     * @Route("/ideas", name="idea_list")
     */
    public function list(EntityManagerInterface $em)
    {
        $repo = $em->getRepository(Idea::class);
        $ideas = $repo->findBy(["isPublished" => true], ["dateCreated" => "DESC"]);

        return $this->render("idea/list.html.twig", ["ideas" => $ideas]);
    }

    /**
     * @Route("/ideas/{id}", name="idea_detail", requirements={"id": "\d+"})
     */
    public function detail(int $id, EntityManagerInterface $em)
    {
        $repo = $em->getRepository(Idea::class);
        $idea = $repo->find($id);

        return $this->render("idea/detail.html.twig", ["idea" => $idea]);
    }

    /**
     * @Route("/ideas/add", name="idea_add")
     */
    public function add(EntityManagerInterface $em, Request $request)
    {
        $idea = new Idea();

        $form = $this->createForm(IdeaType::class, $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**@var Idea $idea */
            $idea = $form->getData();

            $idea->setDateCreated(new DateTime());

            $em->persist($idea);
            $em->flush();

            $this->addFlash('success', 'Out l\'idée les bien pris en compte!');
            return $this->redirectToRoute('idea_list');
        }

        return $this->renderForm('idea/add.html.twig', [
            'form' => $form
        ]);
    }
}