<?php

use dosamigos\switchinput\SwitchBox;
use mrstroz\wavecms\components\helpers\FormHelper;
use mrstroz\wavecms\components\helpers\WavecmsForm;
use mrstroz\wavecms\components\widgets\ImageWidget;
use mrstroz\wavecms\components\widgets\PanelWidget;
use mrstroz\wavecms\components\widgets\TabsWidget;
use mrstroz\wavecms\components\widgets\TabWidget;
use yii\bootstrap\Html;

?>

<?php $form = WavecmsForm::begin(); ?>

<?php TabsWidget::begin(); ?>

<?php echo Html::activeHiddenInput($model, 'type', ['value' => 'text']); ?>


<?php TabWidget::begin(['heading' => Yii::t('wavecms_news/main', 'Overview page')]); ?>
<?php  echo $form->field($model, 'overview_title'); ?>
<div class="row">
    <div class="col-md-8">
        <?php  echo $form->field($model, 'overview_link'); ?>
    </div>
    <div class="col-md-4">
        <?php  echo $form->field($model, 'news_on_page'); ?>
    </div>
</div>
<?php TabWidget::end(); ?>

<?php TabWidget::begin(['heading' => Yii::t('wavecms_news/main', 'Settings')]); ?>
<div class="row">

    <div class="col-md-12">

        <div class="row">

            <div class="col-md-6">
                <?php PanelWidget::begin(['heading' => Yii::t('wavecms_news/main', 'Sections')]); ?>
                <?php echo $form->field($model, 'is_sections')->widget(SwitchBox::class, [
                    'options' => [
                        'label' => false
                    ],
                    'clientOptions' => [
                        'onColor' => 'success',
                    ]
                ]); ?>
                <?php PanelWidget::end(); ?>
            </div>
        </div>


    </div>
</div>
<?php TabWidget::end(); ?>

<?php TabsWidget::end(); ?>
<?php FormHelper::saveButton() ?>
<?php WavecmsForm::end(); ?>
