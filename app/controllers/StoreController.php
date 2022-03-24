<?php
namespace controllers;
 use models\Product;
 use models\Section;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\orm\DAO;
 use Ubiquity\orm\repositories\ViewRepository;
 use Ubiquity\utils\http\UResponse;
 use Ubiquity\utils\http\USession;

 /**
  * Controller StoreController
  */
class StoreController extends ControllerBase{

    private ViewRepository $repo;

    public function initialize() {
        $this->view->setVar("nimp", 0);
        parent::initialize();
        $this->repo??=new ViewRepository($this,Section::class);
    }

    /**
     * @throws \Exception
     */
    #[Route('_default', name: 'index')]
	public function index(){
        $count=DAO::count(Product::class);
        $this->repo->all('', ["products"]);
        $this->loadView("IndexController/index",['countProduits' => $count]  );
	}


    #[Get(path: "store/section/{idSection}", name: 'store.section')]
    public function getBar(int $idSection) {
        $this->repo->byId($idSection, ['products']);
        $this->loadView("StoreController/getBar"  );
    }


    #[Route(path: "store/allProducts/", name: 'store.allProducts')]
    public function allProducts() {
        $tout = DAO::getAll(Product::class);
        $this->loadView("StoreController/allProducts", \compact('tout')  );
    }

    #[Route(path:'store/addToCart/{elt}/{prix}', name:'store.addToCart')]
    public function addToCart($elt,$prix){
        USession::set("prix",USession::get("prix")+$prix);
        USession::set("quantitee",USession::get("quantitee")+1);
        UResponse::header('location', '/store/allProducts/');
    }
}
