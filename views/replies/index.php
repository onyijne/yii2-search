<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use kartik\icons\Icon;
use nitm\widgets\replies\RepliesModal;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\Replies $searchModel
 */

$title = Yii::t('app', 'Replies: '.ucfirst($parentType).": ".$parentId);
switch(\Yii::$app->request->isAjax)
{
	case true:
	$this->title = $title;
	break;
}
$this->params['breadcrumbs'][] = $title;
if($useModal == true) {
	$modalOptions =[
		'class' => 'btn btn-success',
		'data-toggle' => 'modal',
		'data-target' => '#replies-modal-form'
	];
} else {
	$modalOptions = ['class' => 'btn btn-success'];
}
?>
<?php
	$options = is_array($options) ? $options : [
		'role' => 'entityMessages',
		'id' => 'messages'.$parentId,
		'data-parent' => 'replyFormParent'
	];
	echo ListView::widget([
		'options' => $options,
		'dataProvider' => $dataProvider,
		'itemOptions' => ['class' => 'item'],
		'itemView' => function ($model, $key, $index, $widget) {
				return $widget->render('@nitm/views/replies/view',['model' => $model]);
		},
	
	]);
?>
<?php
	if(isset($modal))
	{
		echo $modal;
	}
?>
<?php if(\Yii::$app->request->isAjax ): ?>
<script type="text/javascript">
$nitm.addOnLoadEvent(function () {
	$nitm.replies.init("messages<?=$parentId?>");
});
</script>
<?php endif; ?>
