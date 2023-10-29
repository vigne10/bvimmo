<?php

namespace App\Model;

use DateTime;
use DateTimeZone;

const DATE_TIME_ZONE = new DateTimeZone('Europe/Brussels');

class User
{

    private ?int $id;
    private ?string $nameSurname;
    private ?string $address;
    private ?int $city;
    private ?string $email;
    private ?string $password;
    private ?DateTime $registrationDate;

    public function __construct(
        ?int $id = null,
        ?string $nameSurname = null,
        ?string $address = null,
        ?int $city = null,
        ?string $email = null,
        ?string $password = null,
        ?DateTime $registrationDate = null
    ) {
        $this->id = $id;
        $this->nameSurname = $nameSurname;
        $this->address = $address;
        $this->city = $city;
        $this->email = $email;
        $this->password = $password;
        $this->registrationDate = $registrationDate ?? new DateTime('now', DATE_TIME_ZONE);
    }

    public function getID(): ?int
    {
        return $this->id;
    }

    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNameSurname(): ?string
    {
        return $this->nameSurname;
    }

    public function setNameSurname(string $nameSurname): self
    {
        $this->nameSurname = $nameSurname;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getCityID(): ?int
    {
        return $this->city;
    }

    public function setCityID(int $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getRegistrationDate(): ?DateTime
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(DateTime $registrationDate): self
    {
        $this->registrationDate = $registrationDate;
        return $this;
    }
}
