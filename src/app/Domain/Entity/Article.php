<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\Article\ArticleId;
use App\Domain\ValueObject\Article\ArticleTitle;
use App\Domain\ValueObject\Article\ArticleContents;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\JaDateTime;

final class Article
{
    private ArticleId $id;
    private UserId $userId;
    private ArticleTitle $title;
    private ArticleContents $contents;
    private JaDateTime $createdAt;

    /**
     * @param ArticleId $id
     * @param UserId $userId
     * @param ArticleTitle $title
     * @param ArticleContents $contents
     * @param JaDateTime $createdAt
     */
    public function __construct(
        ArticleId $id,
        UserId $userId,
        ArticleTitle $title,
        ArticleContents $contents,
        JaDateTime $createdAt
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->contents = $contents;
        $this->createdAt = $createdAt;
    }

    /**
     * @return ArticleId
     */
    public function id(): ArticleId
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return ArticleTitle
     */
    public function title(): ArticleTitle
    {
        return $this->title;
    }

    /**
     * @param ArticleTitle
     */
    public function updateTitle(ArticleTitle $title): void
    {
        $this->title = $title;
    }

    /**
     * @return ArticleContents
     */
    public function contents(): ArticleContents
    {
        return $this->contents;
    }

    /**
     * @param ArticleContents
     */
    public function updateContents(ArticleContents $contents): void
    {
        $this->contents = $contents;
    }

    /**
     * @return JaDateTime
     */
    public function createdAt(): JaDateTime
    {
        return $this->createdAt;
    }
}
