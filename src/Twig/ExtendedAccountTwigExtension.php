<?php

declare(strict_types=1);

namespace Manuxi\SuluExtendedAccountBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;
use Manuxi\SuluExtendedAccountBundle\Entity\Account;
use Sulu\Bundle\ContactBundle\Entity\AccountInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ExtendedAccountTwigExtension extends AbstractExtension
{
    private const DAY_MAP = [
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday',
        7 => 'sunday',
    ];

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_open_now', [$this, 'isOpenNow']),
            new TwigFunction('get_business_hours', [$this, 'getBusinessHours']),
            new TwigFunction('get_today_hours', [$this, 'getTodayHours']),
            new TwigFunction('is_holiday', [$this, 'isHoliday']),
        ];
    }

    public function isOpenNow(int $accountId): bool
    {
        $account = $this->findAccount($accountId);
        if (!$account) {
            return false;
        }

        $now = new \DateTime();

        if ($this->isNonWorkingDay($now, $account)) {
            return false;
        }

        $dayKey = self::DAY_MAP[(int) $now->format('N')] ?? null;
        if (!$dayKey) {
            return false;
        }

        $businessHours = $account->getBusinessHours();
        if (!$businessHours || !isset($businessHours[$dayKey])) {
            return false;
        }

        $dayConfig = $businessHours[$dayKey];
        if (!($dayConfig['enabled'] ?? false)) {
            return false;
        }

        $currentTime = $now->format('H:i');
        foreach ($dayConfig['slots'] ?? [] as $slot) {
            $start = $slot['start'] ?? '';
            $end = $slot['end'] ?? '';
            if ($start && $end && $currentTime >= $start && $currentTime <= $end) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<string, array{enabled: bool, break: bool, slots: array<array{start: string, end: string}>}>
     */
    public function getBusinessHours(int $accountId): array
    {
        $account = $this->findAccount($accountId);
        if (!$account) {
            return [];
        }

        return $account->getBusinessHours() ?? [];
    }

    /**
     * @return array{enabled: bool, break: bool, slots: array<array{start: string, end: string}>}|null
     */
    public function getTodayHours(int $accountId): ?array
    {
        $account = $this->findAccount($accountId);
        if (!$account) {
            return null;
        }

        $dayKey = self::DAY_MAP[(int) (new \DateTime())->format('N')] ?? null;
        if (!$dayKey) {
            return null;
        }

        $businessHours = $account->getBusinessHours();
        if (!$businessHours || !isset($businessHours[$dayKey])) {
            return null;
        }

        return $businessHours[$dayKey];
    }

    public function isHoliday(int $accountId): bool
    {
        $account = $this->findAccount($accountId);
        if (!$account) {
            return false;
        }

        return $this->isNonWorkingDay(new \DateTime(), $account);
    }

    private function isNonWorkingDay(\DateTime $date, Account $account): bool
    {
        $dateStr = $date->format('Y-m-d');

        if ($this->isPublicHoliday($dateStr, $account)) {
            return true;
        }

        if ($this->isCompanyHoliday($date, $account)) {
            return true;
        }

        return false;
    }

    private function isPublicHoliday(string $dateStr, Account $account): bool
    {
        $publicHolidays = $account->getPublicHolidays();
        if (!$publicHolidays || empty($publicHolidays['holidays'])) {
            return false;
        }

        foreach ($publicHolidays['holidays'] as $holiday) {
            if (($holiday['enabled'] ?? false) && ($holiday['date'] ?? '') === $dateStr) {
                return true;
            }
        }

        return false;
    }

    private function isCompanyHoliday(\DateTime $date, Account $account): bool
    {
        $holidayDates = $account->getHolidayDates();
        if (!$holidayDates) {
            return false;
        }

        $dateStr = $date->format('Y-m-d');
        $currentYear = (int) $date->format('Y');

        foreach ($holidayDates as $period) {
            $start = $period['start'] ?? '';
            $end = $period['end'] ?? '';

            if (!$start || !$end) {
                continue;
            }

            if ($period['recurring'] ?? false) {
                $startDate = \DateTime::createFromFormat('Y-m-d', $start);
                $endDate = \DateTime::createFromFormat('Y-m-d', $end);

                if (!$startDate || !$endDate) {
                    continue;
                }

                $startThisYear = (clone $startDate)->setDate($currentYear, (int) $startDate->format('m'), (int) $startDate->format('d'));
                $endThisYear = (clone $endDate)->setDate($currentYear, (int) $endDate->format('m'), (int) $endDate->format('d'));

                if ($dateStr >= $startThisYear->format('Y-m-d') && $dateStr <= $endThisYear->format('Y-m-d')) {
                    return true;
                }
            } else {
                if ($dateStr >= $start && $dateStr <= $end) {
                    return true;
                }
            }
        }

        return false;
    }

    private function findAccount(int $accountId): ?Account
    {
        $account = $this->entityManager->getRepository(AccountInterface::class)->find($accountId);

        if (!$account instanceof Account) {
            return null;
        }

        return $account;
    }
}