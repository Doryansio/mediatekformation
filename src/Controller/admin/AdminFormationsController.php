<?php
namespace App\Controller\admin;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Description of AdminFormationsController
 * Partie back-office de FormationsController
 * Possède les mêmes membres que la classe front-office
 * @author Doryan
 */
class AdminFormationsController extends AbstractController {
    // variable constante vers le chemin pages/formations
    private const PAGE_FORMATIONS = "admin/admin.formations.html.twig";
    
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
    
    function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository= $categorieRepository;
    }
    
    /**
     * @Route("admin/formations", name="admin.formations")
     * @return Response
     */
    public function index(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGE_FORMATIONS, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("admin/formations/tri/{champ}/{ordre}/{table}", name="admin.formations.sort")
     * @param type $champ
     * @param type $ordre
     * @param type $table
     * @return Response
     */
    public function sort($champ, $ordre, $table=""): Response{
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGE_FORMATIONS, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }     
    
    /**
     * @Route("admin/formations/recherche/{champ}/{table}", name="admin.formations.findallcontain")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $formations = $this->formationRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGE_FORMATIONS, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }  
    
    /**
     * @Route("admin/formations/formation/{id}", name="admin.formations.showone")
     * @param type $id
     * @return Response
     */
    public function showOne($id): Response{
        $formation = $this->formationRepository->find($id);
        return $this->render("admin/admin.formation.html.twig", [
            'formation' => $formation
        ]);        
    }
    
    /**
     * Description de suppr()
     * methode permettant la suppression d'une formation dans la base de données
     * la formation suprimée doit aussi être supprimer de la playlist à laquelle elle est rattachée
     * @route("admin/formations/suppr/{id}", name="admin.formation.suppr")
     * @param Formation $formation
     * @return Response
     */
    public function suppr(Formation $formation): Response{
        $this->formationRepository->remove($formation, true);
        return $this->redirectToRoute("admin.formations");
    }
    
     /**
     * @route("admin/edit/{id}", name="admin.formation.edit")
     * @param Formation $formation
      *@param Request $request
      * @param type $id 
     * @return Response
     */
    public function edit(Formation $formation, Request $request,$id): Response{
        $formFormation = $this->createForm(FormationType::class, $formation);
        $formation = $this->formationRepository->find($id);
        
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->formationRepository->add($formation, true);
            return $this->redirectToRoute('admin.formation.edit',[
                'formation' => $formation,
                'id' => $id
                    
            ]);
        }
        
        return $this->render("admin/admin.formation.edit.html.twig", [
            'formation' => $formation,
            'formformation' => $formFormation->createView()     
        ]);
    }
    
    /**
     * @route("admin/ajout", name="admin.formation.ajout")
     *@param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response{
        $formation = new Formation();
        $formFormation = $this->createForm(FormationType::class, $formation);
        
        
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->formationRepository->add($formation, true);
            return $this->redirectToRoute('admin.formations',[
                'formation' => $formation,
         
            ]);
        }
        
        return $this->render("admin/admin.formation.ajout.html.twig", [
            'formation' => $formation,
            'formformation' => $formFormation->createView()     
        ]);
    }
}

