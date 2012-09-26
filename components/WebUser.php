<?php

/**
 * Overloaded yii::app()->user component
 * @author gri
 *
 * @property string $userIdentityClass
 * @property bool isAdmin
 */
class WebUser extends CWebUser
{
    public function getRegDate(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        return $user->reg_date;
    }

    public function setArea($id){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);
        $user->current_area = $id;
        $user->save();
    }


    public function purchase($sum){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        if($user->cash < $sum){
            return false;
        }

        $user->cash = $user->cash - $sum;
        $user->save();

        return true;
    }

    public function sell($item){
        $user = $this->loadModel(Yii::app()->user->id);
        $transaction = $user->dbConnection->beginTransaction();
        try
        {
            $userArms = UserArms::model()->findByPk($item, 'user_id=:current_user', array(':current_user'=>$user->id));
            if($userArms === null){
                throw new Exception('item not found');
            }

            if($userArms->user_id != $user->id){
                throw new Exception('can not be sold. Not yours');
            }

            $userArms->user_id = null;
            if($userArms->save()){
                $user->cash += $userArms->getPriceWithTax();
                if(!$user->save()){
                    throw new Exception('can not get cash');
                }
            }else{
                throw new Exception('can not be sold.');
            }

            $transaction->commit();
        }
        catch(Exception $e)
        {
            $transaction->rollback();
            Yii::app()->user->setFlash('msg',$e->getMessage());
            $msg = '';
        }
    }

    public function setActivity(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);
        $user->last_activity = time();
        $user->save();
    }

    public function getSquad(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        return $user->squad;
    }

    public function getLevel(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        return $user->level;
    }

    public function getCurrentHp(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        return $user->current_hp;
    }

    public function getExpo(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        return $user->expo;
    }

    public function getFrag(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        return $user->frag;
    }

    public function getTotalTime(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        return $user->total_time;
    }

    public function getArms(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        return $user->arms;
    }

    public function getEquipments(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        return $user->equipments;
    }

    public function getCash(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        return $user->cash;
    }
    /**
     * @param $id
     * @return User
     * @throws CHttpException
     */
    protected function loadModel($id)
    {
        $model = User::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

}