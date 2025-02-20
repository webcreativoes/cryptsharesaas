<?php
class Customer
{
    public array $config;

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public array $token;

    public function setToken($config)
    {
        $this->token = getRestApiBearer($config);
    }

    public function getToken(): array
    {
        return $this->token;
    }

    public string $customerId;

    public function setCustomerId($customerId) {
        $this->customerId = $customerId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public string $createdAt;

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public bool $isDeletable;

    public function setIsDeletable($isDeletable) {
        $this->isDeletable = $isDeletable;
    }

    public function getIsDeletable(): bool
    {
        return $this->isDeletable;
    }

    public string $deletedAt;

    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    public function getDeletedAt(): string
    {
        return $this->deletedAt;
    }

    public bool $isLocked;

    public function setIsLocked($isLocked) {
        $this->isLocked = $isLocked;
    }

    public function getIsLocked(): bool
    {
        return $this->isLocked;
    }

    public string $deletionRequestedAt;

    public function setDeletionRequestedAt($deletionRequestedAt) {
        $this->deletionRequestedAt = $deletionRequestedAt;
    }

    public function getDeletionRequestedAt(): string
    {
        return $this->deletionRequestedAt;
    }

    public string $customerName;

    public function setCustomerName($customerName) {
        $this->customerName = $customerName;
    }

    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public string $customerSubName;

    public function setCustomerSubName($customerSubName) {
        $this->customerSubName = $customerSubName;
    }

    public function getCustomerSubName(): string
    {
        return $this->customerSubName;
    }

    public string $externalCustomerId;

    public function setExternalCustomerId($externalCustomerId) {
        $this->externalCustomerId = $externalCustomerId;
    }

    public function getExternalCustomerId(): string
    {
        return $this->externalCustomerId;
    }

    public string $debitorAccount;

    public function setDebitorAccount($debitorAccount) {
        $this->debitorAccount = $debitorAccount;
    }

    public function getDebitorAccount(): string
    {
        return $this->debitorAccount;
    }

    public string $companyName;

    public function setCompanyName($companyName) {
        $this->companyName = $companyName;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public string $firstName;

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public string $lastName;

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public string $vatId;

    public function setVatId($vatId) {
        $this->vatId = $vatId;
    }

    public function getVatId(): string
    {
        return $this->vatId;
    }

    public string $partnerCompanyCode;

    public function setPartnerCompanyCode($partnerCompanyCode) {
        $this->partnerCompanyCode = $partnerCompanyCode;
    }

    public function getPartnerCompanyCode(): string
    {
        return $this->partnerCompanyCode;
    }

    public string $emailAddress;

    public function setEmailAddress($emailAddress) {
        $this->emailAddress = $emailAddress;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public string $phoneNumber;

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public string $notes;

    public function setNotes($notes) {
        $this->notes = $notes;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public string $tag;

    public function setTag($tag) {
        $this->tag = $tag;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public string $timeZoneKey;

    public function setTimeZoneKey($timeZoneKey) {
        $this->timeZoneKey = $timeZoneKey;
    }

    public function getTimeZoneKey(): string
    {
        return $this->timeZoneKey;
    }

    public string $locale;

    public function setLocale($locale) {
        $this->locale = $locale;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public string $destinationCountry;

    public function setDestinationCountry($destinationCountry) {
        $this->destinationCountry = $destinationCountry;
    }

    public function getDestinationCountry(): string
    {
        return $this->destinationCountry;
    }

    public string $defaultBearerMedium;

    public function setDefaultBearerMedium($defaultBearerMedium) {
        $this->defaultBearerMedium = $defaultBearerMedium;
    }

    public function getDefaultBearerMedium(): string
    {
        return $this->defaultBearerMedium;
    }

    public string $customerType;

    public function setCustomerType($customerType) {
        $this->customerType = $customerType;
    }

    public function getCustomerType(): string
    {
        return $this->customerType;
    }

    public string $vatIdValidationStatus;

    public function setVatIdValidationStatus($vatIdValidationStatus) {
        $this->vatIdValidationStatus = $vatIdValidationStatus;
    }

    public function getVatIdValidationStatus(): string
    {
        return $this->vatIdValidationStatus;
    }

    public string $invoiceAttachmentFormat;

    public function setInvoiceAttachmentFormat($invoiceAttachmentFormat) {
        $this->invoiceAttachmentFormat = $invoiceAttachmentFormat;
    }

    public function getInvoiceAttachmentFormat(): string
    {
        return $this->invoiceAttachmentFormat;
    }

    public string $lastValidationDate;

    public function setLastValidationDate($lastValidationDate) {
        $this->lastValidationDate = $lastValidationDate;
    }

    public function getLastValidationDate(): string
    {
        return $this->lastValidationDate;
    }

    public bool $hidden;

    public function setHidden($hidden) {
        $this->hidden = $hidden;
    }

    public function getHidden(): bool
    {
        return $this->hidden;
    }

    public string $buyerReference;

    public function setBuyerReference($buyerReference) {
        $this->buyerReference = $buyerReference;
    }

    public function getBuyerReference(): string
    {
        return $this->buyerReference;
    }

    public array $emailAddresses;

    public function setEmailAddresses($emailAddresses) {
        $this->emailAddresses = $emailAddresses;
    }

    public function getEmailAddresses(): array
    {
        return $this->emailAddresses;
    }

    public array $addresses;

    public function setAddresses($addresses) {
        $this->addresses = $addresses;
    }

    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public array $customFields;

    public function setCustomFields($customFields) {
        $this->customFields = $customFields;
    }

    public function getCustomFields(): array
    {
        return $this->customFields;
    }

    public function customerCreated() {
        $this->setCustomer();
    }

    public function customerChanged() {
        $this->setCustomer();
    }

    public function customerDeleted() {
        $this->setCustomer();
    }

    public function customerLocked() {
        $this->setCustomer();
    }

    public function customerUnlocked() {
        $this->setCustomer();
    }

    public function setCustomer()
    {
        $data = [
            'CustomerId' => $this->getCustomerId()
        ];
        $customerDetails = callRestAPI($this->config, $data, 'get_customer', $this->token['access_token'], $bw_customer_id, false, false, true);
        $customerObject = json_decode($customerDetails);
        $this->setCustomerId((is_string($customerObject->Id) ? ''.$customerObject->Id.'' : ''));
        $this->setCreatedAt((is_string($customerObject->CreatedAt) ? ''.$customerObject->CreatedAt.'' : ''));
        $this->setIsDeletable((bool)$customerObject->IsDeletable);
        $this->setDeletedAt((is_string($customerObject->DeletedAt) ? ''.$customerObject->DeletedAt.'' : ''));
        $this->setIsLocked((bool)$customerObject->IsLocked);
        $this->setDeletionRequestedAt((is_string($customerObject->DeletionRequestedAt) ? ''.$customerObject->DeletionRequestedAt.'' : ''));
        $this->setCustomerName((is_string($customerObject->CustomerName) ? ''.$customerObject->CustomerName.'' : ''));
        $this->setCustomerSubName((is_string($customerObject->CustomerSubName) ? ''.$customerObject->CustomerSubName.'' : ''));
        $this->setExternalCustomerId((is_string($customerObject->ExternalCustomerId) ? ''.$customerObject->ExternalCustomerId.'' : ''));
        $this->setDebitorAccount((is_string($customerObject->DebitorAccount) ? ''.$customerObject->DebitorAccount.'' : ''));
        $this->setCompanyName((is_string($customerObject->CompanyName) ? ''.$customerObject->CompanyName.'' : ''));
        $this->setFirstName((is_string($customerObject->FirstName) ? ''.$customerObject->FirstName.'' : ''));
        $this->setLastName((is_string($customerObject->LastName) ? ''.$customerObject->LastName.'' : ''));
        $this->setVatId((is_string($customerObject->VatId) ? ''.$customerObject->VatId.'' : ''));
        $this->setPartnerCompanyCode((is_string($customerObject->PartnerCompanyCode) ? ''.$customerObject->PartnerCompanyCode.'' : ''));
        $this->setEmailAddress((is_string($customerObject->EmailAddress) ? ''.$customerObject->EmailAddress.'' : ''));
        $this->setPhoneNumber((is_string($customerObject->PhoneNumber) ? ''.$customerObject->PhoneNumber.'' : ''));
        $this->setNotes((is_string($customerObject->Notes) ? ''.$customerObject->Notes.'' : ''));
        $this->setTag((is_string($customerObject->Tag) ? ''.$customerObject->Tag.'' : ''));
        $this->setTimeZoneKey((is_string($customerObject->TimeZoneKey) ? ''.$customerObject->TimeZoneKey.'' : ''));
        $this->setLocale((is_string($customerObject->Locale) ? ''.$customerObject->Locale.'' : ''));
        $this->setDestinationCountry((is_string($customerObject->DestinationCountry) ? ''.$customerObject->DestinationCountry.'' : ''));
        $this->setDefaultBearerMedium((is_string($customerObject->DefaultBearerMedium) ? ''.$customerObject->DefaultBearerMedium.'' : ''));
        $this->setCustomerType((is_string($customerObject->CustomerType) ? ''.$customerObject->CustomerType.'' : ''));
        $this->setVatIdValidationStatus((is_string($customerObject->VatIdValidationStatus) ? ''.$customerObject->VatIdValidationStatus.'' : ''));
        $this->setInvoiceAttachmentFormat((is_string($customerObject->InvoiceAttachmentFormat) ? ''.$customerObject->InvoiceAttachmentFormat.'' : ''));
        $this->setLastValidationDate((is_string($customerObject->LastValidationDate) ? ''.$customerObject->LastValidationDate.'' : ''));
        $this->setHidden((bool)$customerObject->Hidden);
        $this->setBuyerReference((is_string($customerObject->BuyerReference) ? ''.$customerObject->BuyerReference.'' : ''));
        $this->setEmailAddresses((is_array($emails = $this->setEmailAddressesArray($customerObject->AdditionalEmailAddresses)) ? $emails : []));
        $this->setAddresses((is_array($addresses = $this->setAddressArray($customerObject->Address)) ? $addresses : []));
        $this->setCustomFields((is_array($customFields = $this->setCustomFieldsArray($customerObject->CustomFields)) ? $customFields : []));
    }

    public function setEmailAddressesArray($emailAddresses): array
    {
        $customerEmailAddresses = [];
        $customerEmailAddress = new CustomerEmailAddresses();
        if(is_array($emailAddresses)) {
            foreach ($emailAddresses as $emailAddress) {
                $customerEmailAddress->setEmail((is_string($emailAddress->EmailAddress) ? ''.$emailAddress->EmailAddress.'' : ''));
                $customerEmailAddresses[] = $customerEmailAddress;
            }
        } else {
            $customerEmailAddress->setEmail((is_string($emailAddresses->EmailAddress) ? ''.$emailAddresses->EmailAddress.'' : ''));
            $customerEmailAddresses[] = $customerEmailAddress;
        }
        return $customerEmailAddresses;
    }

    public function setAddressArray($addresses): array
    {
        $customerAddresses = [];
        $customerAddress = new CustomerAddresses();
        if(is_array($addresses)) {
            foreach ($addresses as $address) {
                $customerAddress->setAddressLine1((is_string($address->AddressLine1) ? ''.$address->AddressLine1.'' : ''));
                $customerAddress->setAddressLine2((is_string($address->AddressLine2) ? ''.$address->AddressLine2.'' : ''));
                $customerAddress->setStreet((is_string($address->Street) ? ''.$address->Street.'' : ''));
                $customerAddress->setHouseNumber((is_string($address->HouseNumber) ? ''.$address->HouseNumber.'' : ''));
                $customerAddress->setPostalCode((is_string($address->PostalCode) ? ''.$address->PostalCode.'' : ''));
                $customerAddress->setCity((is_string($address->City) ? ''.$address->City.'' : ''));
                $customerAddress->setState((is_string($address->State) ? ''.$address->State.'' : ''));
                $customerAddress->setCountry((is_string($address->Country) ? ''.$address->Country.'' : ''));
                $customerAddresses[] = $customerAddress;
            }
        } else {
            $customerAddress->setAddressLine1((is_string($addresses->AddressLine1) ? ''.$addresses->AddressLine1.'' : ''));
            $customerAddress->setAddressLine2((is_string($addresses->AddressLine2) ? ''.$addresses->AddressLine2.'' : ''));
            $customerAddress->setStreet((is_string($addresses->Street) ? ''.$addresses->Street.'' : ''));
            $customerAddress->setHouseNumber((is_string($addresses->HouseNumber) ? ''.$addresses->HouseNumber.'' : ''));
            $customerAddress->setPostalCode((is_string($addresses->PostalCode) ? ''.$addresses->PostalCode.'' : ''));
            $customerAddress->setCity((is_string($addresses->City) ? ''.$addresses->City.'' : ''));
            $customerAddress->setState((is_string($addresses->State) ? ''.$addresses->State.'' : ''));
            $customerAddress->setCountry((is_string($addresses->Country) ? ''.$addresses->Country.'' : ''));
            $customerAddresses[] = $customerAddress;
        }
        return $customerAddresses;
    }

    public function setCustomFieldsArray($fields): array
    {
        $customFields = [];
        $customField = new CustomerCustomFields();
        $customField->setCSDpaAccepted((is_string($fields->CSDpaAccepted) ? ''.$fields->CSDpaAccepted.'' : ''));
        $customField->setCSPartner((is_string($fields->CSPartner) ? ''.$fields->CSPartner.'' : ''));
        $customField->setCSIndustry((is_string($fields->CSIndustry) ? ''.$fields->CSIndustry.'' : ''));
        $customFields[] = $customField;
        return $customFields;
    }

    public function saveToDB($customer, $input, $webhookParameter, $sandbox = '0') {
        $dbConfig = $customer->getConfig();
        setWebhookLog($dbConfig['db_kpi_host'], $dbConfig['db_kpi_user'], $dbConfig['db_kpi_pwd'], $dbConfig['db_kpi_name'], '', $customer->getCustomerId(), $input['CustomerId'], $input['EntityId'], $input['OrderId'], $input['Event'], $webhookParameter, $sandbox, 0, 0, 0);
    }
}