<?php

namespace mrstroz\wavecms\news\models\search;

use mrstroz\wavecms\news\models\News;
use mrstroz\wavecms\news\models\NewsLang;
use Yii;
use yii\data\ActiveDataProvider;

class NewsSearch extends News
{

    public $title;
    public $link;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'link', 'create_date'], 'safe'],
        ];
    }

    /**
     * @param $dataProvider ActiveDataProvider
     * @return mixed
     */
    public function search($dataProvider)
    {
        $params = Yii::$app->request->get();

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $dataProvider->query->andFilterWhere(['or',
            [self::tableName() . '.id' => $this->id],
            ['like', News::tableName() . '.create_date', $this->create_date],
            ['like', NewsLang::tableName() . '.title', $this->title],
            ['like', NewsLang::tableName() . '.link', $this->link]
        ]);

        return $dataProvider;
    }


}
