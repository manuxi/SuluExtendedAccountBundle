<?php

declare(strict_types=1);

namespace Manuxi\SuluExtendedAccountBundle\Tests\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\View\ViewHandlerInterface;
use Manuxi\SuluExtendedAccountBundle\Controller\Admin\ExtendedAccountController;
use Manuxi\SuluExtendedAccountBundle\Entity\Account;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\ContactBundle\Admin\ContactAdmin;
use Sulu\Bundle\ContactBundle\Entity\AccountInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ExtendedAccountControllerTest extends TestCase
{
    private ExtendedAccountController $controller;
    private EntityManagerInterface&MockObject $entityManager;
    private EntityRepository&MockObject $repository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $viewHandler = $this->createMock(ViewHandlerInterface::class);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);

        $this->repository = $this->createMock(EntityRepository::class);
        $this->entityManager->method('getRepository')
            ->with(AccountInterface::class)
            ->willReturn($this->repository);

        $this->controller = new ExtendedAccountController(
            $this->entityManager,
            $viewHandler,
            $tokenStorage
        );
    }

    public function testGetActionReturnsJsonResponse(): void
    {
        $account = $this->createAccountStub();
        $this->repository->method('find')->with(1)->willReturn($account);

        $response = $this->controller->getAction(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertSame(1, $data['id']);
        $this->assertSame('HRB 12345', $data['registerNumber']);
        $this->assertSame('Amtsgericht München', $data['placeOfJurisdiction']);
        $this->assertSame('Tech Company', $data['descriptor']);
        $this->assertSame('Innovation first', $data['claim']);
        $this->assertIsArray($data['businessHours']);
        $this->assertIsArray($data['publicHolidays']);
        $this->assertIsArray($data['holidayDates']);
    }

    public function testGetActionThrowsNotFoundWhenAccountMissing(): void
    {
        $this->repository->method('find')->with(999)->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->controller->getAction(999);
    }

    public function testGetActionThrowsRuntimeExceptionWhenNotExtendedAccount(): void
    {
        $basicAccount = $this->createMock(AccountInterface::class);
        $this->repository->method('find')->with(1)->willReturn($basicAccount);

        $this->expectException(\RuntimeException::class);
        $this->controller->getAction(1);
    }

    public function testPutActionUpdatesAndReturnsJsonResponse(): void
    {
        $account = $this->createAccountStub();
        $this->repository->method('find')->with(1)->willReturn($account);
        $this->entityManager->expects($this->once())->method('flush');

        $requestData = [
            'registerNumber' => 'HRB 99999',
            'placeOfJurisdiction' => 'Amtsgericht Berlin',
            'descriptor' => 'Updated',
            'claim' => 'New claim',
            'businessHours' => ['monday' => ['enabled' => true, 'break' => false, 'slots' => []]],
            'publicHolidays' => ['country' => 'DE', 'holidays' => []],
            'holidayDates' => [],
        ];

        $request = new Request([], $requestData);
        $response = $this->controller->putAction($request, 1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testPutActionThrowsNotFoundWhenAccountMissing(): void
    {
        $this->repository->method('find')->with(999)->willReturn(null);

        $request = new Request();
        $this->expectException(NotFoundHttpException::class);
        $this->controller->putAction($request, 999);
    }

    public function testGetSecurityContext(): void
    {
        $this->assertSame(
            ContactAdmin::ACCOUNT_SECURITY_CONTEXT,
            $this->controller->getSecurityContext()
        );
    }

    private function createAccountStub(): Account&MockObject
    {
        $account = $this->createMock(Account::class);
        $account->method('getId')->willReturn(1);
        $account->method('getRegisterNumber')->willReturn('HRB 12345');
        $account->method('getPlaceOfJurisdiction')->willReturn('Amtsgericht München');
        $account->method('getDescriptor')->willReturn('Tech Company');
        $account->method('getClaim')->willReturn('Innovation first');
        $account->method('getBusinessHours')->willReturn([
            'monday' => ['enabled' => true, 'break' => true, 'slots' => [['start' => '08:00', 'end' => '17:00']]],
        ]);
        $account->method('getPublicHolidays')->willReturn([
            'country' => 'DE', 'holidays' => [],
        ]);
        $account->method('getHolidayDates')->willReturn([]);

        return $account;
    }
}