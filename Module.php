<?php

namespace mrstroz\wavecms\news;

/**
 * Class Module
 * @package mrstroz\wavecms\news
 * This is the main module class of the yii2-wavecms-news.
 */
class Module extends \yii\base\Module
{
    /**
     * @var array Class mapping
     */
    public $classMap = [];

    public function init()
    {
        $this->controllerNamespace = 'mrstroz\wavecms\news\controllers';

        parent::init();
    }

}
