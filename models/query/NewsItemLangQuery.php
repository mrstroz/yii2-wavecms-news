<?php

namespace mrstroz\wavecms\news\models\query;

/**
 * This is the ActiveQuery class for [[\mrstroz\wavecms\news\models\NewsItemLang]].
 *
 * @see \mrstroz\wavecms\news\models\NewsItemLang
 */
class NewsItemLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \mrstroz\wavecms\news\models\NewsItemLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \mrstroz\wavecms\news\models\NewsItemLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
