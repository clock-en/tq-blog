<?php
namespace App\Usecase\FetchArticles;

use App\Domain\Entity\Article;

final class FetchArticlesOutput
{
    /** @var bool */
    private bool $isSuccess;
    /** @var string */
    private string $message;
    /** @var ArrayObject<Article>|null */
    private ?array $articles;

    /**
     * @param bool $isSuccess
     * @param string $message
     * @param ArrayObject<Article>|null $articles
     */
    public function __construct(
        bool $isSuccess,
        string $message,
        ?array $articles = null
    ) {
        $this->isSuccess = $isSuccess;
        $this->message = $message;
        $this->articles = $articles;
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
     * @return ArrayObject<Article>|null
     */
    public function articles(): ?array
    {
        return $this->articles;
    }
}
