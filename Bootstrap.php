<?php

namespace mrstroz\wavecms\news;

use mrstroz\wavecms\components\helpers\FontAwesome;
use mrstroz\wavecms\news\models\News;
use mrstroz\wavecms\news\models\NewsLang;
use mrstroz\wavecms\news\models\NewsSettings;
use mrstroz\wavecms\news\models\query\NewsLangQuery;
use mrstroz\wavecms\news\models\query\NewsQuery;
use mrstroz\wavecms\news\models\search\NewsSearch;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Exception;
use yii\i18n\PhpMessageSource;

/**
 * Class Bootstrap
 * @package mrstroz\wavecms\news
 * Boostrap class for wavecms news
 */
class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::setAlias('@wavecms_news', '@vendor/mrstroz/yii2-wavecms-news');

        /** Set backend language based on user lang (Must be done before define translations */
        if ($app->id === 'app-backend') {
            if (!Yii::$app->user->isGuest) {
                Yii::$app->language = Yii::$app->user->identity->lang;
            }
        }

        $this->initTranslations();

        /** @var Module $module */
        if ($app->hasModule('wavecms') && ($module = $app->getModule('wavecms-news')) instanceof Module) {

            if ($app->id === 'app-backend') {

                $this->initNavigation();
                $this->initContainer($module);
            }
        }
    }

    /**
     * Init translations
     */
    protected function initTranslations()
    {
        Yii::$app->i18n->translations['wavecms_news/*'] = [
            'class' => PhpMessageSource::class,
            'basePath' => '@wavecms_news/messages',
            'fileMap' => [
                'main' => 'main.php',
            ],
        ];
    }

    /**
     * Init class map and dependency injection container
     * @param Module $module
     * @return void
     * @throws Exception
     */
    protected function initContainer($module)
    {
        $map = [];

        $defaultClassMap = [
            /* MODELS */
            'News' => News::class,
            'NewsLang' => NewsLang::class,
            'NewsSettings' => NewsSettings::class,

            /* QUERIES */
            'NewsQuery' => NewsQuery::class,
            'NewsLangQuery' => NewsLangQuery::class,

            /* SEARCH */
            'NewsSearch' => NewsSearch::class
        ];

        $routes = [
            'mrstroz\\wavecms\\news\\models' => [
                'News',
                'NewsLang',
                'NewsSettings',
            ],
            'mrstroz\\wavecms\\models\\news\\query' => [
                'NewsQuery',
                'NewsLangQuery',
            ],
            'mrstroz\\wavecms\\models\\news\\search' => [
                'NewsSearch'
            ]
        ];

        $mapping = array_merge($defaultClassMap, $module->classMap);

        foreach ($mapping as $name => $definition) {
            $map[$this->getContainerRoute($routes, $name) . "\\$name"] = $definition;
        }

        $di = Yii::$container;

        foreach ($map as $class => $definition) {
            /** Check if definition does not exist in container. */
            if (!$di->has($class)) {
                $di->set($class, $definition);
            }
        }

    }

    /**
     * Init left navigation
     */
    protected function initNavigation()
    {


        Yii::$app->params['nav']['wavecms_news'] = [
            'label' => FontAwesome::icon('newspaper') . Yii::t('wavecms_news/main', 'News'),
            'url' => 'javascript: ;',
            'options' => [
                'class' => 'drop-down'
            ],
            'permission' => 'wavecms_news',
            'position' => 3000,
            'items' => [
                ['label' => FontAwesome::icon('newspaper') . Yii::t('wavecms_news/main', 'News list'),
                    'url' => ['/wavecms-news/news/index']
                ],
                ['label' => FontAwesome::icon('cog') . Yii::t('wavecms_news/main', 'Settings'),
                    'url' => ['/wavecms-news/settings/settings']
                ]


            ]
        ];
    }

    /**
     * Get container route for class name
     * @param array $routes
     * @param $name
     * @throws \yii\base\Exception
     * @return int|string
     */
    private function getContainerRoute(array $routes, $name)
    {
        foreach ($routes as $route => $names) {
            if (in_array($name, $names, false)) {
                return $route;
            }
        }
        throw new Exception("Unknown configuration class name '{$name}'");
    }
}