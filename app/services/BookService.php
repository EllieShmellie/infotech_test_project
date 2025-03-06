<?php

namespace app\services;

use Yii;
use app\models\Book;
use app\repositories\BookRepository;
use yii\db\Exception;
use app\models\AuthorBook;

class BookService
{
    /**
     * @var BookRepository
     */
    protected $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(Book $model): void
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception('Ошибка при создании книги: ' . implode(', ', $model->getFirstErrors()));
            }
            
            $this->saveAuthorBooks($model);
            
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function update(Book $model): void
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$model->save()) {
                throw new Exception('Ошибка при обновлении книги: ' . implode(', ', $model->getFirstErrors()));
            }
            
            $this->saveAuthorBooks($model);
            
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

    }

    public function delete($id): void
    {
        $model = $this->repository->findById($id);
        if (!$model->delete()) {
            throw new Exception('Ошибка при удалении книги.');
        }
    }

    public function findModel($id): Book
    {
        return $this->repository->findById($id);
    }

    protected function saveAuthorBooks(Book $model): void
    {
        AuthorBook::deleteAll(['book_id' => $model->book_id]);
        if (!empty($model->author_ids) && is_array($model->author_ids)) {
            foreach ($model->author_ids as $authorId) {
                $authorBook = new AuthorBook();
                $authorBook->book_id = $model->book_id;
                $authorBook->author_id = $authorId;
                if (!$authorBook->save()) {
                    throw new Exception('Ошибка при сохранении связи между книгой и автором: ' . implode(', ', $authorBook->getFirstErrors()));
                }
            }
        }
    }
}
