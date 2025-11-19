<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class LivreController extends AbstractController
{
    public array $livres = [
        1 => [
            'id' => 1,
            'titre' => 'Introduction aux Algorithmes',
            'auteur' => 'Thomas H. Cormen',
            'isbn' => '978-2100545261',
            'genre' => 'informatique',
            'annee_publication' => 2010,
            'nombre_pages' => 1200,
            'disponible' => true,
            'nombre_exemplaires' => 3,
            'resume' => 'Manuel de référence couvrant les algorithmes fondamentaux et les structures de
            données.',
            'editeur' => 'Dunod',
            'cote' => 'INF.004.COR'
        ],
        2 => [
            'id' => 2,
            'titre' => 'Le Rouge et le Noir',
            'auteur' => 'Stendhal',
            'isbn' => '978-2070360024',
            'genre' => 'litterature',
            'annee_publication' => 1830,
            'nombre_pages' => 720,
            'disponible' => false,
            'nombre_exemplaires' => 0,
            'resume' => 'Roman emblématique du XIXe siècle suivant les ambitions de Julien Sorel.',
            'editeur' => 'Gallimard',
            'cote' => 'LIT.840.STE'
            ],
        3 => [
            'id' => 3,
            'titre' => 'Physique Quantique - Fondements et Applications',
            'auteur' => 'Michel Le Bellac',
            'isbn' => '978-2759807802',
            'genre' => 'sciences',
            'annee_publication' => 2013,
            'nombre_pages' => 450,
            'disponible' => true,
            'nombre_exemplaires' => 2,
            'resume' => 'Introduction moderne à la mécanique quantique avec applications pratiques.',
            'editeur' => 'EDP Sciences',
            'cote' => 'PHY.530.LEB'
        ]
    ];

    #[Route('/bibliotheque/catalogue')]
    public function app_catalogue_liste(): Response
    {
       
        return $this->render('bibliotheque/livres.html.twig', [
            'livres' => $this->livres,
        ]);
        
    }
    #[Route('/bibliotheque/livre/{id}')]
    public function app_livre($id): Response
    {

        if ($id>3 and $id<0){
            return $this->render('bibliotheque/Error404.html.twig', [
            ]);
        }
        else{
            return $this->render('bibliotheque/livreDetails.html.twig', [
                'livre' => $this->livres[$id],
            ]);
        }
    }
    #[Route('/bibliotheque/catalogue/genre/{genre}')]
    public function app_genre($genre): Response
    {
        $lstGenre=[
            1=>'histoire',
            2=>'informatique',
            3=>'sciences',
            4=>'litterature'
        ];

        if (!in_array($genre, $lstGenre)) {
            return $this->render('bibliotheque/Error404.html.twig', [
            ]);
        }
            
        else{
            return $this->render('bibliotheque/genre.html.twig', [
                'livres' => $this->livres,
                'genre' => $genre,
            ]);
        }    
    }
    #[Route('/api/catalogue')]
    public function Returnjson(): JsonResponse
    {
       
        return $this->json([$this->livres]);
        
    }
    #[Route('/statistiques')]
    public function stat(): Response
    {
        $nbEmprun=0;
        $nbDispo=0;
        $nblivres= count($this->livres);
        foreach ($this->livres as $livre ){
            if ($livre['nombre_exemplaires']==0){
                $nbEmprun=$nbEmprun+1;
            }
            else{
                $nbDispo=$nbDispo+$livre['nombre_exemplaires'];
            }
        }

        return $this->render('bibliotheque/stat.html.twig', [
                'nbLivres' => $nblivres,
                'livres'=>$this->livres,
                'nbDispo'=>$nbDispo,
                'nbEmprun'=>$nbEmprun,
            ]);
        
    }

}