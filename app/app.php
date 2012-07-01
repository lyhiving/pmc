<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');
// 核心文件
class app{

	public $uri;
	public $model;
	public $lib;

	function __construct($uri){

		$this->uri = $uri;

	}

	function load_controller($class){


		$file = "app/controller/".$this->uri['controller'].".php";

		if(!file_exists($file)){

			require_once('view/404.php');
			die();

		}

		require_once($file);

		$controller = new $class();

		if(method_exists($controller, $this->uri['method'])){

			//call_user_func_array(array($controller,$this->uri['method']), $this->uri['params']);
			$controller->{$this->uri['method']}($this->uri['params']);

		} else {

			$controller->index();

		}

	}

	function load_view($view, $vars=""){

		if(is_array($vars) && count($vars) > 0)	extract($vars, EXTR_PREFIX_SAME, "wddx");

		require_once('view/'.$view.'.php');

	}

	function load_model($model){

		require_once('model/'.$model.'.php');

		$this->model = new $model;

		return $this->model;

	}

	function load_lib($lib){

		require_once('lib/'.$lib.'.php');

		$this->lib = new $lib;

		return $this->lib;

	}

}

// End app/app.php