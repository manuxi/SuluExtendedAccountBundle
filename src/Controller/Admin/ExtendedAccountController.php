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
        /** @var AccountInterface|null $account */
        $account = $this->entityManager->getRepository(AccountInterface::class)->find($id);
        if (!$account) {
            throw new NotFoundHttpException();
        }

        if (!$account instanceof Account) {
            throw new \RuntimeException(sprintf('Account entity is not an instance of %s', Account::class));
        }

        //return $this->handleView($this->view($this->getDataForEntity($account)));
        return new JsonResponse($this->getDataForEntity($account));
    }

    #[Route(path: '/{id}', methods: ['PUT'], name: 'sulu_extended_account.put')]
    public function putAction(Request $request, int $id): Response
    {
        $account = $this->entityManager->getRepository(AccountInterface::class)->find($id);
        if (!$account) {
            throw new NotFoundHttpException();
        }

        $this->mapDataToEntity($request->request->all(), $account);
        $this->entityManager->flush();

        //return $this->handleView($this->view($this->getDataForEntity($account)));
        return new JsonResponse($this->getDataForEntity($account));
    }

    /**
     * @param Account $entity
     * @return array<string, mixed>
     */
    protected function getDataForEntity(Account $entity): array
    {
        return [
            'id' => $entity->getId(),
            'registerNumber' => $entity->getRegisterNumber(),
            'placeOfJurisdiction' => $entity->getPlaceOfJurisdiction(),

            'descriptor' => $entity->getDescriptor(),
            'claim' => $entity->getClaim(),

            'monAm' => $entity->getMonAm(),
            'monPm' => $entity->getMonPm(),
            'tueAm' => $entity->getTueAm(),
            'tuePm' => $entity->getTuePm(),
            'wedAm' => $entity->getWedAm(),
            'wedPm' => $entity->getWedPm(),
            'thurAm' => $entity->getThurAm(),
            'thurPm' => $entity->getThurPm(),
            'friAm' => $entity->getFriAm(),
            'friPm' => $entity->getFriPm(),
            'satAm' => $entity->getSatAm(),
            'satPm' => $entity->getSatPm(),
        ];
    }

    /**
     * @param array $data
     * @param Account $entity
     * @return void
     */
    protected function mapDataToEntity(array $data, Account $entity): void
    {
        $entity->setRegisterNumber($data['registerNumber']);
        $entity->setPlaceOfJurisdiction($data['placeOfJurisdiction']);

        $entity->setDescriptor($data['descriptor']);
        $entity->setClaim($data['claim']);

        $entity->setMonAm($data['monAm']);
        $entity->setMonPm($data['monPm']);
        $entity->setTueAm($data['tueAm']);
        $entity->setTuePm($data['tuePm']);
        $entity->setWedAm($data['wedAm']);
        $entity->setWedPm($data['wedPm']);
        $entity->setThurAm($data['thurAm']);
        $entity->setThurPm($data['thurPm']);
        $entity->setFriAm($data['friAm']);
        $entity->setFriPm($data['friPm']);
        $entity->setSatAm($data['satAm']);
        $entity->setSatPm($data['satPm']);
    }

    public function getSecurityContext(): string
    {
        return ContactAdmin::ACCOUNT_SECURITY_CONTEXT;
    }

}
