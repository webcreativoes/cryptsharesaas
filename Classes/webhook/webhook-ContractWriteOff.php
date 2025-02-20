<?php
class ContractWriteOff
{
    public string $bookingDate;

    public function setBookingDate($bookingDate) {
        $this->bookingDate = $bookingDate;
    }

    public function getBookingDate(): string
    {
        return $this->bookingDate;
    }

    public string $writeOffDateTime;

    public function setWriteOffDateTime($writeOffDateTime) {
        $this->writeOffDateTime = $writeOffDateTime;
    }

    public function getWriteOffDateTime(): string
    {
        return $this->writeOffDateTime;
    }

    public float $totalGross;

    public function setTotalGross($totalGross) {
        $this->totalGross = $totalGross;
    }

    public function getTotalGross(): string
    {
        return $this->totalGross;
    }
}