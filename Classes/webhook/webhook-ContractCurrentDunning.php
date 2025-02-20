<?php
class ContractCurrentDunning
{
    public int $level;

    public function setLevel($level) {
        $this->level = $level;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public float $amount;

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public float $remaining;

    public function setRemaining($remaining) {
        $this->remaining = $remaining;
    }

    public function getRemaining(): string
    {
        return $this->remaining;
    }

    public float $threshold;

    public function setThreshold($threshold) {
        $this->threshold = $threshold;
    }

    public function getThreshold(): string
    {
        return $this->threshold;
    }

    public string $documentId;

    public function setDocumentId($documentId) {
        $this->documentId = $documentId;
    }

    public function getDocumentId(): string
    {
        return $this->documentId;
    }

    public string $timestamp;

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public bool $isAtrigaEscalated;

    public function setIsAtrigaEscalated($isAtrigaEscalated) {
        $this->isAtrigaEscalated = $isAtrigaEscalated;
    }

    public function getIsAtrigaEscalated(): string
    {
        return $this->isAtrigaEscalated;
    }

    public string $atrigaStatus;

    public function setAtrigaStatus($atrigaStatus) {
        $this->atrigaStatus = $atrigaStatus;
    }

    public function getAtrigaStatus(): string
    {
        return $this->atrigaStatus;
    }

    public int $atrigaDunningLevel;

    public function setAtrigaDunningLevel($atrigaDunningLevel) {
        $this->atrigaDunningLevel = $atrigaDunningLevel;
    }

    public function getAtrigaDunningLevel(): int
    {
        return $this->atrigaDunningLevel;
    }
}