<?php
namespace App\UseCase\FetchArticleComments;

use App\Domain\Entity\Comment;

final class FetchArticleCommentsOutput
{
    /** @var bool */
    private bool $isSuccess;
    /** @var string */
    private string $message;
    /** @var ArrayObject<Article>|null */
    private ?array $comments;

    /**
     * @param bool $isSuccess
     * @param string $message
     * @param ArrayObject<Comment>|null $comments
     */
    public function __construct(
        bool $isSuccess,
        string $message,
        ?array $comments = null
    ) {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
        $this->comments = $comments;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }

    /**
     * @return ArrayObject<Comment>|null
     */
    public function comments(): ?array
    {
        return $this->comments;
    }
}
