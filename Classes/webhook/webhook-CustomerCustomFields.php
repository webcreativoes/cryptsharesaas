<?php
class CustomerCustomFields {

    public string $cSDpaAccepted;

    public function setCSDpaAccepted($cSDpaAccepted)
    {
        $this->cSDpaAccepted = $cSDpaAccepted;
    }

    public function getCSDpaAccepted(): string
    {
        return $this->cSDpaAccepted;
    }

    public string $cSPartner;

    public function setCSPartner($cSPartner)
    {
        $this->cSPartner = $cSPartner;
    }

    public function getCSPartner(): string
    {
        return $this->cSPartner;
    }

    public string $cSIndustry;

    public function setCSIndustry($cSIndustry)
    {
        $this->cSIndustry = $cSIndustry;
    }

    public function getCSIndustry(): string
    {
        return $this->cSIndustry;
    }
}