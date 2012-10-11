<?php

class LogWidget extends CWidget
{
    const LOG_LIMIT = 5;

    public function init()
    {
        // этот метод будет вызван внутри CBaseController::beginWidget()
    }

    public function run()
    {
        $logPoints = Yii::app()->user->getLog(array('limit'=>LogWidget::LOG_LIMIT));

        $this->render('application.views.log.main', array('logPoints' => $logPoints));
        // этот метод будет вызван внутри CBaseController::endWidget()
    }
}