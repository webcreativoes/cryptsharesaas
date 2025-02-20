<?php
class ContractComponent
{
    public string $id;

    public function setId($id) {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public string $contractId;

    public function setContractId($contractId) {
        $this->contractId = $contractId;
    }

    public function getContractId(): string
    {
        return $this->contractId;
    }

    public string $customerId;

    public function setCustomerId($customerId) {
        $this->customerId = $customerId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public string $componentId;

    public function setComponentId($componentId) {
        $this->componentId = $componentId;
    }

    public function getComponentId(): string
    {
        return $this->componentId;
    }

    public float $quantity;

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public string $startDate;

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public string $endDate;

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public string $billedUntil;

    public function setBilledUntil($billedUntil) {
        $this->billedUntil = $billedUntil;
    }

    public function getBilledUntil(): string
    {
        return $this->billedUntil;
    }

    public string $memo;

    public function setMemo($memo) {
        $this->memo = $memo;
    }

    public function getMemo(): string
    {
        return $this->memo;
    }

    public string $email;

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}