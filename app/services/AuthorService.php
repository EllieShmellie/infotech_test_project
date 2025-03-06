<?php

namespace app\services;

use app\models\Author;
use app\repositories\AuthorRepository;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

class AuthorService
{
    /**
     * @var AuthorRepository
     */
    protected $repository;

    public function __construct(AuthorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(Author $model): void
    {
        if (!$model->save()) {
            throw new Exception('Ошибка при создании автора: ' . implode(', ', $model->getFirstErrors()));
        }
    }

    public function update(Author $model): void
    {
        if (!$model->save()) {
            throw new Exception('Ошибка при обновлении автора: ' . implode(', ', $model->getFirstErrors()));
        }
    }

    public function delete($id): void
    {
        $model = $this->repository->findById($id);
        if (!$model->delete()) {
            throw new Exception('Ошибка при удалении автора.');
        }
    }

    /**
     * @param int $id
     * @return Author
     */
    public function findModel ($id): Author
    {
        if (($model = $this->repository->findById($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрошенный автор не найден.');
    }

    /**
     * @param int $year
     * @param int $limit
     * @return array
     */
    public function getTopAuthors(int $year, int $limit = 10): array
    {
        return $this->repository->getTopAuthors($year, $limit);
    }
}
