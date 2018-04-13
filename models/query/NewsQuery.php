<?php

namespace mrstroz\wavecms\news\models\query;

use mrstroz\wavecms\news\models\News;
use mrstroz\wavecms\news\models\NewsLang;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[News]].
 *
 * @see News
 */
class NewsQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return News[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return News|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return $this
     */
    public function getMap()
    {
        return $this
            ->select([News::tableName() . '.id', NewsLang::tableName() . '.link', News::tableName() . '.type'])
            ->joinLang();
    }

    /**
     * Get single news by link
     * @param $link
     * @return $this
     */
    public function getByLink($link)
    {
        return $this
            ->joinWith('translations')
            ->andWhere(['link' => $link]);
    }

    /**
     * Get news by all required criteria
     * @return $this
     */
    public function byAllCriteria()
    {
        return $this
            ->joinLang()
            ->byPublish()
            ->byNotEmptyLink()
            ->byLanguage();
    }

    /**
     * Get only published news
     * @param int $publish
     * @return $this
     */
    public function byPublish($publish = 1)
    {
        return $this->andWhere([News::tableName() . '.publish' => $publish]);
    }

    /**
     * Get news with not empty link
     * @return $this
     */
    public function byNotEmptyLink()
    {
        return $this
            ->andWhere(NewsLang::tableName() . '.link IS NOT NULL')
            ->andWhere(NewsLang::tableName() . '.link != ""');
    }

    /**
     * Get news by language
     * @param null|string $language
     * @return $this
     */
    public function byLanguage($language = null)
    {
        if (!$language) {
            if (Yii::$app->id === 'app-backend') {
                $language = Yii::$app->wavecms->editedLanguage;
            } else {
                $language = Yii::$app->language;
            }
        }

        return $this->andWhere(['REGEXP', News::tableName() . '.languages', '(^|;)(' . $language . ')(;|$)']);
    }

    /**
     * @param string|array $type
     * @return $this
     */
    public function byType($type)
    {
        return $this->andWhere([News::tableName() . '.type' => $type]);
    }

    /**
     * Join with language table by current language
     * @param null $language
     * @return $this
     */
    public function joinLang($language = null)
    {
        if (!$language) {
            if (Yii::$app->id === 'app-backend') {
                $language = Yii::$app->wavecms->editedLanguage;
            } else {
                $language = Yii::$app->language;
            }
        }

        return $this->leftJoin(NewsLang::tableName(),
            NewsLang::tableName() . '.news_id = ' . News::tableName() . '.id AND 
                ' . NewsLang::tableName() . '.language = "' . $language . '"');
    }
}
