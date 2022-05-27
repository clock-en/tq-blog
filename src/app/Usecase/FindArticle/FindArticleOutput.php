<?php
namespace App\UseCase\FindArticle;

use App\Domain\Entity\Article;

final class FindArticleOutput
{
    /** @var bool */
    private bool $isSuccess;
    /** @var string */
    private string $message;
    /** @var Article|null */
    private ?Article $article;

    /**
     * @param bool $isSuccess
     * @param string $message
     * @param Article|null $article
     */
    public function __construct(
        bool $isSuccess,
        string $message,
        ?Article $article = null
    ) {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
        $this->article = $article;
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
     * @return Article|null
     */
    public function article(): ?Article
    {
        return $this->article;
    }
}
