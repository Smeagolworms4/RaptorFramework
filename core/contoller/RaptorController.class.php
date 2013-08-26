<?php
/**
 * Class PHP permettant de gérer les différent controller du framework
 * 
 */
class RaptorController {
	
	/**
	 * @var string
	 */
	private $_module;
	
	/**
	 * @var string
	 */
	private $_controller;
	/**
	 * @var string
	 */
	private $_action;
	
	/**
	 * Constructeur
	 */
	public function __construct () {
		
		$config = _ioClass ('RaptorConfig');
		
		if ($config->MODE == RaptorConfig::MODE_DEV) {
			ini_set('display_errors', 1);
			ini_set('log_errors', 1);
			error_reporting(E_ALL);
		}
		
		
		$target = str_replace ($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
		
		if ($target == $_SERVER['REQUEST_URI']) {
			$target = array ();
		} else {
			$target = explode ('?', $target);
			
			if (isset ($target[0][0]) && $target[0][0] == '/') {
				$target[0] = substr ($target[0], 1);
			}
			$target = explode ('/', $target[0]);
		}

		$this->_module     = (isset ($target[0]) && $target[0]) ? $target[0] : _request ('module', 'default');
		$this->_controller = (isset ($target[1]) && $target[1]) ? $target[1] : _request ('controller', 'default');
		$this->_action     = (isset ($target[2]) && $target[2]) ? $target[2] : _request ('action'    , 'default');
		
		// Securise les actions et controllers contre le piratage
		$this->_module     = preg_replace("[^A-Z0-9\ ]", "_", $this->_module);
		$this->_controller = preg_replace("[^A-Z0-9\ ]", "_", $this->_controller);
		$this->_action     = preg_replace("[^A-Z0-9\ ]", "_", $this->_action);

		RaptorRequest::set('module', $this->_module);
		RaptorRequest::set('controller', $this->_controller);
		RaptorRequest::set('action', $this->_action);
		
		RaptorSession::initialise ();
		
	}
	
	/**
	 * Renvoie le module
	 * @return string
	 */
	public function getModule () {
		return $this->_module;
	}
	
	/**
	 * Renvoie le controller
	 * @return string
	 */
	public function getController () {
		return $this->_controller;
	}
	
	/**
	 * Renvoie l'action
	 * @return string
	 */
	public function getAction () {
		return $this->_action;
	}
	
	/**
	 * Test si le controller existe
	 * @return bool
	 */
	private function _controllerExist () {
		$fileController = MODULES_PATH.$this->_module.'/'.CONTROLLER_DIR.'/'.$this->_controller.'.controller.php';
		
		return file_exists($fileController);
	}
	
	/**
	 * Execute l'action du controller
	 */
	public function process () {
		
		if ($this->_controllerExist ()) {
			
			_ioClass('RaptorContext')->push($this->_module);
			
			// Construction du controller
			require_once (MODULES_PATH.$this->_module.'/'.CONTROLLER_DIR.'/'.$this->_controller.'.controller.php');
			$controller = _iOClass ($this->_controller.'ActionController');
			
			$auroundController = $this->getAuroundController ();
			
			// Test de l'action
			if ($controller->actionExist ($this->_action)) {
				
				$actionReturn = null;
				
				try {
					
					_info($this, __('Appel de l\'action'));
					_ioClass ('RaptorHTMLHeader')->addCSSLink ('default|css/core.css');
					_ioClass ('RaptorHTMLHeader')->addJSLink ('default|js/libs/mootools/mootools-core-1.4.5-full-nocompat.js');
					_ioClass ('RaptorHTMLHeader')->addJSLink ('default|js/libs/mootools/mootools-more-1.4.0.1.js');
					_ioClass ('RaptorHTMLHeader')->addJSLink ('default|js/libs/raptor/Utils.js');
					_ioClass ('RaptorHTMLHeader')->addJSLink ('default|js/libs/raptor/Raptor.js');
					_ioClass ('RaptorHTMLHeader')->addJSLink ('default|js/libs/raptor/Code.js');
					
					if ($auroundController) $auroundController->beforeController ($this->_controller, $this->_action);
					$controller->beforeAction ($this->_action);
					$actionReturn = $controller->call ($this->_action);
					$controller->afterAction ($this->_action, $actionReturn);
					if ($auroundController) $auroundController->afterController ($this->_controller, $this->_action);
					
				} catch (Exception $e) {
					try {
						_error($e, __('Exception capturé, appel de l\'action RaptorActionReturn::catchException'));
						$actionReturn = $controller->catchException ($this->_action, $e, $actionReturn);
					} catch (Exception $e) {
						try {
							if ($auroundController) {
								_error($e, __('Exception capturé, appel de l\'action AuroundController::catchException'));
								$actionReturn = $auroundController->catchException ($this->_controller, $this->_action, $e, $actionReturn);
							} else {
								throw $e;
							}
						} catch (Exception $e) {
							_error($e, __('Exception capturé et affichage'));
							$this->displayExceptionPage ($e);
							return;
						}
					}
				}
				
				// Affiche le resultat
				// Normalement il est impossible de ne pas rentrer dans le if (Sauf FATAL bien evidemment)
				if ($actionReturn || is_a($actionReturn, 'RaptorActionController')) {
					try {
						echo $actionReturn->fetch ();
					} catch (Exception $e) {
						$this->displayExceptionPage ($e);
					}
					return;
				} else {
					try {
						throw new RaptorException (__('L\'action n\'a pas r\'envoyée d\'objet de type RaptorActionController'));
					} catch (Exception $e) {
						$this->displayExceptionPage ($e);
						return;
					}
				}
			}
		}
		
		$config = _ioClass ('RaptorConfig');
		echo _arRedirect(_url ($config->error404Page, array ('m'=>$this->_module, 'c'=>$this->_controller, 'a'=>$this->_action)));
	}
	
	/**
	 * Affiche l'exception
	 * @param Exception $e
	 */
	private function displayExceptionPage ($e) {
		$ppo = new RaptorPPO ();
		$ppo->message = $e->getMessage ();
		$ppo->code    = $e->getCode ();
		$ppo->type    = get_class($e);
		echo _arSmarty ($ppo, 'default|exception.tpl');
	}
	
	/**
	 * Renvoie l'AuroundController du module
	 * @return AuroundController
	 */
	private function getAuroundController () {
		$auroundController = NULL;
		
		
		if (file_exists($file = MODULES_PATH.$this->_module.'/'.CONTROLLER_DIR.'/aroundcontroller.php')) {
			require_once ($file);
			$auroundController = new AuroundController ();
		}
		return $auroundController;
	}
	
	
}