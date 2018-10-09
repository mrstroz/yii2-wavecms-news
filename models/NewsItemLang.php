<?php

namespace mrstroz\wavecms\news\models;

use mrstroz\wavecms\news\models\query\NewsItemLangQuery;
use Yii;

/**
 * This is the model class for table "news_item_lang".
 *
 * @property int $id
 * @property string $news_item_id
 * @property string $language
 * @property string $title
 * @property string $text
 * @property string $link_title
 * @property string $link_page_url
 */
class NewsItemLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_item_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_item_id'], 'integer'],
            [['language'], 'string', 'max' => 10],
            [['text'], 'string'],
            [['title', 'link_title', 'link_page_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('wavecms_news/main', 'ID'),
            'news_item_id' => Yii::t('wavecms_news/main', 'News Item ID'),
            'language' => Yii::t('wavecms_news/main', 'Language'),
            'title' => Yii::t('wavecms_news/main', 'Title'),
            'text' => Yii::t('wavecms_news/main', 'Text'),
            'link_title' => Yii::t('wavecms_news/main', 'Link title'),
            'link_page_url' => Yii::t('wavecms_news/main', 'Url'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return NewsItemLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsItemLangQuery(get_called_class());
    }
}
