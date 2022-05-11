<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\CreatePostViewModel;
use App\UseCase\CreatePost\CreatePostOutput;

final class CreatePostPresenter
{
    private CreatePostOutput $output;

    public function __construct(CreatePostOutput $output)
    {
        $this->output = $output;
    }

    /**
     * ViewModelを返却
     * @return array
     */
    public function view(): array
    {
        $viewModel = new CreatePostViewModel($this->output);
        return $viewModel->convertToWebView();
    }
}
