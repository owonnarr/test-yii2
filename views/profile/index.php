<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

?>

<h1>Добрый день <?= $username ?></h1>

<a class="btn btn-info" href="<?= Url::toRoute(['login/logout']) ?>">Выйти</a>

