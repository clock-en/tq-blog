<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\Article\ArticleId;
use App\Domain\ValueObject\Comment\CommentId;
use App\Domain\ValueObject\Comment\CommenterName;
use App\Domain\ValueObject\Comment\CommentContents;
use App\Domain\ValueObject\JaDateTime;

final class Comment
{
    /** @var CommentId */
    private CommentId $id;
    /** @var UserId */
    private UserId $userId;
    /** @var ArticleId */
    private ArticleId $articleId;
    /** @var CommenterName */
    private CommenterName $commenterName;
    /** @var CommentContents */
    private CommentContents $contents;
    /** @var JaDateTime */
    private JaDateTime $createdAt;

    /**
     * @param CommentId $id
     * @param UserId $userId
     * @param ArticleId $articleId
     * @param CommenterName $commenterName
     * @param CommentContents $contents
     * @param JaDateTime $createdAt
     */
    public function __construct(
        CommentId $id,
        UserId $userId,
        ArticleId $articleId,
        CommenterName $commenterName,
        CommentContents $contents,
        JaDateTime $createdAt
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->articleId = $articleId;
        $this->commenterName = $commenterName;
        $this->contents = $contents;
        $this->createdAt = $createdAt;
    }

    /**
     * @return CommentId
     */
    public function id(): CommentId
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
     * @return ArticleId
     */
    public function articleId(): ArticleId
    {
        return $this->articleId;
    }

    /**
     * @return CommenterName
     */
    public function commenterName(): CommenterName
    {
        return $this->commenterName;
    }

    /**
     * @return CommentContents
     */
    public function contents(): CommentContents
    {
        return $this->contents;
    }

    /**
     * @return JaDateTime
     */
    public function createdAt(): JaDateTime
    {
        return $this->createdAt;
    }
}
