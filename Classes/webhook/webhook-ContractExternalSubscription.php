<?php
class ContractExternalSubscription
{
    public string $id;

    public function setId($id) {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public string $type;

    public function setType($type) {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }
}