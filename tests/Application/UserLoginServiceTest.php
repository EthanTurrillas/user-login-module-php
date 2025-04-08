<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use Mockery;
use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Infrastructure\FacebookSessionManager;

final class UserLoginServiceTest extends TestCase
{
    /**
     * @test
     */
    public function userAlreadyLoggedIn()
    {
        $user = new User('Asier');
        $facebookSessionManager = Mockery::mock(FacebookSessionManager::class);
        $userLoginService = new UserLoginService($facebookSessionManager);

        $this->expectExceptionMessage("User already logged in");

        $userLoginService->manualLogin($user);
        $userLoginService->manualLogin($user);
    }

    /**
     * @test
     */
    public function userIsLoggedIn()
    {
        $user = new User("Asier");
        $facebookSessionManager = Mockery::mock(FacebookSessionManager::class);
        $userLoginService = new UserLoginService($facebookSessionManager);

        $result = $userLoginService->manualLogin($user);

        $this->assertEquals("Login successful", $result);
        $this->assertContains("Asier", $userLoginService->getLoggedUsers());
    }


    /**
     * @test
     */
    public function testGetNumberOfSessions()
    {
        $facebookSessionManager = Mockery::mock(FacebookSessionManager::class);
        $facebookSessionManager->shouldReceive('getSessions')
            ->once()
            ->andReturn(4);

        $userLoginService = new UserLoginService($facebookSessionManager);

        $this->assertEquals(4, $userLoginService->getExternalSession());
    }
}
