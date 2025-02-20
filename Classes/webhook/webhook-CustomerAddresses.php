<?php
class CustomerAddresses
{

    public string $addressLine1;

    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;
    }

    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    public string $addressLine2;

    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;
    }

    public function getAddressLine2(): string
    {
        return $this->addressLine2;
    }

    public string $street;

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public string $houseNumber;

    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;
    }

    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    public string $postalCode;

    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public string $city;

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public string $state;

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public string $country;

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}