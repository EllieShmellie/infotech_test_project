<?php

namespace app\repositories;

use app\models\Book;
use yii\web\NotFoundHttpException;

class BookRepository
{

    public function findById(int $id): Book
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException("Книга не найдена.");
    }
    
    public function findAll(): array
    {
        return Book::find()->all();
    }
    
}
