<?php
namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\ArticleSqlDao;
use App\Domain\Entity\Article;
use App\Domain\ValueObject\Article\ArticleId;
use App\Domain\ValueObject\Article\ArticleTitle;
use App\Domain\ValueObject\Article\ArticleContents;
use App\Domain\ValueObject\Article\ArticleKeyword;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\JaDateTime;
use App\Domain\ValueObject\Order;

final class ArticleQueryService
{
    /** @var ArticleSqlDao */
    private ArticleSqlDao $articleDao;

    public function __construct()
    {
        $this->articleDao = new ArticleSqlDao();
    }

    /**
     * 記事の一覧を取得する
     * @param Order $order
     * @return ArrayObject<Article>|null
     */
    public function fetchAllArticles(Order $order): ?array
    {
        $articlesMapper = $this->articleDao->fetchAllArticles($order);
        return $this->existsPost($articlesMapper)
            ? $this->getArticleEntities($articlesMapper)
            : null;
    }

    /**
     * 記事検索
     * @param Order $order
     * @param ArticleKeyword $keyword
     * @return ArrayObject<Article>|null
     */
    public function searchArticlesByKeyword(
        Order $order,
        ArticleKeyword $keyword
    ): ?array {
        $articlesMapper = $this->articleDao->searchArticlesByKeyword(
            $order,
            $keyword
        );
        return $this->existsPost($articlesMapper)
            ? $this->getArticleEntities($articlesMapper)
            : null;
    }

    /**
     * ArticleEntityの配列を生成
     * @param array
     * @return ArrayObject<Article>
     */
    private function getArticleEntities(array $articlesMapper): array
    {
        $output = [];
        foreach ($articlesMapper as $article) {
            $output[] = new Article(
                new ArticleId($article['id']),
                new UserId($article['user_id']),
                new ArticleTitle($article['title']),
                new ArticleContents($article['contents']),
                new JaDateTime($article['created_at'])
            );
        }
        return $output;
    }

    /**
     * 記事の存在チェック
     * @param array|null $mapper
     * @return bool
     */
    private function existsPost(?array $mapper): bool
    {
        return !is_null($mapper);
    }
}
