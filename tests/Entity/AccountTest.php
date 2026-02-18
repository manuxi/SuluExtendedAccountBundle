<?php

declare(strict_types=1);

namespace Manuxi\SuluExtendedAccountBundle\Tests\Entity;

use Manuxi\SuluExtendedAccountBundle\Entity\Account;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    private Account $account;

    protected function setUp(): void
    {
        $this->account = new Account();
    }

    public function testRegCourtGetterSetter(): void
    {
        $this->assertNull($this->account->getRegCourt());

        $this->account->setRegCourt('Amtsgericht München');
        $this->assertSame('Amtsgericht München', $this->account->getRegCourt());

        $this->account->setRegCourt(null);
        $this->assertNull($this->account->getRegCourt());
    }

    public function testRegNumberGetterSetter(): void
    {
        $this->assertNull($this->account->getRegNumber());

        $this->account->setRegNumber('HRB 12345');
        $this->assertSame('HRB 12345', $this->account->getRegNumber());

        $this->account->setRegNumber(null);
        $this->assertNull($this->account->getRegNumber());
    }

    public function testDescriptorGetterSetter(): void
    {
        $this->assertNull($this->account->getDescriptor());

        $this->account->setDescriptor('Software Company');
        $this->assertSame('Software Company', $this->account->getDescriptor());

        $this->account->setDescriptor(null);
        $this->assertNull($this->account->getDescriptor());
    }

    public function testClaimGetterSetter(): void
    {
        $this->assertNull($this->account->getClaim());

        $this->account->setClaim('We build great things');
        $this->assertSame('We build great things', $this->account->getClaim());

        $this->account->setClaim(null);
        $this->assertNull($this->account->getClaim());
    }

    #[DataProvider('openingHoursProvider')]
    public function testOpeningHoursGetterSetter(string $getter, string $setter): void
    {
        $this->assertNull($this->account->$getter());

        $this->account->$setter('09:00 - 12:00');
        $this->assertSame('09:00 - 12:00', $this->account->$getter());

        $this->account->$setter(null);
        $this->assertNull($this->account->$getter());
    }

    public static function openingHoursProvider(): array
    {
        return [
            'Monday AM' => ['getMonAm', 'setMonAm'],
            'Monday PM' => ['getMonPm', 'setMonPm'],
            'Tuesday AM' => ['getTueAm', 'setTueAm'],
            'Tuesday PM' => ['getTuePm', 'setTuePm'],
            'Wednesday AM' => ['getWedAm', 'setWedAm'],
            'Wednesday PM' => ['getWedPm', 'setWedPm'],
            'Thursday AM' => ['getThurAm', 'setThurAm'],
            'Thursday PM' => ['getThurPm', 'setThurPm'],
            'Friday AM' => ['getFriAm', 'setFriAm'],
            'Friday PM' => ['getFriPm', 'setFriPm'],
            'Saturday AM' => ['getSatAm', 'setSatAm'],
            'Saturday PM' => ['getSatPm', 'setSatPm'],
        ];
    }

    public function testExtendsFromSuluAccount(): void
    {
        $this->assertInstanceOf(\Sulu\Bundle\ContactBundle\Entity\Account::class, $this->account);
    }
}
