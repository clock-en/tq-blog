<?php
namespace App\Adapter\Presenter;

use App\Adapter\ViewModel\SignUpViewModel;
use App\UseCase\SignUp\SignUpOutput;

final class SignUpPresenter
{
    private SignUpOutput $signUpOutput;

    public function __construct(SignUpOutput $signUpOutput)
    {
        $this->signUpOutput = $signUpOutput;
    }

    public function view(): array
    {
        $viewModel = new SignUpViewModel($this->signUpOutput);
        return $viewModel->convertToWebView();
    }
}
