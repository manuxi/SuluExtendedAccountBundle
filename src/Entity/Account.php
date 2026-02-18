<?php

namespace Manuxi\SuluExtendedAccountBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sulu\Bundle\ContactBundle\Entity\Account as SuluAccount;

#[ORM\Entity]
#[ORM\Table(name: 'co_accounts')]
class Account extends SuluAccount
{
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $regCourt = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $regNumber = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $descriptor = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $claim = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $monAm = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $monPm = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $tueAm = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $tuePm = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $wedAm = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $wedPm = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $thurAm = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $thurPm = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $friAm = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $friPm = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $satAm = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $satPm = null;


    public function setRegCourt(?string $regCourt): void
    {
        $this->regCourt = $regCourt;
    }

    public function getRegCourt(): ?string
    {
        return $this->regCourt;
    }

    public function setRegNumber(?string $regNumber): void
    {
        $this->regNumber = $regNumber;
    }

    public function getRegNumber(): ?string
    {
        return $this->regNumber;
    }

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

    public function getFriAm(): ?string
    {
        return $this->friAm;
    }

    public function setFriAm(?string $friAm): void
    {
        $this->friAm = $friAm;
    }

    public function getFriPm(): ?string
    {
        return $this->friPm;
    }

    public function setFriPm(?string $friPm): void
    {
        $this->friPm = $friPm;
    }

    public function getMonAm(): ?string
    {
        return $this->monAm;
    }

    public function setMonAm(?string $monAm): void
    {
        $this->monAm = $monAm;
    }

    public function getMonPm(): ?string
    {
        return $this->monPm;
    }

    public function setMonPm(?string $monPm): void
    {
        $this->monPm = $monPm;
    }

    public function getTueAm(): ?string
    {
        return $this->tueAm;
    }

    public function setTueAm(?string $tueAm): void
    {
        $this->tueAm = $tueAm;
    }

    public function getTuePm(): ?string
    {
        return $this->tuePm;
    }

    public function setTuePm(?string $tuePm): void
    {
        $this->tuePm = $tuePm;
    }

    public function getWedAm(): ?string
    {
        return $this->wedAm;
    }

    public function setWedAm(?string $wedAm): void
    {
        $this->wedAm = $wedAm;
    }

    public function getWedPm(): ?string
    {
        return $this->wedPm;
    }

    public function setWedPm(?string $wedPm): void
    {
        $this->wedPm = $wedPm;
    }

    public function getThurAm(): ?string
    {
        return $this->thurAm;
    }

    public function setThurAm(?string $thurAm): void
    {
        $this->thurAm = $thurAm;
    }

    public function getThurPm(): ?string
    {
        return $this->thurPm;
    }

    public function setThurPm(?string $thurPm): void
    {
        $this->thurPm = $thurPm;
    }

    public function getSatAm(): ?string
    {
        return $this->satAm;
    }

    public function setSatAm(?string $satAm): void
    {
        $this->satAm = $satAm;
    }

    public function getSatPm(): ?string
    {
        return $this->satPm;
    }

    public function setSatPm(?string $satPm): void
    {
        $this->satPm = $satPm;
    }



}