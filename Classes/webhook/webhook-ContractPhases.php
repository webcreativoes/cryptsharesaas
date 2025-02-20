<?php
class ContractPhases {

    public string $type;

    public function setType($type) {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public string $startDate;

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public string $planVariantId;

    public function setPlanVariantId($planVariantId) {
        $this->planVariantId = $planVariantId;
    }

    public function getPlanVariantId(): string
    {
        return $this->planVariantId;
    }

    public string $planId;

    public function setPlanId($planId) {
        $this->planId = $planId;
    }

    public function getPlanId(): string
    {
        return $this->planId;
    }

    public int $quantity;

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public bool $inheritStartDate;

    public function setInheritStartDate($inheritStartDate) {
        $this->inheritStartDate = $inheritStartDate;
    }

    public function getInheritStartDate(): bool
    {
        return $this->inheritStartDate;
    }
}