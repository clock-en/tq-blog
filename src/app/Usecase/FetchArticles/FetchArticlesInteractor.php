<?php
namespace App\Usecase\FetchArticles;

use App\Adapter\QueryService\ArticleQueryService;
use App\Domain\Entity\Article;
use App\Domain\ValueObject\Order;

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
        // 並び順に指定がない場合は降順を設定して取得を行う
        if ($this->input->keyword()->value() === '') {
            return $this->articleQueryService->fetchAllArticles(
                $this->input->order() ?? new Order('desc')
            );
        }
        return $this->articleQueryService->searchArticlesByKeyword(
            $this->input->order() ?? new Order('desc'),
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
