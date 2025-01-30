<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tournoi;
use App\Form\TournoiType;

final class TournoiController extends AbstractController
{
    #[Route('/new', name: 'app_tournoi_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de l'entité Tournoi
        $tournoi = new Tournoi();

        // Assigner l'utilisateur connecté à 'created_by'
        // $tournoi->setCreatedBy($this->getUser());  // Assigner l'utilisateur connecté

        // Création du formulaire basé sur l'entité Tournoi
        $form = $this->createForm(TournoiType::class, $tournoi);

        // Traitement de la requête HTTP (gestion du formulaire)
        $form->handleRequest($request);
         // Assigner la date actuelle à 'created_at'
         $tournoi->setCreatedAt(new \DateTimeImmutable());
        // Vérification si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Persiste l'objet Tournoi dans la base de données
            $entityManager->persist($tournoi);
            $entityManager->flush(); // Sauvegarde les données

            // Ajoute un message flash pour informer l'utilisateur du succès de la création
            $this->addFlash('success', 'Tournoi créé avec succès !');

            // Redirection vers la liste des tournois après création
            return $this->redirectToRoute('app_tournoi_list');
        }

        // Affichage du formulaire dans la vue "tournoi/tournoi.html.twig"
        return $this->render('tournoi/tournoi.html.twig', [
            'controller_name' => 'TournoiController', // Variable passée à la vue (facultatif)
            'form' => $form->createView(), // Génération du formulaire à afficher dans la vue
        ]);
    }
}
