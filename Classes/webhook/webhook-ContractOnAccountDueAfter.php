<?php
class OnAccountDueAfter
{
    public int $quantity;

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public string $unit;

    public function setUnit($unit) {
        $this->unit = $unit;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }
}