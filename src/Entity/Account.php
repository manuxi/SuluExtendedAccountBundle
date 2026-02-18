<?php

declare(strict_types=1);

namespace Manuxi\SuluExtendedAccountBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sulu\Bundle\ContactBundle\Entity\Account as SuluAccount;

#[ORM\Entity]
#[ORM\Table(name: 'co_accounts')]
class Account extends SuluAccount
{
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $descriptor = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $claim = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $businessHours = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $publicHolidays = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $holidayDates = null;

    public function getDescriptor(): ?string
    {
        return $this->descriptor;
    }

    public function setDescriptor(?string $descriptor): void
    {
        $this->descriptor = $descriptor;
    }

    public function getClaim(): ?string
    {
        return $this->claim;
    }

    public function setClaim(?string $claim): void
    {
        $this->claim = $claim;
    }

    public function getBusinessHours(): ?array
    {
        return $this->businessHours;
    }

    public function setBusinessHours(?array $businessHours): void
    {
        $this->businessHours = $businessHours;
    }

    public function getPublicHolidays(): ?array
    {
        return $this->publicHolidays;
    }

    public function setPublicHolidays(?array $publicHolidays): void
    {
        $this->publicHolidays = $publicHolidays;
    }

    public function getHolidayDates(): ?array
    {
        return $this->holidayDates;
    }

    public function setHolidayDates(?array $holidayDates): void
    {
        $this->holidayDates = $holidayDates;
    }
}