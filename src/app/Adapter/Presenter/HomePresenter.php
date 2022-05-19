<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\HomeViewModel;
use App\UseCase\FetchArticles\FetchArticlesOutput;

final class HomePresenter
{
    /** @var FetchArticlesOutput */
    private FetchArticlesOutput $output;

    /**
     * @param FetchArticlesOutput $output
     */
    public function __construct(FetchArticlesOutput $output)
    {
        $this->output = $output;
    }

    /**
     * ViewModelを返却
     * @return array{isSuccess: bool, message: string, articles: array|null}
     */
    public function view(): array
    {
        $viewModel = new HomeViewModel($this->output);
        return $viewModel->convertToWebView();
    }
}
