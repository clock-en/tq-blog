<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\DetailViewModel;
use App\UseCase\FindArticle\FindArticleOutput;

final class DetailPresenter
{
    /** @var FindArticleOutput */
    private FindArticleOutput $output;

    /**
     * @param FetchArticlesOutput $output
     */
    public function __construct(FindArticleOutput $output)
    {
        $this->output = $output;
    }

    /**
     * ViewModelを返却
     * @return array{isSuccess: bool, message: string, articles: array|null}
     */
    public function view(): array
    {
        $viewModel = new DetailViewModel($this->output);
        return $viewModel->convertToWebView();
    }
}
