<?php

namespace app\repositories;

use app\models\Book;
use yii\web\NotFoundHttpException;
use yii\db\ActiveRecord;
class BookRepository
{

    /**
     * Summary of findById
     * @param int $id
     * @param bool $withAuthors
     * @throws NotFoundHttpException
     * @return Book
     */
    public function findById(int $id, $withAuthors = false): Book
    {
        $query = Book::find();
        if ($withAuthors) {
            $query->with('authors');
        }

        if (($model = $query->where(['book_id'=> $id])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException("Книга не найдена.");
    }
    
    /**
     * Summary of findAll
     * @return Book[]|null
     */
    public function findAll(): array
    {
        return Book::find()->all();
    }
    
}
