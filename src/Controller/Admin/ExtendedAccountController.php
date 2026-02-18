<?php

declare(strict_types=1);

namespace Manuxi\SuluExtendedAccountBundle\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use Manuxi\SuluExtendedAccountBundle\Entity\Account;
use Sulu\Bundle\ContactBundle\Admin\ContactAdmin;
use Sulu\Bundle\ContactBundle\Entity\AccountInterface;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Security\SecuredControllerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route(path: 'extended-account')]
class ExtendedAccountController extends AbstractRestController implements SecuredControllerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        ViewHandlerInterface $viewHandler,
        ?TokenStorageInterface $tokenStorage = null
    ) {
        $this->entityManager = $entityManager;

        parent::__construct($viewHandler, $tokenStorage);
    }

    #[Route(path: '/{id}', methods: ['GET'], name: 'sulu_extended_account.get')]
    public function getAction(int $id): Response
    {
        $account = $this->findAccountOrFail($id);

        return new JsonResponse($this->getDataForEntity($account));
    }

    #[Route(path: '/{id}', methods: ['PUT'], name: 'sulu_extended_account.put')]
    public function putAction(Request $request, int $id): Response
    {
        $account = $this->findAccountOrFail($id);

        $this->mapDataToEntity($request->request->all(), $account);
        $this->entityManager->flush();

        return new JsonResponse($this->getDataForEntity($account));
    }

    private function findAccountOrFail(int $id): Account
    {
        $account = $this->entityManager->getRepository(AccountInterface::class)->find($id);

        if (!$account) {
            throw new NotFoundHttpException();
        }

        if (!$account instanceof Account) {
            throw new \RuntimeException(\sprintf('Account entity is not an instance of %s', Account::class));
        }

        return $account;
    }

    /**
     * @return array<string, mixed>
     */
    private function getDataForEntity(Account $entity): array
    {
        return [
            'id' => $entity->getId(),
            'registerNumber' => $entity->getRegisterNumber(),
            'placeOfJurisdiction' => $entity->getPlaceOfJurisdiction(),
            'descriptor' => $entity->getDescriptor(),
            'claim' => $entity->getClaim(),
            'businessHours' => $entity->getBusinessHours(),
            'publicHolidays' => $entity->getPublicHolidays(),
            'holidayDates' => $entity->getHolidayDates(),
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    private function mapDataToEntity(array $data, Account $entity): void
    {
        if (\array_key_exists('registerNumber', $data)) {
            $entity->setRegisterNumber($data['registerNumber']);
        }
        if (\array_key_exists('placeOfJurisdiction', $data)) {
            $entity->setPlaceOfJurisdiction($data['placeOfJurisdiction']);
        }
        if (\array_key_exists('descriptor', $data)) {
            $entity->setDescriptor($data['descriptor']);
        }
        if (\array_key_exists('claim', $data)) {
            $entity->setClaim($data['claim']);
        }
        if (\array_key_exists('businessHours', $data)) {
            $entity->setBusinessHours($data['businessHours']);
        }
        if (\array_key_exists('publicHolidays', $data)) {
            $entity->setPublicHolidays($data['publicHolidays']);
        }
        if (\array_key_exists('holidayDates', $data)) {
            $entity->setHolidayDates($data['holidayDates']);
        }
    }

    public function getSecurityContext(): string
    {
        return ContactAdmin::ACCOUNT_SECURITY_CONTEXT;
    }
}