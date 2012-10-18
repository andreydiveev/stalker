<?php

class MarketController extends Controller
{
    protected function beforeAction()
    {
        if(!Yii::app()->user->isGuest){
            Yii::app()->user->setArea(null);
        }

        return true;
    }

	public function actionIndex()
	{
        /**
         * @TODO add counters
         */

        $this->breadcrumbs = array('Market');
        $this->render('index');
	}

    public function actionArms(){
        $this->breadcrumbs = array(
            'Market'=>'/market',
        );

        if($id = Yii::app()->request->getParam('id')){
            $weapon = Arms::model()->findByPk($id);

            if($weapon !== null){
                $this->breadcrumbs['Оружие'] = '/market/arms';
                $this->breadcrumbs[$weapon->type->class->name] = '/market/arms/class/'.$weapon->type->class->id;
                $this->breadcrumbs[$weapon->type->name] = '/market/arms/type/'.$weapon->type->id;

                array_push($this->breadcrumbs, $weapon->name);


                $this->render('arms', array('item' => $weapon));
                Yii::app()->end();
            }
        }

        if($type_id = Yii::app()->request->getParam('type')){
            $type = ArmsType::model()->findByPk($type_id);

            if($type !== null){
                $this->breadcrumbs['Оружие'] = '/market/arms';
                $this->breadcrumbs[$type->class->name] = '/market/arms/class/'.$type->class->id;

                array_push($this->breadcrumbs, $type->name);

                $arms = $type->arms;

                $this->render('price_list', array('items' => $arms, 'path'=>'/market/arms/id/'));
                Yii::app()->end();
            }
        }

        if($class_id = Yii::app()->request->getParam('class')){
            $class = ArmsClass::model()->findByPk($class_id);

            if($class !== null){
                $this->breadcrumbs['Оружие'] = '/market/arms';

                array_push($this->breadcrumbs, $class->name);

                $armsTypes = $class->armsTypes;

                $this->render('list', array('items' => $armsTypes, 'path'=>'/market/arms/type/'));
                Yii::app()->end();
            }
        }

        $model = ArmsClass::model()->findAll();
        $this->breadcrumbs = array(
            'Market'=>'/market',
            'Оружие'
        );
        $this->render('list', array('items'=>$model, 'path'=>'/market/arms/class/'));
    }

    public function actionEquipment(){

        $this->breadcrumbs = array(
            'Market'=>'/market',
        );

        if($id = Yii::app()->request->getParam('id')){
            $equipment = Equipment::model()->findByPk($id);

            if($equipment !== null){
                $this->breadcrumbs['Снаряжение'] = '/market/equipment';
                $this->breadcrumbs[$equipment->type->name] = '/market/equipment/type/'.$equipment->type->id;

                array_push($this->breadcrumbs, $equipment->name);


                $this->render('equipment', array('item' => $equipment));
                Yii::app()->end();
            }
        }

        if($type_id = Yii::app()->request->getParam('type')){
            $type = EquipmentType::model()->findByPk($type_id);

            if($type !== null){
                $this->breadcrumbs['Снаряжение'] = '/market/equipment';

                array_push($this->breadcrumbs, $type->name);

                $types = $type->equipments;

                $this->render('price_list', array('items' => $types, 'path'=>'/market/equipment/id/'));
                Yii::app()->end();
            }
        }


        $this->breadcrumbs = array(
            'Market'=>'/market',
            'Снаряжение'
        );

        $model = EquipmentType::model()->findAll();
        $this->render('list', array('items'=>$model, 'path'=>'/market/equipment/type/'));
    }

    public function actionBuyArms(){
        $id = Yii::app()->request->getParam('id');
        $model = Arms::model()->findByPk($id);

        if($model == null){
            throw new CHttpException(404,'Товар не найден');
        }

        if(Yii::app()->user->getCash() < $model->price){
            $diff = Yii::app()->user->getCash() - $model->price;
            Yii::app()->user->setFlash('msg', 'Not enough cash. Need <b>$'.abs($diff).'</b>');
            $this->redirect('/market/arms/'.$id);
        }else{

            $user_arms = new UserArms();
            $user_arms->user_id = Yii::app()->user->id;
            $user_arms->arms_id = $model->id;

            $transaction=$user_arms->dbConnection->beginTransaction();
            try
            {
                if(!Yii::app()->user->purchase($model->price)){
                    throw new Exception('not enough cash');
                }else{
                    $operation = new BankOperations();
                    $operation->name = 'purchase Arms';
                    $operation->user_id = Yii::app()->user->id;
                    $operation->value = $model->id;
                    $operation->comment = $model->price;
                    $operation->time = time();
                    $operation->save();
                }

                if(!$user_arms->save()){
                    /**
                     * @TODO Secure
                     */
                    print_r($user_arms->getErrors());exit;
                    throw new Exception('can\'t buy');
                }

                $transaction->commit();
                $msg = 'You have successfully purchased <i>'.$model->name.'</i> <b>-$'.$model->price.'</b>';
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                $msg = $e->getMessage();
            }

            Yii::app()->user->setFlash('msg', $msg);
            $this->redirect('/market/arms/'.$id);
        }
    }

    public function actionBuyEquipment(){
        $id = Yii::app()->request->getParam('id');
        $model = Equipment::model()->findByPk($id);

        if($model == null){
            throw new CHttpException(404,'Товар не найден');
        }

        if(Yii::app()->user->getCash() < $model->price){
            $diff = Yii::app()->user->getCash() - $model->price;
            Yii::app()->user->setFlash('msg', 'Not enough cash. Need <b>$'.abs($diff).'</b>');
            $this->redirect('/market/equipment/'.$id);
        }else{

            $user_equipment = new UserEquipment();
            $user_equipment->user_id = Yii::app()->user->id;
            $user_equipment->equipment_id = $model->id;
            $user_equipment->slot_id = $model->type->slot_id;



            $transaction=$user_equipment->dbConnection->beginTransaction();
            try
            {
                if(!Yii::app()->user->purchase($model->price)){
                    throw new Exception('not enough cash');
                }else{
                    $operation = new BankOperations();
                    $operation->name = 'purchase Equipment';
                    $operation->user_id = Yii::app()->user->id;
                    $operation->value = $model->id;
                    $operation->comment = $model->price;
                    $operation->time = time();
                    $operation->save();
                }

                if(!$user_equipment->save()){
                    /**
                     * @TODO Secure
                     */
                    print_r($user_equipment->getErrors());exit;
                    throw new Exception('can\'t buy');
                }

                $transaction->commit();
                $msg = 'You have successfully purchased <i>'.$model->name.'</i> <b>-$'.$model->price.'</b>';
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                $msg = $e->getMessage();
            }

            Yii::app()->user->setFlash('msg', $msg);
            $this->redirect('/market/equipment/'.$id);
        }
    }

    protected function buying(){

    }

    public function actionResources(){

        $this->breadcrumbs = array(
            'Market'=>'/market',
            'resources'
        );
        $this->render('resources');
    }

    public function filters()
    {
        return array(
            'AccessControl',
            'CheckId + BuyArms, BuyEquipment',
        );
    }

    public function filterAccessControl($filterChain)
    {
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

}