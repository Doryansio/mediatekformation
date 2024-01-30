<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of PlaylistsController
 *
 * @author emds
 */
class AdminPlaylistsController extends AbstractController {
    
    private const PAGES_PLAYLIST = "admin/admin.playlists.html.twig";
    private const ADMINP = "admin.playlists";
    
    /**
     * 
     * @var PlaylistRepository
     */
    private $playlistRepository;
    
    /**
     * 
     * @var FormationRepository
     */
    private $formationRepository;
    
    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;    
    
    function __construct(PlaylistRepository $playlistRepository, 
            CategorieRepository $categorieRepository,
            FormationRepository $formationRespository) {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }
    
    /**
     * @Route("admin/playlists", name="admin.playlists")
     * @return Response
     */
    public function index(): Response{
        $playlists = $this->playlistRepository->findAllOrderByName('ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGES_PLAYLIST, [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }

    /**
     * @Route("admin/playlists/tri/{champ}/{ordre}", name="admin.playlists.sort")
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    public function sort($champ, $ordre): Response{
        $playlists = $this->playlistRepository->findAllOrderByName($ordre);
        $categories = $this->categorieRepository->findAll();
            return $this->render(self::PAGES_PLAYLIST,[
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }          
	
    /**
     * @Route("admin/playlists/recherche/{champ}/{table}", name="admin.playlists.findallcontain")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGES_PLAYLIST, [
            'playlists' => $playlists,
            'categories' => $categories,            
            'valeur' => $valeur,
            'table' => $table
        ]);
    }  
    
    /**
     * @Route("admin/playlists/playlist/{id}", name="admin.playlist.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response{
        $playlist = $this->playlistRepository->find($id);
        $playlistCategories = $this->categorieRepository->findAllForOnePlaylist($id);
        $playlistFormations = $this->formationRepository->findAllForOnePlaylist($id);
        return $this->render("admin/admin.playlist.html.twig", [
            'playlist' => $playlist,
            'playlistcategories' => $playlistCategories,
            'playlistformations' => $playlistFormations
        ]);        
    }
    
     /**
     * @Route("admin/playlist/{id}/suppr", name="admin.playlist.suppr")
     * @param type $id
     * @return Response
    */
    public function suppr($id, Request $request): Response{


        if ($this ->isCsrfTokenValid('suppr'. $id, $request -> get('_token'))){
            $playlist = $this->playlistRepository->find($id);
            $formation = $playlist->getFormations();
            if($formation->isEmpty()){
            $this->playlistRepository->remove($playlist, true);
            $this->addFlash('notice1', "playlist supprimée");
            }else{
            $this->addFlash('notice', "Vous ne pouvez pas suprimer cette playlist, elle contient des formations");
            
            }
        }
        return $this->redirectToRoute(self::ADMINP);
    }

     /**
     * @Route("admin/playlist/edit/{id}", name="admin.playlist.edit")
     * @param Type $id
      * @param Playlist $playlist
      * @param Request $request
     * @return Response
    */
    public function edit(Playlist $playlist, $id, Request $request): Response {
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        $playlist = $this->playlistRepository->find($id);

        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist, true);
            return $this->redirectToRoute("admin.playlist.edit", [
                'playlist' => $playlist,
                'id' => $id
            ]);

        }
        $playlistCategories = $this->categorieRepository->findAllForOnePlaylist($id);
        $playlistFormations = $this->formationRepository->findAllForOnePlaylist($id);
        return $this->render("admin/admin.playlist.edit.html.twig", [
            'playlist' => $playlist,
            'playlistcategories' => $playlistCategories,
            'playlistformations' => $playlistFormations,
            'formPlaylist' => $formPlaylist->createView()
        ]);
    }

    /**
     * @Route("/admin/playlist", name="admin.playlist.ajout")
     * @param Request $request
     * @return Response
    */
    public function ajout(Request $request): Response{
        $playlist = new Playlist();
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);

        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted()&& $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist, true);
            return $this->redirectToRoute("admin.playlists");
        }
        return $this->render("admin/admin.playlist.ajout.html.twig", [
            'playlist' => $playlist,
            'formPlaylist' => $formPlaylist->createView()
        ]);
    }
    
}
