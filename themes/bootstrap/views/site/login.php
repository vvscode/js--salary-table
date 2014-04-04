<?php

$this->pageTitle = Yii::app()->name . ' - Login';

?>




<div class="form login-form">
    <h1>Вход</h1>
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'login-form',
        'type' => 'horizontal',
        'inlineErrors' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    )); ?>

    <p class="note">Обязательные поля помечены <span class="required">*</span></p>

    <?php echo $form->textFieldRow($model, 'username'); ?>

    <?php echo $form->passwordFieldRow($model, 'password', array(
        'hint' => '',
    )); ?>

    <?php echo $form->checkBoxRow($model, 'rememberMe'); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => 'Войти',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>
