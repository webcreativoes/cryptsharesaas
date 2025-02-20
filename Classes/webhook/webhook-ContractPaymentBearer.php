<?php
class ContractPaymentBearer
{
    public string $cardType;

    public function setCardType($cardType)
    {
        $this->cardType = $cardType;
    }

    public function getCardType(): string
    {
        return $this->cardType;
    }

    public string $holder;

    public function setHolder($holder)
    {
        $this->holder = $holder;
    }

    public function getHolder(): string
    {
        return $this->holder;
    }

    public string $last4;

    public function setLast4($last4)
    {
        $this->last4 = $last4;
    }

    public function getLast4(): string
    {
        return $this->last4;
    }

    public string $type;

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
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

    public float $expiryMonth;

    public function setExpiryMonth($expiryMonth) {
        $this->expiryMonth = $expiryMonth;
    }

    public function getExpiryMonth(): string
    {
        return $this->expiryMonth;
    }

    public float $expiryYear;

    public function setExpiryYear($expiryYear) {
        $this->expiryYear = $expiryYear;
    }

    public function getExpiryYear(): string
    {
        return $this->expiryYear;
    }
}
