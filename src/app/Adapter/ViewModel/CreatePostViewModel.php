<?php
namespace App\Adapter\ViewModel;

use App\UseCase\CreatePost\CreatePostOutput;

final class CreatePostViewModel
{
    private CreatePostOutput $output;

    public function __construct(CreatePostOutput $output)
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
