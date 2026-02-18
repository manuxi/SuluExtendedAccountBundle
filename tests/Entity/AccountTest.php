<?php

declare(strict_types=1);

namespace Manuxi\SuluExtendedAccountBundle\Tests\Entity;

use Manuxi\SuluExtendedAccountBundle\Entity\Account;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\ContactBundle\Entity\Account as SuluAccount;

class AccountTest extends TestCase
{
    private Account $account;

    protected function setUp(): void
    {
        $this->account = new Account();
    }

    public function testExtendsSuluAccount(): void
    {
        $this->assertInstanceOf(SuluAccount::class, $this->account);
    }

    public function testInheritedRegisterNumber(): void
    {
        $this->account->setRegisterNumber('HRB 12345');
        $this->assertSame('HRB 12345', $this->account->getRegisterNumber());
    }

    public function testInheritedPlaceOfJurisdiction(): void
    {
        $this->account->setPlaceOfJurisdiction('Amtsgericht Aachen');
        $this->assertSame('Amtsgericht Aachen', $this->account->getPlaceOfJurisdiction());
    }

    public function testDescriptor(): void
    {
        $this->assertNull($this->account->getDescriptor());
        $this->account->setDescriptor('Web Agency');
        $this->assertSame('Web Agency', $this->account->getDescriptor());
    }

    public function testClaim(): void
    {
        $this->assertNull($this->account->getClaim());
        $this->account->setClaim('We build the web');
        $this->assertSame('We build the web', $this->account->getClaim());
    }

    public function testBusinessHours(): void
    {
        $this->assertNull($this->account->getBusinessHours());

        $hours = [
            'monday' => [
                'enabled' => true,
                'break' => true,
                'slots' => [
                    ['start' => '08:00', 'end' => '12:00'],
                    ['start' => '13:00', 'end' => '17:00'],
                ],
            ],
        ];

        $this->account->setBusinessHours($hours);
        $this->assertSame($hours, $this->account->getBusinessHours());
    }

    public function testPublicHolidays(): void
    {
        $this->assertNull($this->account->getPublicHolidays());

        $holidays = [
            'country' => 'DE',
            'subdivision' => null,
            'year' => 2026,
            'holidays' => [
                ['date' => '2026-01-01', 'name' => 'Neujahr', 'enabled' => true],
            ],
        ];

        $this->account->setPublicHolidays($holidays);
        $this->assertSame($holidays, $this->account->getPublicHolidays());
    }

    public function testHolidayDates(): void
    {
        $this->assertNull($this->account->getHolidayDates());

        $dates = [
            ['start' => '2026-12-24', 'end' => '2027-01-02', 'label' => 'Weihnachtsferien', 'recurring' => true],
        ];

        $this->account->setHolidayDates($dates);
        $this->assertSame($dates, $this->account->getHolidayDates());
    }

    public function testNullableFields(): void
    {
        $this->account->setBusinessHours(null);
        $this->account->setPublicHolidays(null);
        $this->account->setHolidayDates(null);

        $this->assertNull($this->account->getBusinessHours());
        $this->assertNull($this->account->getPublicHolidays());
        $this->assertNull($this->account->getHolidayDates());
    }
}