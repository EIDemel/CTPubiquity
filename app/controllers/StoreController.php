<?php
namespace controllers;
 use models\Organization;
 use models\Product;
 use models\Section;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\core\postinstall\Display;
 use Ubiquity\orm\creator\Model;
 use Ubiquity\orm\DAO;
 use Ubiquity\orm\repositories\ViewRepository;

 /**
  * Controller StoreController
  */
class StoreController extends \controllers\ControllerBase{

    private ViewRepository $repo;

    public function initialize() {
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
}
