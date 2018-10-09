<?php

namespace mrstroz\wavecms\news\models;

use himiklab\sitemap\behaviors\SitemapBehavior;
use mrstroz\wavecms\components\behaviors\CheckboxListBehavior;
use mrstroz\wavecms\components\behaviors\ImageBehavior;
use mrstroz\wavecms\components\behaviors\SubListBehavior;
use mrstroz\wavecms\components\behaviors\TranslateBehavior;
use mrstroz\wavecms\metatags\components\behaviors\MetaTagsBehavior;
use mrstroz\wavecms\news\models\query\NewsItemQuery;
use mrstroz\wavecms\news\models\query\NewsQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "news".
 *
 * @property string $id
 * @property integer $publish
 * @property string $type
 * @property string $create_date
 * @property string $image
 * @property string $template
 * @property string $languages
 * @property string $title
 * @property string $link
 * @property string $author
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property NewsLang[] $translations
 * @property NewsLang[] $items
 * @property NewsLang[] $sections
 */
class News extends ActiveRecord
{

    public $meta_title;
    public $meta_description;
    public $meta_keywords;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    public function behaviors()
    {
        return [
            'checkbox_list' => [
                'class' => CheckboxListBehavior::class,
                'fields' => ['languages']
            ],
            'translate' => [
                'class' => TranslateBehavior::class,
                'translationAttributes' => [
                    'title', 'link', 'text', 'author'
                ]
            ],
            'image' => [
                'class' => ImageBehavior::class,
                'attribute' => 'image',
            ],
            'meta_tags' => [
                'class' => MetaTagsBehavior::class
            ],
            'timestamp' => [
                'class' => TimestampBehavior::class
            ],
            'section' => [
                'class' => SubListBehavior::class,
                'listId' => 'section',
                'route' => '/wavecms-news/section/sub-list',
                'parentField' => 'news_id'
            ],
            'sitemap' => [
                'class' => SitemapBehavior::class,
                'scope' => function ($model) {
                    /** @var NewsQuery $model */
                    $model->byAllCriteria()->byType(['news']);
                },
                'dataClosure' => function ($model) {
                    $link = Yii::$app->settings->get('NewsSettings', 'overview_link');
                    return [
                        'loc' => Url::to(['/' . $link . '/' . $model->link], true),
                        'lastmod' => $model->updated_at,
                        'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
                        'priority' => 0.7
                    ];
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['languages', 'title', 'link', 'create_date'], 'required'],
            [['publish'], 'integer'],
            [['link'], 'validateUniqueLink'],
            [['type'], 'string', 'max' => 255],
            [['create_date', 'text', 'author'], 'string'],
            [['image'], 'image'],
            [['meta_title', 'meta_description', 'meta_keywords'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('wavecms_news/main', 'ID'),
            'publish' => Yii::t('wavecms_news/main', 'Publish'),
            'type' => Yii::t('wavecms_news/main', 'Type'),
            'create_date' => Yii::t('wavecms_news/main', 'Create date'),
            'image' => Yii::t('wavecms_news/main', 'Image'),
            'template' => Yii::t('wavecms_news/main', 'Template'),
            'title' => Yii::t('wavecms_news/main', 'Title'),
            'link' => Yii::t('wavecms_news/main', 'Link'),
            'author' => Yii::t('wavecms_news/main', 'Auhtor'),
            'text' => Yii::t('wavecms_news/main', 'Text'),
            'languages' => Yii::t('wavecms_news/main', 'Languages'),
            'newsLangTitle' => Yii::t('wavecms_news/main', 'Title'),
            'newsLangLink' => Yii::t('wavecms_news/main', 'Link'),
            'meta_title' => Yii::t('wavecms_news/main', 'Meta title'),
            'meta_description' => Yii::t('wavecms_news/main', 'Meta description'),
            'meta_keywords' => Yii::t('wavecms_news/main', 'Meta keywords'),
        ];
    }

    /**
     * @inheritdoc
     * @return NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    /**
     * Required for Translate behaviour
     * @return ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(NewsLang::class, ['news_id' => 'id']);
    }

    /**
     * NewsItem relation
     * @return ActiveQuery|NewsItemQuery
     */
    public function getItems()
    {
        return $this->hasMany(NewsItem::class, ['news_id' => 'id']);
    }

    /**
     * Sections relation to NewsItem
     * @return ActiveQuery|NewsItemQuery
     */
    public function getSections()
    {
        return $this->getItems()->getItems()->andWhere(['type' => 'section']);

    }

    /**
     * Validator for unique link per language
     * @param $attribute
     * @return void
     */
    public function validateUniqueLink($attribute)
    {

        $params = Yii::$app->request->get();
        $query = NewsLang::find()->joinWith('news')->andWhere([NewsLang::tableName() . '.language' => Yii::$app->wavecms->editedLanguage, NewsLang::tableName() . '.link' => $this->link]);

        if (isset($params['id'])) {
            $query->andWhere(['!=', News::tableName() . '.id', $params['id']]);
        }

        if ($query->count() !== '0') {
            $this->addError($attribute, Yii::t('wavecms_news/main', 'Link should be unique.'));
        }
    }

}
