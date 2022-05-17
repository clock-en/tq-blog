<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\Article\ArticleId;
use App\Domain\ValueObject\Article\ArticleTitle;
use App\Domain\ValueObject\Article\ArticleContents;
use App\Domain\ValueObject\User\UserId;

final class Article
{
    private ArticleId $id;
    private UserId $userId;
    private ArticleTitle $title;
    private ArticleContents $contents;

    public function __construct(
        ArticleId $id,
        UserId $userId,
        ArticleTitle $title,
        ArticleContents $contents
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->contents = $contents;
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
     * @return ArticleContents
     */
    public function contents(): ArticleContents
    {
        return $this->contents;
    }
}
