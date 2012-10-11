<?php

class SitemapCommand extends CConsoleCommand{
    public function actionIndex($type, $limit=5) { print("index_action \n");}
    public function actionInit() { print('init_action'); }
}