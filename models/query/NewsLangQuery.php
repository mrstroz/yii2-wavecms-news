<?php

namespace mrstroz\wavecms\news\models\query;

use mrstroz\wavecms\news\models\NewsLang;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[NewsLang]].
 *
 * @see NewsLang
 */
class NewsLangQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NewsLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NewsLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
