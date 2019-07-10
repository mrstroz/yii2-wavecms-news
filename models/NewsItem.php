<?php

namespace mrstroz\wavecms\news\models;

use himiklab\sortablegrid\SortableGridBehavior;
use mrstroz\wavecms\components\behaviors\CheckboxListBehavior;
use mrstroz\wavecms\components\behaviors\ImageBehavior;
use mrstroz\wavecms\components\behaviors\SubListBehavior;
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
 * @property string $template
 * @property string $languages
 * @property string $image
 * @property string $image_mobile
 * @property string $link_rel
 * @property string $link_page_id
 * @property string $link_page_blank
 *
 * Attributes form NewsItemLang
 * @property string $title
 * @property string $text
 * @property string $link_title
 * @property string $link_page_url
 *
 * Relations
 * @property NewsItemLang[] $translations
 * @property News $news
 * @property NewsItem[] $items
 * @property NewsItem[] $gallery
 *
 */
class NewsItem extends \yii\db\ActiveRecord
{

    static public $templates = [
    ];

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
                'class' => SortableGridBehavior::class,
                'sortableAttribute' => 'sort'
            ],
            'checkbox_list' => [
                'class' => CheckboxListBehavior::class,
                'fields' => ['languages']
            ],
            'image' => [
                'class' => ImageBehavior::class,
                'attribute' => 'image',
            ],
            'image_mobile' => [
                'class' => ImageBehavior::class,
                'attribute' => 'image_mobile',
            ],
            'translate' => [
                'class' => TranslateBehavior::class,
                'translationAttributes' => [
                    'title', 'text', 'link_title', 'link_page_url'
                ]
            ],
            'gallery' => [
                'class' => SubListBehavior::class,
                'listId' => 'gallery',
                'route' => '/wavecms-news/gallery/sub-list',
                'parentField' => 'news_id'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['news_id', 'publish', 'sort', 'link_page_id', 'link_page_blank'], 'integer'],
            [['type', 'template'], 'string', 'max' => 255],
            [['image', 'image_mobile'], 'image'],
            [['languages', 'title'], 'required'],
            [['title', 'link_title', 'link_rel', 'link_page_url'], 'string', 'max' => 255],
            [['text'], 'string'],
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
            'template' => Yii::t('wavecms_news/main', 'Template'),
            'languages' => Yii::t('wavecms_news/main', 'Languages'),
            'image' => Yii::t('wavecms_news/main', 'Image'),
            'image_mobile' => Yii::t('wavecms_news/main', 'Image mobile'),
            'title' => Yii::t('wavecms_news/main', 'Title'),
            'text' => Yii::t('wavecms_news/main', 'Text'),
            'link_title' => Yii::t('wavecms_news/main', 'Link title'),
            'link_rel' => Yii::t('wavecms_news/main', 'Rel'),
            'link_page_id' => Yii::t('wavecms_news/main', 'Page'),
            'link_page_url' => Yii::t('wavecms_news/main', 'Url'),
            'link_page_blank' => Yii::t('wavecms_news/main', 'New tab')

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
    public function getNews()
    {
        return $this->hasOne(News::class, ['id' => 'news_id']);
    }

    /**
     * NewsItem relation
     * @return ActiveQuery|NewsItemQuery
     */
    public function getItems()
    {
        return $this->hasMany(__CLASS__, ['news_id' => 'id']);
    }

    /**
     * Gallery relation to NewsItem
     * @return ActiveQuery|NewsItemQuery
     */
    public function getGallery()
    {
        return $this->getItems()->getItems()->andWhere(['type' => 'gallery']);

    }
}
