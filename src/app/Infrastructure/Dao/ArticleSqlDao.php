<?php
namespace App\Infrastructure\Dao;

use PDO;
use App\Domain\ValueObject\Article\NewArticle;

final class ArticleSqlDao extends SqlDao
{
    const TABLE_NAME = 'articles';

    /**
     * 新規記事作成
     * @param NewArticle $article
     */
    public function create(NewArticle $article): void
    {
        $sql = sprintf(
            'INSERT INTO %s (user_id, title, contents) VALUES (:userId, :title, :contents)',
            self::TABLE_NAME
        );
        $userId = $article->userId();
        $title = $article->title();
        $contents = $article->contents();

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':userId', $userId->value(), PDO::PARAM_STR);
        $statement->bindParam(':title', $title->value(), PDO::PARAM_STR);
        $statement->bindParam(':contents', $contents->value(), PDO::PARAM_STR);
        $statement->execute();
    }

    /**
     * 記事の一覧取得
     * @return array|null
     */
    public function fetchAllArticles(): ?array
    {
        $sql = sprintf('SELECT * FROM %s', self::TABLE_NAME);
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $articles = $statement->fetchAll();
        return $articles ? $articles : null;
    }
}
