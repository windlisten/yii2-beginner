<?php
namespace api\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class ArticleController extends ActiveController
{
    public $modelClass = 'api\models\User';

    /**
     * 行为是 yii\base\Behavior 或其子类的实例。
     * 行为，也称为 mixins， 可以无须改变类继承关系即可增强一个已有的 组件 类功能。
     * 当行为附加到组件后，它将“注入”它的方法和属性到组件， 然后可以像访问组件内定义的方法和属性一样访问它们。
     * 此外，行为通过组件能响应被触发的事件，从而自定义或调整组件正常执行的代码。
    **/
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        return $behaviors;
    }
}