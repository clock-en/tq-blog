<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\SignInViewModel;
use App\UseCase\SignIn\SignInOutput;

final class SignInPresenter
{
    private SignInOutput $signInOutput;

    public function __construct(SignInOutput $signInOutput)
    {
        $this->signInOutput = $signInOutput;
    }

    /**
     * ViewModelを返却
     * @return array
     */
    public function view(): array
    {
        $viewModel = new SignInViewModel($this->signInOutput);
        return $viewModel->convertToWebView();
    }
}
