<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\PostCreateViewModel;
use App\UseCase\CreateArticle\CreateArticleOutput;

final class PostCreatePresenter
{
    private CreateArticleOutput $output;

    public function __construct(CreateArticleOutput $output)
    {
        $this->output = $output;
    }

    /**
     * ViewModelを返却
     * @return array
     */
    public function view(): array
    {
        $viewModel = new PostCreateViewModel($this->output);
        return $viewModel->convertToWebView();
    }
}
