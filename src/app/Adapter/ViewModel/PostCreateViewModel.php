<?php
namespace App\Adapter\ViewModel;

use App\UseCase\CreateArticle\CreateArticleOutput;

final class PostCreateViewModel
{
    private CreateArticleOutput $output;

    public function __construct(CreateArticleOutput $output)
    {
        $this->output = $output;
    }

    /**
     * Web用ViewModelを返却
     * @return array
     */
    public function convertToWebView(): array
    {
        return [
            'isSuccess' => $this->output->isSuccess(),
            'message' => $this->output->message(),
        ];
    }
}
