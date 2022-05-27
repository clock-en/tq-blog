<?php
namespace App\Infrastructure\Dao;

use PDO;
use App\Domain\ValueObject\Article\NewArticle;
use App\Domain\ValueObject\Article\ArticleId;
use App\Domain\ValueObject\Article\ArticleKeyword;
use App\Domain\ValueObject\Order;

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
     * @param Order $order
     * @return array|null
     */
    public function fetchAllArticles(Order $order): ?array
    {
        $sql = sprintf(
            'SELECT * FROM %s ORDER BY created_at %s;',
            self::TABLE_NAME,
            $order->value()
        );
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $articles = $statement->fetchAll();
        return $articles ? $articles : null;
    }

    /**
     * 記事検索
     * @param Order $order
     * @param ArticleKeyword $keyword
     * @return array|null
     */
    public function searchArticlesByKeyword(
        Order $order,
        ArticleKeyword $keyword
    ): ?array {
        $sql = sprintf(
            'SELECT * FROM %s WHERE (title LIKE :keyword OR contents LIKE :keyword) ORDER BY created_at %s;',
            self::TABLE_NAME,
            $order->value()
        );
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(
            ':keyword',
            '%' . $keyword->value() . '%',
            PDO::PARAM_STR
        );
        $statement->execute();
        $articles = $statement->fetchAll();
        return $articles ? $articles : null;
    }

    /**
     * 記事取得 (ID)
     * @param ArticleId $id
     * @return array|null
     */
    public function findById(ArticleId $id)
    {
        $sql = sprintf('SELECT * FROM %s WHERE id=:id', self::TABLE_NAME);
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id->value(), PDO::PARAM_STR);
        $statement->execute();
        $article = $statement->fetch();
        return $article ? $article : null;
    }
}
