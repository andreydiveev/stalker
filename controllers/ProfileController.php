<?php

class ProfileController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionPublic(){
        $this->render('external');
    }

    public function actionSellArms(){
        $id = Yii::app()->request->getParam('id');

        $model = UserArms::model()->findByPk($id);

        if($model === null){
            $msg = '<b>Item not found</b>';
            Yii::app()->user->setFlash('msg', $msg);
            $this->redirect('/profile');
            Yii::app()->end();
        }

        Yii::app()->user->sellArms($model->id);
        $this->redirect('/profile');

    }

    public function actionSellEquipment(){
        $id = Yii::app()->request->getParam('id');

        $model = UserEquipment::model()->findByPk($id);

        if($model === null){
            $msg = '<b>Item not found</b>';
            Yii::app()->user->setFlash('msg', $msg);
            $this->redirect('/profile');
            Yii::app()->end();
        }

        Yii::app()->user->sellEquipment($model->id);
        $this->redirect('/profile');

    }

    public function actionTakeOffArms(){
        $id = Yii::app()->request->getParam('id');

        $model  = UserArms::model()->find("id = :id AND user_id = :user_id", array(":id"=>$id, ":user_id"=>Yii::app()->user->id ));
        if($model === null){
            throw new CHttpException(404,'Товар не найден');
        }

        $model->armed = 0;
        $model->save();/** @TODO Check saving*/
        $this->redirect('/profile');
    }

    public function actionTakeOffEquipment(){
        $id = Yii::app()->request->getParam('id');

        $model  = UserEquipment::model()->find("id = :id AND user_id = :user_id", array(":id"=>$id, ":user_id"=>Yii::app()->user->id ));
        if($model === null){
            throw new CHttpException(404,'Товар не найден');
        }

        $model->equipped = 0;
        $model->save();/** @TODO Check saving*/
        $this->redirect('/profile');
    }

    public function actionSetArms(){
        $id = Yii::app()->request->getParam('id');

        $model  = UserArms::model()->find("id = :id AND user_id = :user_id", array(":id"=>$id, ":user_id"=>Yii::app()->user->id ));
        if($model === null){
            throw new CHttpException(404,'Товар не найден');
        }

        $model->armsOff();
        $model->armed = 1;
        $model->save();/** @TODO Check saving*/
        $this->redirect('/profile');
    }

    public function actionSetEquipment(){
        $id = Yii::app()->request->getParam('id');

        $model  = UserEquipment::model()->find("id = :id AND user_id = :user_id", array(":id"=>$id, ":user_id"=>Yii::app()->user->id ));
        if($model === null){
            throw new CHttpException(404,'Товар не найден');
        }

        $model->equipmentOff();
        $model->equipped = 1;
        $model->save();/** @TODO Check saving*/
        $this->redirect('/profile');
    }

    public function filters()
    {
        return array(
            'AccessControl + index',
            'CheckId + SellArms, SellEquipment, TakeOffArms',
        );
    }

    public function filterAccessControl($filterChain)
    {
        // для выполнения последующих фильтров и выполнения действия вызовите метод $filterChain->run()

        if(!Yii::app()->user->isGuest){
            $filterChain->run();
        }else{
            $this->redirect('/site/login');
        }
    }


    public function filterCheckId($filterChain){
        if($id = Yii::app()->request->getParam('id')){
            $filterChain->run();
        }else{
            throw new CHttpException(404,'Товар не найден');
        }
    }

    public function actionRise(){
         Yii::app()->user->rise();
         $this->redirect( Yii::app()->request->urlReferrer);
    }
}