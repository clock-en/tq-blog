<?php
namespace App\UseCase\FetchUserArticles;

use App\Domain\ValueObject\User\UserId;

final class FetchUserArticlesInput
{
    /** @var UserId */
    private UserId $userId;

    /**
     * @param UserId
     */
    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }
}
