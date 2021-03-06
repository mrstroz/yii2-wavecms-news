<?php

use mrstroz\wavecms\components\helpers\FormHelper;
use mrstroz\wavecms\components\helpers\WavecmsForm;
use mrstroz\wavecms\components\widgets\CKEditorWidget;
use mrstroz\wavecms\components\widgets\LanguagesWidget;
use mrstroz\wavecms\components\widgets\SubListWidget;
use mrstroz\wavecms\components\widgets\TabsWidget;
use mrstroz\wavecms\components\widgets\TabWidget;
use mrstroz\wavecms\metatags\components\widgets\MetaTagsWidget;
use kartik\date\DatePicker;
use mrstroz\wavecms\components\widgets\ImageWidget;
use mrstroz\wavecms\metatags\components\widgets\OgTagsWidget;
use mrstroz\wavecms\metatags\models\MetaTags;
use mrstroz\wavecms\news\models\NewsSettings;
use powerkernel\slugify\Slugify;
use yii\bootstrap\Html;

/** @var \mrstroz\wavecms\News\models\News $model */

?>

<?php $form = WavecmsForm::begin(); ?>

<?php TabsWidget::begin(); ?>

<?php echo Html::activeHiddenInput($model, 'type', ['value' => 'news']); ?>

<?php TabWidget::begin(['heading' => Yii::t('wavecms_news/main', 'General')]); ?>
<div class="row">

    <div class="col-md-12">

        <div class="row">
            <div class="col-md-8 col-lg-9">
                <?php echo $form->field($model, 'title'); ?>
                <div class="row">
                    <div class="col-md-8">
                        <?php echo $form->field($model, 'link')->widget(Slugify::className(), ['source' => '#news-title']) ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo $form->field($model, 'author'); ?>
                    </div>
                </div>

                <?= $form->field($model, 'text')->widget(CKEditorWidget::className()) ?>

            </div>

            <div class="col-md-4 col-lg-3">
                <?php echo LanguagesWidget::widget([
                    'form' => $form,
                    'model' => $model
                ]); ?>

                <?php echo $form->field($model, 'create_date')->widget(DatePicker::className(), [
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd'
                    ]
                ]); ?>

                <?php echo $form->field($model, 'image')->widget(ImageWidget::className()); ?>
                <?php echo $form->field($model, 'image_mobile')->widget(ImageWidget::className()); ?>


            </div>
        </div>

    </div>
</div>
<?php TabWidget::end(); ?>

<?php
$settingsModel = Yii::createObject(NewsSettings::class);
if (Yii::$app->settings->get($settingsModel->formName(), 'is_sections') === '1'): ?>

    <?php TabWidget::begin(['heading' => Yii::t('wavecms_news/main', 'Sections')]); ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo SubListWidget::widget([
                'model' => $model,
                'listId' => 'section'
            ]) ?>
        </div>
    </div>
    <?php TabWidget::end(); ?>

<?php endif; ?>


<?php TabWidget::begin(['heading' => Yii::t('wavecms_news/main', 'Meta tags')]); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo MetaTagsWidget::widget(['model' => $model->metaTags, 'form' => $form]); ?>
        <?php echo OgTagsWidget::widget(['model' => $model->metaTags, 'form' => $form]); ?>
    </div>
</div>
<?php TabWidget::end(); ?>


<?php TabsWidget::end(); ?>
<?php FormHelper::saveButton() ?>
<?php WavecmsForm::end(); ?>
