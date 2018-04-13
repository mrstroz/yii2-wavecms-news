<?php

namespace mrstroz\wavecms\news\controllers;

use mrstroz\wavecms\components\grid\ActionColumn;
use mrstroz\wavecms\components\grid\CheckboxColumn;
use mrstroz\wavecms\components\grid\LanguagesColumn;
use mrstroz\wavecms\components\grid\PublishColumn;
use mrstroz\wavecms\components\web\Controller;
use mrstroz\wavecms\news\models\News;
use mrstroz\wavecms\news\models\NewsLang;
use mrstroz\wavecms\news\models\search\NewsSearch;
use Yii;
use yii\data\ActiveDataProvider;

class NewsController extends Controller
{

    public function init()
    {
        /** @var News $model */
        $model = Yii::createObject(News::class);
        /** @var NewsLang $modelLang */
        $modelLang = Yii::createObject(NewsLang::class);

        $this->heading = Yii::t('wavecms_news/main', 'News');
        $this->query = $model::find()
            ->joinLang()
            ->andWhere(['type' => 'news']);

        $this->dataProvider = new ActiveDataProvider([
            'query' => $this->query
        ]);

        $this->dataProvider->sort->defaultOrder = ['create_date' => SORT_DESC];

        $this->dataProvider->sort->attributes['title'] = [
            'asc' => [$modelLang::tableName() . '.title' => SORT_ASC],
            'desc' => [$modelLang::tableName() . '.title' => SORT_DESC],
        ];

        $this->dataProvider->sort->attributes['link'] = [
            'asc' => [$modelLang::tableName() . '.link' => SORT_ASC],
            'desc' => [$modelLang::tableName() . '.link' => SORT_DESC],
        ];

        $this->filterModel = Yii::createObject(NewsSearch::class);

        $this->columns = array(
            [
                'class' => CheckboxColumn::className()
            ],
            [
                'attribute' => 'create_date',
            ],
            [
                'attribute' => 'title',
            ],
            [
                'attribute' => 'link',
            ],
            [
                'class' => LanguagesColumn::className(),
            ],
            [
                'class' => PublishColumn::className(),
            ],
            [
                'class' => ActionColumn::className(),
            ],
        );


        parent::init();
    }


}