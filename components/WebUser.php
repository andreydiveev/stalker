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