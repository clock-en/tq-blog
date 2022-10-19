<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\MypageViewModel;
use App\Usecase\FetchUserArticles\FetchUserArticlesOutput;

final class MypagePresenter
{
    /** @var FetchUserArticlesOutput */
    private FetchUserArticlesOutput $output;

    /**
     * @param FetchUserArticlesOutput $output
     */
    public function __construct(FetchUserArticlesOutput $output)
    {
        $this->output = $output;
    }

    /**
     * ViewModelを返却
     * @return array{isSuccess: bool, message: string, articles: array|null}
     */
    public function view(): array
    {
        $viewModel = new MypageViewModel($this->output);
        return $viewModel->convertToWebView();
    }
}
