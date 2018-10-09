<?php

namespace mrstroz\wavecms\news\controllers;

use mrstroz\wavecms\components\grid\ActionColumn;
use mrstroz\wavecms\components\grid\EditableColumn;
use mrstroz\wavecms\components\grid\LanguagesColumn;
use mrstroz\wavecms\components\grid\PublishColumn;
use mrstroz\wavecms\components\web\Controller;
use mrstroz\wavecms\news\models\NewsItem;
use mrstroz\wavecms\news\models\NewsItemLang;
use Yii;
use yii\data\ActiveDataProvider;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\helpers\VarDumper;

class GalleryController extends Controller
{

    public function init()
    {
        /** @var NewsItem $model */
        $model = Yii::createObject(NewsItem::class);
        /** @var NewsItemLang $modelLang */
        $modelLang = Yii::createObject(NewsItemLang::class);

        $this->heading = Yii::t('wavecms_news/main', 'Gallery');
        $this->query = $model::find()
            ->andWhere(['type' => 'gallery']);

        $this->dataProvider = new ActiveDataProvider([
            'query' => $this->query
        ]);

        $this->sort = true;

        /** @var NewsItem $parent */
        $parent = $model::find()->andWhere(['id' => Yii::$app->request->get('parentId')])->one();

        if ($parent) {
            $this->returnUrl = [
                '/wavecms-news/section/update',
                'id' => $parent->id,
                'parentField' => 'news_id',
                'parentId' => $parent->news_id,
                'parentRoute' => 'wavecms-news/news/update',
            ];
        }

        $this->columns = array(
            [
                'class' => DataColumn::class,
                'attribute' => 'image',
                'content' => function ($model) {
                    /** @var NewsItem $model */
                    if ($model->image) {
                        return Html::img(Yii::getAlias('@frontWeb') . '/images/thumbs/' . $model->image, ['class' => 'thumbnail', 'style' => 'height: 80px;']);
                    }
                }
            ],
            [
                'class' => EditableColumn::class,
                'attribute' => 'title'
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