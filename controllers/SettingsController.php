<?php

namespace mrstroz\wavecms\news\controllers;

use mrstroz\wavecms\components\web\Controller;
use mrstroz\wavecms\news\models\NewsSettings;
use Yii;
use yii\caching\Cache;

class SettingsController extends Controller
{

    public function init()
    {
        $this->type = 'settings';

        $this->modelClass = NewsSettings::class;
        $this->heading = Yii::t('wavecms_news/main', 'Settings');

        parent::init();
    }


}