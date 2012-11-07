<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
        $this->layout = false;
		$this->render('response', array(
            'status'    => 'success',
            'post_var'  => Yii::app()->request->getPost('post_var'),
            'get_var'  => Yii::app()->request->getParam('get_var'),
        ));
	}

    public function actionForm()
    {
        //$this->layout = false;
        $this->render('index');
    }
}