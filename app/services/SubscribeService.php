<?php

namespace app\services;

use app\repositories\SubscribeRepository;
use Yii;
use app\models\Subscriber;

class SubscribeService
{
    private SubscribeRepository $repository;

    public function __construct(SubscribeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $authorId
     * @param string|null $phone
     * @return Subscriber
     * @throws \RuntimeException
     */
    public function subscribe(int $authorId, ?string $phone = null): Subscriber
    {
        if (!Yii::$app->user->isGuest) {
            $phone = Yii::$app->user->identity->phone;
        }
        if ($phone === null) {
            throw new \DomainException("Номер телефона не задан.");
        }
        $subscription = $this->repository->findSubscription($phone, $authorId);
        if ($subscription) {
            throw new \DomainException("Вы уже подписаны на этого автора.");
        }
        return $this->repository->createSubscription($phone, $authorId);
    }
}
