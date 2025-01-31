<?php
namespace App\Controller;

use App\Entity\Tournoi;
use App\Form\TournoiType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class TournoiController extends AbstractController
{
    #[Route('/new', name: 'app_tournoi_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de l'entité Tournoi
        $tournoi = new Tournoi();

        // Assigner l'utilisateur connecté à 'created_by'
        $tournoi->setUser($this->getUser()); // Assigner l'utilisateur connecté

        // Création du formulaire basé sur l'entité Tournoi
        $form = $this->createForm(TournoiType::class, $tournoi);

        // Traitement de la requête HTTP (gestion du formulaire)
        $form->handleRequest($request);

        // Assigner la date actuelle à 'created_at'
        $tournoi->setCreatedAt(new \DateTimeImmutable());

        // Vérification si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'image
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                // Générer un nom unique pour l'image
                $newFilename = uniqid('', true) . '.' . $imageFile->guessExtension();

                try {
                    // Déplacer l'image dans le dossier de stockage
                    $imageFile->move(
                        $this->getParameter('tournoi_images_directory'), // Le dossier où les images seront stockées
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'erreur si le fichier ne peut pas être déplacé
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image.');
                    return $this->redirectToRoute('app_tournoi_new');
                }

                // Assigner le chemin de l'image à l'entité
                $tournoi->setImage($newFilename);
            }

            // Persister l'objet Tournoi dans la base de données
            $entityManager->persist($tournoi);
            $entityManager->flush(); // Sauvegarde les données

            // Ajoute un message flash pour informer l'utilisateur du succès de la création
            $this->addFlash('success', 'Tournoi créé avec succès !');

            // Redirection vers la liste des tournois après création
            return $this->redirectToRoute('app_tournoi_list');
        }

        // Affichage du formulaire dans la vue "tournoi/tournoi.html.twig"
        return $this->render('tournoi/tournoi.html.twig', [
            'form' => $form->createView(), // Génération du formulaire à afficher dans la vue
        ]);
    }

    // Récupérer tous les tournois
        #[Route('/list_tournoi', name: 'app_tournoi_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les tournois depuis la base de données
        $tournois = $entityManager->getRepository(Tournoi::class)->findAll();

        // Rendre la vue et passer les tournois à la template
        return $this->render('list_tournoi/tournoi_list.html.twig', [
            'tournois' => $tournois,
        ]);
    }


    // Modifier un tournoi
    #[Route('/edit/{id}', name: 'app_tournoi_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
          // Récupérer le tournoi depuis la base de données
          $tournoi = $entityManager->getRepository(Tournoi::class)->find($id);

          if (!$tournoi) {
              throw $this->createNotFoundException('Le tournoi demandé n\'existe pas.');
          }
  
          // Création du formulaire basé sur l'entité Tournoi
          $form = $this->createForm(TournoiType::class, $tournoi);
  
          // Traitement de la requête HTTP (gestion du formulaire)
          $form->handleRequest($request);
  
          // Vérification si le formulaire a été soumis et est valide
          if ($form->isSubmitted() && $form->isValid()) {
              // Gestion de l'upload de l'image si un fichier a été sélectionné
              /** @var UploadedFile $imageFile */
              $imageFile = $form->get('image')->getData();
  
              if ($imageFile) {
                  // Générer un nom de fichier unique
                  $newFilename = uniqid() . '.' . $imageFile->guessExtension();
  
                  // Déplacer l'image dans le répertoire cible
                  $imageFile->move(
                      $this->getParameter('tournoi_images_directory'),
                      $newFilename
                  );
  
                  // Mettre à jour le nom de l'image dans l'entité
                  $tournoi->setImage($newFilename);
              }
  
              // Sauvegarde les modifications dans la base de données
              $entityManager->flush();
  
              // Ajoute un message flash pour informer l'utilisateur du succès de la modification
              $this->addFlash('success', 'Tournoi modifié avec succès !');
  
              // Redirection vers la liste des tournois après modification
              return $this->redirectToRoute('app_tournoi_list');
          }
        // Affichage du formulaire dans la vue "tournoi/tournoi_edit.html.twig"
        return $this->render('tournoi/tournoi.html.twig', [
                        'form' => $form->createView(), // Génération du formulaire à afficher dans la vue
            'tournoi' => $tournoi // Passer l'objet tournoi à la vue pour afficher les détails
        ]);
    }

    // Supprimer un tournoi
    #[Route('/delete/{id}', name: 'app_tournoi_delete')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le tournoi depuis la base de données
        $tournoi = $entityManager->getRepository(Tournoi::class)->find($id);

        if (!$tournoi) {
            throw $this->createNotFoundException('Le tournoi demandé n\'existe pas.');
        }

        // Supprimer le tournoi de la base de données
        $entityManager->remove($tournoi);
        $entityManager->flush(); // Sauvegarde la suppression

        // Ajoute un message flash pour informer l'utilisateur de la suppression
        $this->addFlash('success', 'Tournoi supprimé avec succès !');

        //Redirection vers la liste des tournois après suppression
         return $this->redirectToRoute('app_tournoi_list');
    }
}
