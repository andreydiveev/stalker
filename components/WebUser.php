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

    public function sellArms($item){
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
                }else{
                    $operation = new BankOperations();
                    $operation->name = 'sell Arms';
                    $operation->user_id = $user->id;
                    $operation->value = $item;
                    $operation->comment = $userArms->getPriceWithTax();
                    $operation->time = time();
                    $operation->save();
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

    public function sellEquipment($item){
        $user = $this->loadModel(Yii::app()->user->id);
        $transaction = $user->dbConnection->beginTransaction();
        try
        {
            $userEquipment = UserEquipment::model()->findByPk($item, 'user_id=:current_user', array(':current_user'=>$user->id));
            if($userEquipment === null){
                throw new Exception('item not found');
            }

            if($userEquipment->user_id != $user->id){
                throw new Exception('can not be sold. Not yours');
            }

            $userEquipment->user_id = null;
            if($userEquipment->save()){
                $user->cash += $userEquipment->getPriceWithTax();
                if(!$user->save()){
                    throw new Exception('can not get cash');
                }else{
                    $operation = new BankOperations();
                    $operation->name = 'sell Equipment';
                    $operation->user_id = $user->id;
                    $operation->value = $item;
                    $operation->time = time();
                    $operation->save();
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
        return $this->loadModel(Yii::app()->user->id)->getHp();
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

        return $user->userArms;
    }

    public function getEquipments(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);

        return $user->userEquipments;
    }

    public function getDamage($type){
        return $this->loadModel(Yii::app()->user->id)->getDamage($type);
    }

    public function getArmed(){
        return $this->loadModel(Yii::app()->user->id)->getArmed();
    }

    public function getCash(){
        return $this->loadModel(Yii::app()->user->id)->cash;
    }

    public function getLog(array $params = null){

        $limit = (int)$params['limit'];

        return $this->loadModel($this->id)->userLog(array('limit'=>$limit, 'order'=>'id DESC'));
    }

    public function logHit($result){

        if($result == User::HIT_STATUS_PENDING){
            return false;
        }

        $user_log = new UserLog();
        $user_log->user_id = Yii::app()->user->id;
        $user_log->logHit($result);

        return $user_log->save();
    }

    /**
     * @param $id
     * @return User
     * @throws CHttpException
     */
    protected function loadModel($id){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $model = User::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    public function rise(){
        if(Yii::app()->user->isGuest){
            return false;
        }

        $user = $this->loadModel(Yii::app()->user->id);
        $user->alive = 1;
        $user->flushHp();
        $user->save();
    }

    public function  checkAlive(){
        return $this->loadModel(Yii::app()->user->id)->alive;
    }


}