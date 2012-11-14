<?php

class AndroidModule extends CWebModule
{

    public $_config = array();

	public function init()
	{
        $config = require dirname(__FILE__).DIRECTORY_SEPARATOR.'/config/main.php';
        //var_dump($config);
        $this->configure($config);

		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'android.models.*',
			'android.components.*',
		));


	}

    public function __set($name, $value)
    {
        try
        {
            parent::__set($name, $value);
        }
        catch (CException $e)
        {
            $this->_config[$name] = $value;
        }
    }

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
