<?php

namespace UserLoginService\Application;

use UserLoginService\Domain\User;
use UserLoginService\Infrastructure\FacebookSessionManager;

class UserLoginService
{
    private array $loggedUsers = [];

    public function __construct(private FacebookSessionManager $facebookSessionManager)
    {
    }

    public function manualLogin(User $user): string
    {
        if (in_array($user->getUserName(), $this->loggedUsers)) {
            throw new \Exception("User already logged in");
        }
        $this->loggedUsers[] = $user->getUserName();
        return "Login successful";
    }

    /**
     * @return array
     */
    public function getLoggedUsers(): array
    {
        return $this->loggedUsers;
    }

    public function getExternalSession()
    {
        return $this->facebookSessionManager->getSessions();
    }
}
