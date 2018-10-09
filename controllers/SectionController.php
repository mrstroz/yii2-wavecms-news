<?php

namespace mrstroz\wavecms\news\controllers;

use mrstroz\wavecms\components\grid\ActionColumn;
use mrstroz\wavecms\components\grid\LanguagesColumn;
use mrstroz\wavecms\components\grid\PublishColumn;
use mrstroz\wavecms\components\grid\SortColumn;
use mrstroz\wavecms\components\web\Controller;
use mrstroz\wavecms\news\models\NewsItem;
use mrstroz\wavecms\page\models\PageItem;
use Yii;
use yii\grid\DataColumn;

class SectionController extends Controller
{

    public function init()
    {
        /** @var NewsItem $modelMenu */
        $model = Yii::createObject(NewsItem::class);

        $this->heading = Yii::t('wavecms_news/main', 'Sections');
        $this->query = $model::find()->andWhere(['type' => 'section']);

        $this->sort = true;

        $this->columns = array(
            [
                'attribute' => 'title',
            ],
            [
                'class' => DataColumn::class,
                'attribute' => 'template',
                'content' => function ($model) {
                    /** @var PageItem $model */
                    if (isset(NewsItem::$templates[$model->template])) {
                        return NewsItem::$templates[$model->template];
                    }
                }
            ],
            [
                'class' => LanguagesColumn::class,
            ],
            [
                'class' => SortColumn::class,
            ],
            [
                'class' => PublishColumn::class,
            ],
            [
                'class' => ActionColumn::class,
            ],
        );


        parent::init();
    }


}