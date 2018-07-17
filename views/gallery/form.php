<?php

use mrstroz\wavecms\components\helpers\FormHelper;
use mrstroz\wavecms\components\helpers\WavecmsForm;
use mrstroz\wavecms\components\widgets\CKEditorWidget;
use mrstroz\wavecms\components\widgets\LanguagesWidget;
use mrstroz\wavecms\components\widgets\TabsWidget;
use mrstroz\wavecms\components\widgets\TabWidget;
use mrstroz\wavecms\metatags\components\widgets\MetaTagsWidget;
use kartik\date\DatePicker;
use mrstroz\wavecms\components\widgets\ImageWidget;
use powerkernel\slugify\Slugify;
use yii\bootstrap\Html;

/** @var \mrstroz\wavecms\News\models\News $model */

?>

<?php $form = WavecmsForm::begin(); ?>

<?php TabsWidget::begin(); ?>

<?php echo Html::activeHiddenInput($model, 'type', ['value' => 'gallery']); ?>

<?php TabWidget::begin(['heading' => Yii::t('wavecms_news/main', 'General')]); ?>
<div class="row">

    <div class="col-md-8 col-lg-9">
        <?php echo $form->field($model, 'title'); ?>
        <?php echo $form->field($model, 'image')->widget(ImageWidget::class); ?>
    </div>
    <div class="col-md-4 col-lg-3">
        <?php echo LanguagesWidget::widget([
            'form' => $form,
            'model' => $model
        ]); ?>

    </div>
</div>
<?php TabWidget::end(); ?>



<?php TabsWidget::end(); ?>
<?php FormHelper::saveButton() ?>
<?php WavecmsForm::end(); ?>
