<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\DetailViewModel;
use App\UseCase\FindArticle\FindArticleOutput;
use App\UseCase\FetchArticleComments\FetchArticleCommentsOutput;

final class DetailPresenter
{
    /** @var FindArticleOutput */
    private FindArticleOutput $articleOutput;
    /** @var FetchArticleCommentsOutput */
    private FetchArticleCommentsOutput $commentOutput;

    /**
     * @param FindArticleOutput $articleOutput
     * @param FetchArticleCommentsOutput $commentOutput
     */
    public function __construct(
        FindArticleOutput $articleOutput,
        FetchArticleCommentsOutput $commentOutput
    ) {
        $this->articleOutput = $articleOutput;
        $this->commentOutput = $commentOutput;
    }

    /**
     * ViewModelを返却
     * @return array{isSuccess: bool, message: string, articles: array|null}
     */
    public function view(): array
    {
        $viewModel = new DetailViewModel(
            $this->articleOutput,
            $this->commentOutput
        );
        return $viewModel->convertToWebView();
    }
}
