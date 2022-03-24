<?php
namespace controllers;
 use models\Organization;
 use models\Product;
 use models\Section;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\core\postinstall\Display;
 use Ubiquity\orm\creator\Model;
 use Ubiquity\orm\DAO;
 use Ubiquity\orm\repositories\ViewRepository;
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

    #[Get(path: "store/addToCart/{idProduit}/{count}", name: 'store.addToCart')]
    public function addToCart(int $idProduit, int $count){
        $sessionID = USession::get($idProduit);

    }

    #[Route(path: "store/allProducts/", name: 'store.allProducts')]
    public function allProducts() {
        $tout = DAO::getAll(Product::class);
        $this->loadView("StoreController/allProducts", \compact('tout')  );
    }



}
