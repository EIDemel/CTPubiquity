<?php
namespace controllers;

use Ubiquity\controllers\Controller;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;

/**
 * controllers$ControllerBase
 */
abstract class ControllerBase extends Controller {

	protected $headerView = "@activeTheme/main/vHeader.html";

	protected $footerView = "@activeTheme/main/vFooter.html";

	public function initialize() {
        $quantitee = USession::get("quantitee");
        $prix =  USession::get("prix");
		if (! URequest::isAjax()) {
            $this->loadView($this->headerView,["quantitee" => $quantitee,"prix" => $prix]);
		}
	}

	public function finalize() {
		if (! URequest::isAjax()) {
			$this->loadView($this->footerView);
		}
	}
}

