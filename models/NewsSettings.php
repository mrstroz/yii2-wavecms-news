<?php

namespace mrstroz\wavecms\news\models;

use mrstroz\wavecms\components\base\SettingsModel;

class NewsSettings extends SettingsModel
{

    public $overview_title;
    public $overview_link;
    public $news_on_page;


    public function behaviors()
    {
        return parent::behaviors();
    }

    public function rules()
    {
        return [
            [['overview_link', 'overview_title'], 'string'],
            [['news_on_page'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'overview_title' => \Yii::t('wavecms_news/main', 'Title'),
            'overview_link' => \Yii::t('wavecms_news/main', 'Link'),
            'news_on_page' => \Yii::t('wavecms_news/main', 'News on page')
        ];
    }

}
