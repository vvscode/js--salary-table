<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" ng-app="salaryTableApp">
<head>
    <script type='text/javascript'>
        <?php
            echo 'var API_PREFIX = "'.Yii::app()->baseUrl.'/";';
            $ver = "?002b";
        ?>
    </script>
    <script type='text/javascript' src="<?php echo Yii::app()->baseUrl; ?>/js/libs/jquery.js"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->baseUrl; ?>/js/libs/angular.js"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->baseUrl; ?>/js/libs/angular-resource.js"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->baseUrl; ?>/js/libs/xeditable.js"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->baseUrl; ?>/js/services/services.js<?php echo $ver; ?>"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->baseUrl; ?>/js/services/users.js<?php echo $ver; ?>"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->baseUrl; ?>/js/services/salary.js<?php echo $ver; ?>"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->baseUrl; ?>/js/services/workers.js<?php echo $ver; ?>"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->baseUrl; ?>/js/app/salary-table.js<?php echo $ver; ?>"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/xeditable.css" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php Yii::app()->bootstrap->register(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css<?php echo $ver; ?>" />

    <?php
        $userId = Yii::app()->user->id;
        $userName = Yii::app()->user->name;
        Yii::app()->clientScript->registerScript('userName',"salaryTableApp.userName = '".$userName."';", CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScript('userId',"salaryTableApp.userId = '".$userId."';", CClientScript::POS_HEAD);
    ?>
</head>

<body>
    <?php $this->widget('bootstrap.widgets.TbNavbar',array(
        'type'=>'inverse',
        'items'=>array(
            array(
                'class'=>'bootstrap.widgets.TbMenu',
                'items'=>array(
                    array('label'=>'Пользователи', 'url'=>array('/site/page', 'view'=>'users'), 'visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'Работники', 'url'=>array('/site/page', 'view'=>'workers'), 'visible'=>!Yii::app()->user->isGuest),

                    array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                    array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
                ),
            ),
        ),
    )); ?>

    <div class="container" id="page">

        <?php if(isset($this->breadcrumbs)):?>
            <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                'links'=>$this->breadcrumbs,
            )); ?><!-- breadcrumbs -->
        <?php endif?>

        <?php echo $content; ?>

        <div class="clear"></div>

        <div id="footer"></div><!-- footer -->
    </div>
</body>
</html>
