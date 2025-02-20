<?php
class CustomerEmailAddresses {
    public string $email;

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}