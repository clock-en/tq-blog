<?php
namespace App\Infrastructure\Dao;

use PDO;
use App\Domain\ValueObject\Comment\NewComment;
use App\Domain\ValueObject\Article\ArticleId;

final class CommentSqlDao extends SqlDao
{
    const TABLE_NAME = 'comments';

    /**
     * 新規コメント作成
     * @param NewComment $comment
     */
    public function create(NewComment $comment): void
    {
        $sql = sprintf(
            'INSERT INTO %s (user_id, article_id, commenter_name, comments) VALUES (:userId, :articleId, :commenterName, :comments)',
            self::TABLE_NAME
        );
        $userId = $comment->userId();
        $articleId = $comment->articleId();
        $commenterName = $comment->commenterName();
        $comments = $comment->contents();

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':userId', $userId->value(), PDO::PARAM_STR);
        $statement->bindParam(
            ':articleId',
            $articleId->value(),
            PDO::PARAM_STR
        );
        $statement->bindParam(
            ':commenterName',
            $commenterName->value(),
            PDO::PARAM_STR
        );
        $statement->bindParam(':comments', $comments->value(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * 記事の一覧取得
     * @param ArticleId $articleId
     * @return array|null
     */
    public function fetchCommentsByArticleId(ArticleId $articleId): ?array
    {
        $sql = sprintf(
            'SELECT * FROM %s WHERE article_id=:articleId ORDER BY created_at desc;',
            self::TABLE_NAME
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(
            ':articleId',
            $articleId->value(),
            PDO::PARAM_STR
        );
        $statement->execute();
        $Comments = $statement->fetchAll();
        return $Comments ? $Comments : null;
    }
}
