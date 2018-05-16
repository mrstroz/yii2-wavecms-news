# yii2-wavecms-news
**News module for [Yii 2 WaveCMS](https://github.com/mrstroz/yii2-wavecms).** 

Please do all install steps first from [Yii 2 WaveCMS](https://github.com/mrstroz/yii2-wavecms).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Run

```
composer require --prefer-source "mrstroz/yii2-wavecms-news" "*"
```

or add

```
"mrstroz/yii2-wavecms-news": "*"
```

to the require section of your `composer.json` file.


Required
--------

1. Update `backend/config/main.php` (Yii2 advanced template) 
```php
'modules' => [
    // ...
    'wavecms-news' => [
        'class' => 'mrstroz\wavecms\news\Module',
        /*
         * Override classes
        'classMap' => [
            'News' => 'common\models\News',
        ]
        */
    ],
],

```

Form views can be overwritten by backend [themes](http://www.yiiframework.com/doc-2.0/guide-output-theming.html);

2. Update `frontend/config/main.php` (Yii2 advanced template) 

```php
'modules' => [
    'sitemap' => [
        'class' => 'himiklab\sitemap\Sitemap',
        'models' => [
            'mrstroz\wavecms\news\models\News',
        ],
        'urls' => [
            [
                'loc' => ['/'],
                'changefreq' => \himiklab\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                'priority' => 1,
            ]
        ],
        'cacheExpire' => 1
    ]
],
// ...
'components' => [
    'urlManager' => [
        'rules' => [
            // Add rule for sitemap.xml
            ['pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml'],
        ],
    ],
]
```

3. Run migration 

Add the `migrationPath` in `console/config/main.php` and run `yii migrate`:

```php
// Add migrationPaths to console config:
'controllerMap' => [
    'migrate' => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationPath' => [
            '@vendor/mrstroz/yii2-wavecms-news/migrations',
        ],
    ],
],
```

Or run migrates directly

```yii
yii migrate/up --migrationPath=@vendor/mrstroz/yii2-wavecms-news/migrations
```


Overriding classes
------------------
Classes can be overridden by:
1. `classMap` attribute for WaveCMS module
```php
'modules' => [
    // ...   
    'wavecms-news' => [
        'class' => 'mrstroz\wavecms\news\Module',
        'classMap' => [
            'News' => \common\models\News::class
        ]
    ],
],
```

2. Yii2 Dependency Injection configuration in `backend/config/main.php`
```php
'container' => [
    'definitions' => [
        mrstroz\wavecms\news\models\News::class => common\models\News::class
    ],
],
```

Overriding controllers
----------------------
Use `controllerMap` attribute for WaveCMS module to override controllers
```php
'modules' => [
    // ...   
    'wavecms' => [
        'class' => 'mrstroz\wavecms\news\Module',
        'controllerMap' => [
            'news' => 'backend\controllers\NewsController'
        ]
    ],
],
```

Overriding views
--------------
Use **[themes](http://www.yiiframework.com/doc-2.0/guide-output-theming.html)** for override views
```php
'components' => [
    // ...
    'view' => [
        'theme' => [
            'basePath' => '@app/themes/basic',
            'baseUrl' => '@web/themes/basic',
            'pathMap' => [
                '@wavecms_news/views' => '@app/themes/basic/wavecms-news',
            ],
        ],
    ],
    // ...
],
```

Usage in frontend
-----------------

#### News
1. Add new rules to your urlManager. You can do it in one of your `Bootstrap` classes

```php
<?php
use mrstroz\wavecms\news\models\News;
use Yii;
// ...
//Parse request to set language before run ActiveRecord::find()
Yii::$app->urlManager->parseRequest(Yii::$app->request);

/** @var Settings $settings */
$settings = Yii::$app->settings;
$link = $settings->get('NewsSettings_' . Yii::$app->language, 'overview_link');

$model = Yii::createObject(News::class);

Yii::$app->getUrlManager()->addRules([
    $link => 'news/index'
]);

$news = $model::find()->select(['link'])->byAllCriteria()->byType(['news'])->column();

if ($news) {
    Yii::$app->getUrlManager()->addRules([
        $link . '/<link:(' . implode('|', $news) . ')>' => 'news/detail'
    ]);
}
```

2. Get list of news on overview page
```php
<?php

use mrstroz\wavecms\news\models\News;
use Yii;
use yii\data\Pagination;

public function actionIndex() {
    /** @var Settings $settings */
    $settings = Yii::$app->settings;
    $query = News::find()->byAllCriteria()->byType('news')->orderBy('create_date DESC');
    $count = $query->count();

    $pagination = new Pagination([
        'totalCount' => $count,
        'pageSize' => $settings->get('NewsSettings', 'news_on_page')
    ]);

    $news = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();

    return $this->render('index', [
        'news' => $news,
        'pagination' => $pagination
    ]);
}
```

3. Display news in view 'index.php'
```php
<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var \mrstroz\wavecms\news\models\News[] $news */
/** @var \yii\data\Pagination $pagination */

/** @var \yii2mod\settings\components\Settings $settings */
$settings = Yii::$app->settings;
$link = $settings->get('NewsSettings_' . Yii::$app->language, 'overview_link');

if ($news) {
    foreach ($news as $oneNews) {
        echo Html::a($oneNews->title, [$link . '/' . $oneNews->link]);
        echo '<br />';
    }
}

echo LinkPager::widget([
    'pagination' => $pagination,
]);

```

4. Get requested news by link in `detail` action
```php
<?php
use mrstroz\wavecms\news\models\News;
// ...
public function actionDetail($link)
{
    $news = News::find()->getByLink($link)->one();
    
    return $this->render('detail', [
        'news' => $news
    ]);
}
```



#### Meta tags
See [yii2-wavecms-metatags](https://github.com/mrstroz/yii2-wavecms-metatags)


#### Add news to sitemap
According to [Sitemap module](https://github.com/himiklab/yii2-sitemap-module), we need to add behaviour to our AR model and then add model to sitemap module configuration (see frontend/config/main.php)
```php
use himiklab\sitemap\behaviors\SitemapBehavior;

public function behaviors()
{
    return [
        'sitemap' => [
            'class' => SitemapBehavior::className(),
            'scope' => function ($model) {
                /** @var \yii\db\ActiveQuery $model */
                $model->select(['url', 'lastmod']);
                $model->andWhere(['is_deleted' => 0]);
            },
            'dataClosure' => function ($model) {
                /** @var self $model */
                return [
                    'loc' => Url::to($model->url, true),
                    'lastmod' => strtotime($model->lastmod),
                    'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
                    'priority' => 0.8
                ];
            }
        ],
    ];
}
```


Used packages
-------------
1. CKEditor https://github.com/MihailDev/yii2-ckeditor
2. ElFinder https://github.com/MihailDev/yii2-elfinder
3. Slugify https://github.com/powerkernel/yii2-slugify
4. Select2 https://github.com/kartik-v/yii2-widget-select2
5. Datepicker https://github.com/kartik-v/yii2-widget-datepicker
6. Switch widget https://github.com/2amigos/yii2-switch-widget
7. Sitemap - https://github.com/himiklab/yii2-sitemap-module


> ![INWAVE LOGO](http://inwave.pl/html/img/logo.png)  
> INWAVE - Internet Software House  
> [inwave.eu](http://inwave.eu/)





