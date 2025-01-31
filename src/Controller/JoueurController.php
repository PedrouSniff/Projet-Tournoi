<?php
// src/Controller/JoueurController.php

namespace App\Controller;

use App\Entity\Joueur;
use App\Form\JoueurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class JoueurController extends AbstractController
{
    #[Route('/joueur', name: 'app_joueur_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de Joueur
        $joueur = new Joueur();

        // Création du formulaire
        $form = $this->createForm(JoueurType::class, $joueur);

        // Traitement du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde du joueur dans la base de données
            $entityManager->persist($joueur);
            $entityManager->flush();

            // Message flash pour l'utilisateur
            $this->addFlash('success', 'Joueur ajouté avec succès !');

            // Redirection après ajout
           return $this->redirectToRoute('app_joueur');
        }

        // Affichage de la vue avec le formulaire
        return $this->render('joueur/joueur_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/joueur_list', name: 'app_joueur_list',)]
public function list(EntityManagerInterface $entityManager): Response
{
    // Récupération de tous les joueurs
    $joueurs = $entityManager->getRepository(Joueur::class)->findAll();

    // Affichage de la vue avec les joueurs
    return $this->render('joueur/joueur_list.html.twig', [
        'joueurs' => $joueurs,
    ]);
}
  // Route pour modifier un joueur
  #[Route('/edit/{id}', name: 'app_joueur_edit', methods: ['GET', 'POST'])]
  public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
  {
      // Trouver le joueur par son id
      $joueur = $entityManager->getRepository(Joueur::class)->find($id);

      if (!$joueur) {
          throw $this->createNotFoundException('Joueur non trouvé');
      }

      $form = $this->createForm(JoueurType::class, $joueur);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $entityManager->flush();  // Met à jour l'entité existante dans la base de données
          $this->addFlash('success', 'Joueur modifié avec succès !');
          return $this->redirectToRoute('app_joueur_list');
      }

      return $this->render('joueur/joueur_edit.html.twig', [
          'form' => $form->createView(),
          'joueur' => $joueur,
      ]);
  }
  // Route pour supprimer un joueur
  #[Route('/delete/{id}', name: 'app_joueur_delete', methods: ['POST'])]
  public function delete(int $id, Request $request, EntityManagerInterface $entityManager): Response
  {
      // Trouver le joueur par son id
      $joueur = $entityManager->getRepository(Joueur::class)->find($id);

      if (!$joueur) {
          throw $this->createNotFoundException('Joueur non trouvé');
      }

      // Vérification du token CSRF pour sécuriser la suppression
      if ($this->isCsrfTokenValid('delete' . $joueur->getId(), $request->request->get('_token'))) {
          $entityManager->remove($joueur);
          $entityManager->flush();
          $this->addFlash('success', 'Joueur supprimé avec succès !');
      }

      return $this->redirectToRoute('app_joueur_list');
  }


}
