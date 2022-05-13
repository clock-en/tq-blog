<?php
namespace App\Infrastructure\Dao;

use PDO;
use App\Domain\ValueObject\Post\NewPost;

final class BlogSqlDao extends SqlDao
{
    const TABLE_NAME = 'blogs';

    /**
     * 新規記事作成
     * @param NewPost $post
     */
    public function create(NewPost $post): void
    {
        $sql = sprintf(
            'INSERT INTO %s (user_id, title, contents) VALUES (:userId, :title, :contents)',
            self::TABLE_NAME
        );
        $userId = $post->userId();
        $title = $post->title();
        $contents = $post->contents();

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':userId', $userId->value(), PDO::PARAM_STR);
        $statement->bindParam(':title', $title->value(), PDO::PARAM_STR);
        $statement->bindParam(':contents', $contents->value(), PDO::PARAM_STR);
        $statement->execute();
    }
}
