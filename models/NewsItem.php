<?php

namespace mrstroz\wavecms\news\models;

use himiklab\sortablegrid\SortableGridBehavior;
use mrstroz\wavecms\components\behaviors\CheckboxListBehavior;
use mrstroz\wavecms\components\behaviors\ImageBehavior;
use mrstroz\wavecms\components\behaviors\TranslateBehavior;
use mrstroz\wavecms\news\models\query\NewsItemQuery;
use mrstroz\wavecms\news\models\query\NewsQuery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "news_item".
 *
 * @property int $id
 * @property int $news_id
 * @property int $publish
 * @property int $sort
 * @property string $type
 * @property string $languages
 * @property string $image
 *
 * @property string $title
 */
class NewsItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_item';
    }

    public function behaviors()
    {
        return [
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'sort'
            ],
            'checkbox_list' => [
                'class' => CheckboxListBehavior::class,
                'fields' => ['languages']
            ],
            'translate' => [
                'class' => TranslateBehavior::class,
                'translationAttributes' => [
                    'title'
                ]
            ],
            'image' => [
                'class' => ImageBehavior::class,
                'attribute' => 'image',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['languages'], 'required'],
            [['news_id', 'publish', 'sort'], 'integer'],
            [['type', 'image'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('wavecms_news/main', 'ID'),
            'news_id' => Yii::t('wavecms_news/main', 'News ID'),
            'publish' => Yii::t('wavecms_news/main', 'Publish'),
            'sort' => Yii::t('wavecms_news/main', 'Sort'),
            'type' => Yii::t('wavecms_news/main', 'Type'),
            'languages' => Yii::t('wavecms_news/main', 'Languages'),
            'image' => Yii::t('wavecms_news/main', 'Image'),
            'title' => Yii::t('wavecms_news/main', 'Title'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return NewsItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsItemQuery(get_called_class());
    }

    /**
     * Required for Translate behaviour
     * @return ActiveQuery|NewsItemLang
     */
    public function getTranslations()
    {
        return $this->hasMany(NewsItemLang::class, ['news_item_id' => 'id']);
    }

    /**
     * News relation
     * @return ActiveQuery|NewsQuery
     */
    public function getPage()
    {
        return $this->hasOne(News::class, ['id' => 'news_id']);
    }
}
