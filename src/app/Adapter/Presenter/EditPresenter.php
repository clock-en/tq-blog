<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\EditViewModel;
use App\UseCase\UpdateArticle\UpdateArticleOutput;

final class EditPresenter
{
    private UpdateArticleOutput $output;

    public function __construct(UpdateArticleOutput $output)
    {
        $this->output = $output;
    }

    /**
     * ViewModelを返却
     * @return array
     */
    public function view(): array
    {
        $viewModel = new EditViewModel($this->output);
        return $viewModel->convertToWebView();
    }
}
