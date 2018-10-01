 <?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(['id' => 'pjax-grid-view']); ?>   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description',
            'sku',
            [
                'class' => 'yii\grid\ActionColumn',
                 'template' => '{view} {update} {delete} {myButton}',  // the default buttons + your custom button
            'buttons' => [
                'myButton' => function($url, $model, $key) {     // render your custom button
                    return '<a href="javascript:void(0)" class="calculate_sales" data-id="'.$model->id.'" title="Delete"><span class="glyphicon glyphicon-menu-hamburger"></span></a>';
                }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click',"a.calculate_sales",function(){
            var id = $(this).attr('data-id');
              $.ajax({url: "/yii-basic/web/post/calc", 
                method:'post',
                data:{id:id},
                success: function(result){
                     $.pjax({container: '#pjax-grid-view'})
                   // $("#div1").html(result);
            }});
        })
    })
</script>
 public function actionCalc()
    {
        print_r(Product::find()->where(['id'=>1])->sum('id'));exit;
        $model = Product::findOne($_POST['id']);
        $model->sku = "sku6.0";
        $model->save();
    }