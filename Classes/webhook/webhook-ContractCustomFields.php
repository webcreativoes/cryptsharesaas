<?php
class ContractCustomFields
{

    public string $contractId;

    public function setContractId($contractId)
    {
        $this->contractId = $contractId;
    }

    public function getContractId(): string
    {
        return $this->contractId;
    }

    public string $cSEmailUser;

    public function setCSEmailUser($cSEmailUser)
    {
        $this->cSEmailUser = $cSEmailUser;
    }

    public function getCSEmailUser(): string
    {
        return $this->cSEmailUser;
    }

    public string $cSFirstName;

    public function setCSFirstName($cSFirstName)
    {
        $this->cSFirstName = $cSFirstName;
    }

    public function getCSFirstName(): string
    {
        return $this->cSFirstName;
    }

    public string $cSLastName;

    public function setCSLastName($cSLastName)
    {
        $this->cSLastName = $cSLastName;
    }

    public function getCSLastName(): string
    {
        return $this->cSLastName;
    }

    public string $cSServer;

    public function setCSServer($cSServer)
    {
        $this->cSServer = $cSServer;
    }

    public function getCSServer(): string
    {
        return $this->cSServer;
    }

    public string $cSServerStatus;

    public function setCSServerStatus($cSServerStatus)
    {
        $this->cSServerStatus = $cSServerStatus;
    }

    public function getCSServerStatus(): string
    {
        return $this->cSServerStatus;
    }

    public string $customerId;

    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }
}