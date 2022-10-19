<?php
namespace App\Utils;

final class Session
{
    private static $instance;

    /**
     * シングルトンパターン
     */
    private function __construct()
    {
        self::initialize();
    }

    /**
     * シングルトンでインスタンスを生成
     * @return self
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * セッションの初期化処理
     */
    private static function initialize(): void
    {
        if (session_status() !== PHP_SESSION_NONE) {
            return;
        }
        // sessionIDをセキュアに取り扱う
        ini_set('session.cookie_secure', 1);
        ini_set('session.cookie_httponly', 1);
        session_start();
    }

    /**
     * 指定したキーのセッション変数を削除する
     * @param string $key
     */
    public function clear(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * セッションからエラーメッセージを取得し、セッションから削除する
     * @return array
     */
    public function popErrors(): array
    {
        $sessionKey = new SessionKey(SessionKey::ERRORS_KEY);
        $keyName = $sessionKey->getKeyName();
        $errors = $_SESSION[$keyName] ?? [];
        $this->clear($keyName);
        return $errors;
    }

    /**
     * エラーメッセージをセッションに追加する
     * @param string $message
     */
    public function appendError(string $message): void
    {
        $sessionKey = new SessionKey(SessionKey::ERRORS_KEY);
        $_SESSION[$sessionKey->getKeyName()][] = $message;
    }

    /**
     * エラーの存在チェック
     * @return bool
     */
    public function existsErrors(): bool
    {
        $sessionKey = new SessionKey(SessionKey::ERRORS_KEY);
        return !empty($_SESSION[$sessionKey->getKeyName()]);
    }

    /**
     * セッションからフォームの入力値を取得し、セッションから削除する
     * @return array
     */
    public function popFormInputs(): array
    {
        $sessionKey = new SessionKey(SessionKey::FORM_INPUTS_KEY);
        $keyName = $sessionKey->getKeyName();
        $formInputs = $_SESSION[$keyName] ?? [];
        $this->clear($keyName);
        return $formInputs;
    }

    /**
     * フォームの入力値をセッションに設定する
     * @param array $inputs
     */
    public function setFormInputs(array $inputs): void
    {
        $sessionKey = new SessionKey(SessionKey::FORM_INPUTS_KEY);
        $keyName = $sessionKey->getKeyName();
        foreach ($inputs as $key => $value) {
            $_SESSION[$keyName][$key] = $value;
        }
    }

    /**
     * セッションからフラッシュメッセージを取得し、セッションから削除する
     * @return array
     */
    public function popMessages(): array
    {
        $sessionKey = new SessionKey(SessionKey::MESSAGES_KEY);
        $keyName = $sessionKey->getKeyName();
        $messages = $_SESSION[$keyName] ?? [];
        $this->clear($keyName);
        return $messages;
    }

    /**
     * フラッシュメッセージをセッションに追加する
     * @param string $key
     * @param string $message
     */
    public function appendMessage(string $message): void
    {
        $sessionKey = new SessionKey(SessionKey::MESSAGES_KEY);
        $_SESSION[$sessionKey->getKeyName()][] = $message;
    }

    /**
     * セッションからログインユーザーの情報を取得する
     * @return array|null
     */
    public function getUser(): ?array
    {
        $sessionKey = new SessionKey(SessionKey::USER_KEY);
        return $_SESSION[$sessionKey->getKeyName()] ?? null;
    }

    /**
     * セッションからログインユーザーの情報を取得する
     * @param string $id
     * @param string $name
     */
    public function setUser(string $id, string $name): void
    {
        $sessionKey = new SessionKey(SessionKey::USER_KEY);
        $_SESSION[$sessionKey->getKeyName()] = ['id' => $id, 'name' => $name];
    }

    /**
     * ログインユーザー情報の存在チェック
     * @return bool
     */
    public function existsUser(): bool
    {
        $sessionKey = new SessionKey(SessionKey::USER_KEY);
        return !empty($_SESSION[$sessionKey->getKeyName()]);
    }

    /**
     * セッションの破棄
     */
    public function destroy(): void
    {
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        session_destroy();
    }
}
