<?php

namespace mrstroz\wavecms\news\models\query;
use mrstroz\wavecms\news\models\NewsItem;
use mrstroz\wavecms\news\models\NewsItemLang;
use mrstroz\wavecms\page\models\query\PageItemQuery;
use Yii;

/**
 * This is the ActiveQuery class for [[\mrstroz\wavecms\news\models\NewsItem]].
 *
 * @see \mrstroz\wavecms\news\models\NewsItem
 */
class NewsItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \mrstroz\wavecms\news\models\NewsItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \mrstroz\wavecms\news\models\NewsItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    /**
     * @return NewsItemQuery
     */
    public function getItems()
    {
        return $this->byCriteria()->orderBy('sort');
    }

    /**
     * @param $newsId
     * @return NewsItemQuery
     */
    public function byNewsId($newsId)
    {
        return $this->andWhere(['news_id' => $newsId]);
    }

    /**
     * @param $type
     * @return NewsItemQuery
     */
    public function byType($type)
    {
        return $this->andWhere(['type' => $type]);
    }

    /**
     * @return NewsItemQuery
     */
    public function byCriteria()
    {
        return $this
            ->joinWith('translations')
            ->andFilterWhere(['and',
                ['=', 'publish', '1'],
                ['REGEXP', 'languages', '(^|;)(' . Yii::$app->language . ')(;|$)']
            ]);
    }
}
