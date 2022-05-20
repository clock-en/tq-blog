<?php
namespace App\UseCase\FetchArticles;

use App\Adapter\QueryService\ArticleQueryService;
use App\Domain\Entity\Article;

final class FetchArticlesInteractor
{
    const EMPTY_MESSAGE = '記事が一件もありませんでした。';
    const COMPLETE_MESSAGE = '記事を取得しました。';

    /** @var FetchArticlesInput */
    private FetchArticlesInput $input;
    /** @var ArticleQueryService */
    private ArticleQueryService $articleQueryService;

    /**
     * @param FetchArticlesInput $input
     */
    public function __construct(FetchArticlesInput $input)
    {
        $this->input = $input;
        $this->articleQueryService = new ArticleQueryService();
    }

    /**
     * インタラクタ実行
     * @return FetchArticlesOutput
     */
    public function handle(): FetchArticlesOutput
    {
        $articles = $this->fetchArticles();
        if (!$this->existsArticle($articles)) {
            return new FetchArticlesOutput(false, self::EMPTY_MESSAGE);
        }

        return new FetchArticlesOutput(true, self::COMPLETE_MESSAGE, $articles);
    }

    /**
     * 記事一覧の取得
     * @return ArrayObject<Article>|null
     */
    private function fetchArticles()
    {
        if ($this->input->keyword()->value() === '') {
            return $this->articleQueryService->fetchAllArticles(
                $this->input->order()
            );
        }
        return $this->articleQueryService->searchArticlesByKeyword(
            $this->input->order(),
            $this->input->keyword()
        );
    }

    /**
     * 記事の存在チェック
     * @param ArrayObject<Article>|null $articles
     * @return bool
     */
    private function existsArticle(?array $articles)
    {
        return !is_null($articles);
    }
}
