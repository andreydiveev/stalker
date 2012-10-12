<?php

class LogWidget extends CWidget{

    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }

    public function run()
    {
        $logPoints = Yii::app()->user->getLog(array('limit'=>UserLog::BASE_LOG_DISPLAY_LIMIT));

        $this->render('application.views.log.main', array('logPoints' => $logPoints));
        // этот метод будет вызван внутри CBaseController::endWidget()
    }
}