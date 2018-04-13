<?php

namespace mrstroz\wavecms\news\models;

use mrstroz\wavecms\news\models\query\NewsLangQuery;
use Yii;

/**
 * This is the model class for table "news_lang".
 *
 * @property string $id
 * @property string $news_id
 * @property string $language
 * @property string $title
 * @property string $link
 * @property string $text
 */
class NewsLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id'], 'integer'],
            [['text', 'language'], 'string'],
            [['title', 'link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('wavecms_news/main', 'ID'),
            'news_id' => Yii::t('wavecms_news/main', 'News ID'),
            'language' => Yii::t('wavecms_news/main', 'Language'),
            'title' => Yii::t('wavecms_news/main', 'Title'),
            'link' => Yii::t('wavecms_news/main', 'Link'),
            'text' => Yii::t('wavecms_news/main', 'Text'),
        ];
    }

    /**
     * @inheritdoc
     * @return NewsLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsLangQuery(get_called_class());
    }

    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }
}
