<?php
namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\ArticleSqlDao;
use App\Domain\Entity\Article;
use App\Domain\ValueObject\Article\ArticleId;
use App\Domain\ValueObject\Article\ArticleTitle;
use App\Domain\ValueObject\Article\ArticleContents;
use App\Domain\ValueObject\User\UserId;

final class ArticleQueryService
{
    private ArticleSqlDao $articleDao;

    public function __construct()
    {
        $this->articleDao = new ArticleSqlDao();
    }

    /**
     * 記事の一覧を取得する
     * @return Article[]|null
     */
    public function fetchArticles(): ?array
    {
        $articlesMapper = $this->articleDao->fetchArticles();
        return $this->existsPost($articlesMapper)
            ? $this->getArticleEntities($articlesMapper)
            : null;
    }

    /**
     * ArticleEntityの配列を生成
     * @param array
     * @return Article[]
     */
    private function getArticleEntities(array $articlesMapper): array
    {
        $output = [];
        foreach ($articlesMapper as $article) {
            $output[] = new Article(
                new ArticleId($article['id']),
                new UserId($article['user_id']),
                new ArticleTitle($article['title']),
                new ArticleContents($article['contents'])
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
