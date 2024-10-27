<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Todo;
use app\models\Category;
use yii\web\Response;

class TodoController extends Controller
{
    /**
     * Show todo list
     */
    public function actionIndex()
    {
        $categories = Category::find()->all();
        $todos = Todo::find()->with('category')->all();
        $model = new Todo();
        return $this->render('index', [
            'categories' => $categories,
            'todos' => $todos,
            'model' => $model
        ]);
    }

    /**
     * Add new todo item
     */
    public function actionCreate()
    {
        $model = new Todo();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $todos = Todo::find()->with('category')->all();
            return $this->renderPartial('todo_list', ['todos' => $todos]);
        }

        return ['error' => 'Failed to save the item'];
    }

    /**
     * Delete todo item
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $model = Todo::findOne($id);
        if ($model) {
            $model->delete();
        }
        $todos = Todo::find()->with('category')->all();
        return $this->renderPartial('todo_list', ['todos' => $todos]);
    }
}