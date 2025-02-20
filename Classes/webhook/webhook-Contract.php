<?php

class Contract {

    public $mail;

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public array $config;

    public function setConfig($config) {
        $this->config = $config;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public array $token;

    public function setToken($config) {
        $this->token = getRestApiBearer($config);
    }

    public function getToken(): array
    {
        return $this->token;
    }

    public string $contractId;

    public function setContractId($contractId) {
        $this->contractId = $contractId;
    }

    public function getContractId(): string
    {
        return $this->contractId;
    }

    public string $id;

    public function setId($id) {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public string $lastBillingDate;

    public function setLastBillingDate($lastBillingDate) {
        $this->lastBillingDate = $lastBillingDate;
    }

    public function getLastBillingDate(): string
    {
        return $this->lastBillingDate;
    }

    public string $nextBillingDate;

    public function setNextBillingDate($nextBillingDate) {
        $this->nextBillingDate = $nextBillingDate;
    }

    public function getNextBillingDate(): string
    {
        return $this->nextBillingDate;
    }

    public string $planId;

    public function setPlanId($planId) {
        $this->planId = $planId;
    }

    public function getPlanId(): string
    {
        return $this->planId;
    }

    public string $customerId;

    public function setCustomerId($customerId) {
        $this->customerId = $customerId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public string $paymentTransactionId;

    public function setPaymentTransactionId($paymentTransactionId) {
        $this->paymentTransactionId = $paymentTransactionId;
    }

    public function getPaymentTransactionId(): string
    {
        return $this->paymentTransactionId;
    }

    public bool $isDeletable;

    public function setIsDeletable($isDeletable) {
        $this->isDeletable = $isDeletable;
    }

    public function getIsDeletable(): string
    {
        return $this->isDeletable;
    }

    public string $lifecycleStatus;

    public function setLifecycleStatus($lifecycleStatus) {
        $this->lifecycleStatus = $lifecycleStatus;
    }

    public function getLifecycleStatus(): string
    {
        return $this->lifecycleStatus;
    }

    public string $trialEndDate;

    public function setTrialEndDate($trialEndDate) {
        $this->trialEndDate = $trialEndDate;
    }

    public function getTrialEndDate(): string
    {
        return $this->trialEndDate;
    }

    public string $customerName;

    public function setCustomerName($customerName) {
        $this->customerName = $customerName;
    }

    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public bool $customerIsLocked;

    public function setCustomerIsLocked($customerIsLocked) {
        $this->customerIsLocked = $customerIsLocked;
    }

    public function getCustomerIsLocked(): bool
    {
        return $this->customerIsLocked;
    }

    public float $balance;

    public function setBalance($balance) {
        $this->balance = $balance;
    }

    public function getBalance(): string
    {
        return $this->balance;
    }

    public string $referenceCode;

    public function setReferenceCode($referenceCode) {
        $this->referenceCode = $referenceCode;
    }

    public function getReferenceCode(): string
    {
        return $this->referenceCode;
    }

    public string $currency;

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public string $planGroupId;

    public function setPlanGroupId($planGroupId) {
        $this->planGroupId = $planGroupId;
    }

    public function getPlanGroupId(): string
    {
        return $this->planGroupId;
    }

    public string $paymentProvider;

    public function setPaymentProvider($paymentProvider) {
        $this->paymentProvider = $paymentProvider;
    }

    public function getPaymentProvider(): string
    {
        return $this->paymentProvider;
    }

    public string $paymentProviderRole;

    public function setPaymentProviderRole($paymentProviderRole) {
        $this->paymentProviderRole = $paymentProviderRole;
    }

    public function getPaymentProviderRole(): string
    {
        return $this->paymentProviderRole;
    }

    public string $initialPaymentProviderRole;

    public function setInitialPaymentProviderRole($initialPaymentProviderRole) {
        $this->initialPaymentProviderRole = $initialPaymentProviderRole;
    }

    public function getInitialPaymentProviderRole(): string
    {
        return $this->initialPaymentProviderRole;
    }

    public bool $escalationSuspended;

    public function setEscalationSuspended($escalationSuspended) {
        $this->escalationSuspended = $escalationSuspended;
    }

    public function getEscalationSuspended(): string
    {
        return $this->escalationSuspended;
    }

    public bool $recurringPaymentsPaused;

    public function setRecurringPaymentsPaused($recurringPaymentsPaused) {
        $this->recurringPaymentsPaused = $recurringPaymentsPaused;
    }

    public function getRecurringPaymentsPaused(): string
    {
        return $this->recurringPaymentsPaused;
    }

    public bool $paymentProviderSupportRefunds;

    public function setPaymentProviderSupportRefunds($paymentProviderSupportRefunds) {
        $this->paymentProviderSupportRefunds = $paymentProviderSupportRefunds;
    }

    public function getPaymentProviderSupportRefunds(): bool
    {
        return $this->paymentProviderSupportRefunds;
    }

    public bool $billingSuspended;

    public function setBillingSuspended($billingSuspended) {
        $this->billingSuspended = $billingSuspended;
    }

    public function getBillingSuspended(): string
    {
        return $this->billingSuspended;
    }

    public bool $thresholdBillingDisabled;

    public function setThresholdBillingDisabled($thresholdBillingDisabled) {
        $this->thresholdBillingDisabled = $thresholdBillingDisabled;
    }

    public function getThresholdBillingDisabled(): string
    {
        return $this->thresholdBillingDisabled;
    }

    public string $turnoverGross;

    public function setTurnoverGross($turnoverGross) {
        $this->turnoverGross = $turnoverGross;
    }

    public function getTurnoverGross(): string
    {
        return $this->turnoverGross;
    }

    public string $turnoverNet;

    public function setTurnoverNet($turnoverNet) {
        $this->turnoverNet = $turnoverNet;
    }

    public function getTurnoverNet(): string
    {
        return $this->turnoverNet;
    }

    public float $prepaidCardsAmountRemaining;

    public function setPrepaidCardsAmountRemaining($prepaidCardsAmountRemaining) {
        $this->prepaidCardsAmountRemaining = $prepaidCardsAmountRemaining;
    }

    public function getPrepaidCardsAmountRemaining(): string
    {
        return $this->prepaidCardsAmountRemaining;
    }

    public string $externalId;

    public function setExternalId($externalId) {
        $this->externalId = $externalId;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public string $salesEntityId;

    public function setSalesEntityId($salesEntityId) {
        $this->salesEntityId = $salesEntityId;
    }

    public function getSalesEntityId(): string
    {
        return $this->salesEntityId;
    }

    public string $deletionRequestedAt;

    public function setDeletionRequestedAt($deletionRequestedAt) {
        $this->deletionRequestedAt = $deletionRequestedAt;
    }

    public function getDeletionRequestedAt(): string
    {
        return $this->deletionRequestedAt;
    }

    public array $writeOff;

    public function setWriteOff($writeOff) {
        $this->writeOff = $writeOff;
    }

    public function getWriteOff(): array
    {
        return $this->writeOff;
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

    public string $planVariantId;

    public function setPlanVariantId($planVariantId) {
        $this->planVariantId = $planVariantId;
    }

    public function getPlanVariantId(): string
    {
        return $this->planVariantId;
    }

    public string $notes;

    public function setNotes($notes) {
        $this->notes = $notes;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public string $paymentMethod;

    public function setPaymentMethod($paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public string $mandateReference;

    public function setMandateReference($mandateReference) {
        $this->mandateReference = $mandateReference;
    }

    public function getMandateReference(): string
    {
        return $this->mandateReference;
    }

    public string $mandateSignatureDate;

    public function setMandateSignatureDate($mandateSignatureDate) {
        $this->mandateSignatureDate = $mandateSignatureDate;
    }

    public function getMandateSignatureDate(): string
    {
        return $this->mandateSignatureDate;
    }

    public string $destinationCountry;

    public function setDestinationCountry($destinationCountry) {
        $this->destinationCountry = $destinationCountry;
    }

    public function getDestinationCountry(): string
    {
        return $this->destinationCountry;
    }

    public array $phases;

    public function setPhases($phases) {
        $this->phases = $phases;
    }

    public function getPhases(): array
    {
        return $this->phases;
    }

    public array $paymentBearer;

    public function setPaymentBearer($paymentBearer) {
        $this->paymentBearer = $paymentBearer;
    }

    public function getPaymentBearer(): array
    {
        return $this->paymentBearer;
    }

    public array $currentDunning;

    public function setCurrentDunning($currentDunning) {
        $this->currentDunning = $currentDunning;
    }

    public function getCurrentDunning(): array
    {
        return $this->currentDunning;
    }

    public array $externalSubscription;

    public function setExternalSubscription($externalSubscription) {
        $this->externalSubscription = $externalSubscription;
    }

    public function getExternalSubscription(): array
    {
        return $this->externalSubscription;
    }

    public array $onAccountDueAfter;

    public function setOnAccountDueAfter($onAccountDueAfter) {
        $this->onAccountDueAfter = $onAccountDueAfter;
    }

    public function getOnAccountDueAfter(): array
    {
        return $this->onAccountDueAfter;
    }

    public array $currentPhase;

    public function setCurrentPhase($currentPhase) {
        $this->currentPhase = $currentPhase;
    }

    public function getCurrentPhase(): array
    {
        return $this->currentPhase;
    }

    public array $customFields;

    public function setCustomFields($customFields) {
        $this->customFields = $customFields;
    }

    public function getCustomFields(): array
    {
        return $this->customFields;
    }

    public array $components;

    public function setComponents($components) {
        $this->components = $components;
    }

    public function getComponents(): array
    {
        return $this->components;
    }

    public function contractCreated() {
        $today = new DateTime(date('Y-m-d H:i:s'));
        $mailContent = 'Der Vertrag '.$this->getReferenceCode().' würde am '.$today->format('d.m.Y H:i:s').' neu erstellt.';
        //$this->sendMail('CSX contractCreated - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
    }

    public function contractChanged() {
        if($this->getEndDate()) {
            $today = new DateTime(date('Y-m-d H:i:s'));
            $endDate = new DateTime($this->getEndDate());
            $this->setNotes('Today: '.$today->format('d.m.Y H:i:s').' | Enddate: '.$endDate->format('d.m.Y H:i:s'));
            $mailContent = 'Der Vertrag '.$this->getReferenceCode().' würde zum '.$endDate->format('d.m.Y H:i:s').' gekündigt.';
            //$this->sendMail('CSX contractChanged - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
        }
    }

    public function contractDataChanged() {
        $today = new DateTime(date('Y-m-d H:i:s'));
        $mailContent = 'Der Vertrag '.$this->getReferenceCode().' würde am '.$today->format('d.m.Y H:i:s').' geändert.';
        //$this->sendMail('CSX contractDataChanged - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
    }

    public function contractCancelled() {
        $today = new DateTime(date('Y-m-d H:i:s'));
        $endDate = new DateTime($this->getEndDate());
        $mailContent = 'Der Vertrag '.$this->getReferenceCode().' würde am '.$today->format('d.m.Y H:i:s').' zum '.$endDate->format('d.m.Y H:i:s').' gekündigt.';
        //$this->sendMail('CSX contractCancelled - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
    }

    public function contractDeleted() {
        $today = new DateTime(date('Y-m-d H:i:s'));
        $mailContent = 'Der Vertrag '.$this->getReferenceCode().' würde am '.$today->format('d.m.Y H:i:s').' gelöscht.';
        //$this->sendMail('CSX contractDeleted - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
    }

    public function dunningCreated() {
    }

    public function invoiceCreated() {
    }

    public function invoiceCorrected() {
    }

    public function orderSucceeded() {
        $today = new DateTime(date('Y-m-d H:i:s'));
        $mailContent = 'Der Vertrag '.$this->getReferenceCode().' hat am '.$today->format('d.m.Y H:i').' eine neue Bestellung erfolgreich abgeschlossen.';
        //$send = $this->sendMail('CSX orderSucceeded - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
    }

    public function recurringBillingApproaching() {
        // No bad status
        $badStatus = 0;
        // Recurring Payment is paused => bad status +1
        $badStatus += (int)$this->getRecurringPaymentsPaused();
        // Billing is suspended => bad status +1
        $badStatus += (int)$this->getBillingSuspended();
        $paymentBearers = $this->getPaymentBearer();
        $numPaymentBearers = count($paymentBearers);
        if($numPaymentBearers > 0) {
            foreach($paymentBearers as $paymentBearer) {
                switch($paymentBearer->getType()) {
                    case 'CreditCard':
                        // Credit card year is smaller than current year => bad status +1
                        if(date("Y") > $paymentBearer->getExpiryYear()) {
                            $badStatus += 1;
                        }
                        // Credit card year is same as current year and Credit card month is smaller than current month => bad status +1
                        if(date("Y") == $paymentBearer->getExpiryYear() && date("n") > $paymentBearer->getExpiryMonth()) {
                            $badStatus += 1;
                        }
                        break;
                    case 'BankAccount':
                        break;
                }
            }
        }
        switch($this->getPlanVariantId()) {
            case '5c4ae888e369ee0e5c2a107a':
            case '5c177b2faa6777008c6391d2':
            case '5bbf35d7aa6777187461d0ec':
            case '5cae41394802002480137c97':
            case '5cae43df4802020c30c8da83':
            case '5cae45134802002480139655':
                $badStatus = -1;
                break;
            case '5e45291648020135e8aa07b5':
            case '5e4528f848020023ecf4747a':
                $badStatus = -2;
                break;
            case '60fac143a370a6cd01527026':
                $badStatus = -3;
                break;
        }
        // bad status is bigger than 1
        if($badStatus > 0) {
            // get components from contract
            // cancel components
            foreach($this->getComponents() as $component) {
                $data = [
                    'ContractId' => $component->getContractId(),
                    'ComponentId' => $component->getComponentId(),
                    'Memo' => $component->getMemo(),
                    'EndDate' => $component->getBilledUntil()
                ];
                callRestAPI($this->config, $data, 'cancel_component', $this->token['access_token'], $bw_customer_id, false, false);
            }
            // cancel Billwerk contract
            $data = [
                'ContractId' => $this->getContractId(),
                'EndDate' => $this->getNextBillingDate()
            ];
            callRestAPI($this->config, $data, 'cancel_contract', $this->token['access_token'], $bw_customer_id, false, false);
            $mailContent = 'Der Vertrag '.$this->getReferenceCode().' würde zum nächsten Zeitpunkt gekündigt, weil das Zahlungsmittel nicht rechtzeit aktualisiert wurde.';
            //$this->sendMail('CSX recurringBillingApproaching - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', true);
        } elseif($badStatus == -1) {
            $mailContent = 'Der Vertrag '.$this->getReferenceCode().' ist Cryptshare & Friends und wird fortgeführt.';
            //$this->sendMail('CSX recurringBillingApproaching - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
        } elseif($badStatus == -2) {
            $mailContent = 'Der Vertrag '.$this->getReferenceCode().' ist ATEA und wird fortgeführt.';
            //$this->sendMail('CSX recurringBillingApproaching - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
        } elseif($badStatus == -3) {
            $mailContent = 'Der Vertrag '.$this->getReferenceCode().' ist orangedental und wird fortgeführt.';
            //$this->sendMail('CSX recurringBillingApproaching - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
        } else {
            $mailContent = 'Der Vertrag '.$this->getReferenceCode().' wird fortgeführt.';
            //$this->sendMail('CSX recurringBillingApproaching - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false );
        }
    }

    public function trialEndApproaching() {
        $today = new DateTime(date('Y-m-d H:i:s'));
        $endDate = new DateTime($this->getEndDate());
        if($this->getEndDate()) {
            $mailContent = 'Der Vertrag '.$this->getReferenceCode().' hat am '.$today->format('d.m.Y H:i:s').' das Ende der Testversion erreicht und wurde gekündigt.';
        } else {
            $mailContent = 'Der Vertrag '.$this->getReferenceCode().' hat am '.$today->format('d.m.Y H:i:s').' das Ende der Testversion erreicht und wurde verlängert.';
        }
        //$this->sendMail('CSX trialEndApproaching - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
    }

    public function debitAuthCancelled() {
    }

    public function paymentBearerExpired() {
    }

    public function paymentBearerExpiring() {
    }

    public function paymentDataChanged() {
        $today = new DateTime(date('Y-m-d H:i:s'));
        $mailContent = 'Der Vertrag '.$this->getReferenceCode().' hat am '.$today->format('d.m.Y H:i:s').' seine Zahlungsdaten aktualisiert.';
        //$this->sendMail('CSX paymentDataChanged - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
    }

    public function paymentEscalated() {
    }

    public function paymentEscalationReset() {
    }

    public function paymentFailed() {
    }

    public function paymentProcessStatusChanged() {
    }

    public function paymentRegistered() {
    }

    public function paymentSucceeded() {
    }

    public function componentCreated() {
    }

    public function componentChanged() {
    }

    public function componentDeleted() {
    }

    public function accountCreated() {
    }

    public function setContract() {
        $data = [
            'ContractId' => $this->getContractId(),
            'CustomerId' => 'webhook'
        ];
        $contractDetails = callRestAPI($this->config, $data, 'get_contract', $this->token['access_token'], $bw_customer_id, false, false);
        $contractObject = json_decode($contractDetails);

        $data = [
            'ContractId' => $this->getContractId(),
            'CustomerId' => 'webhook'
        ];
        $componentDetails = callRestAPI($this->config, $data, 'get_components', $this->token['access_token'], $bw_customer_id, false, false);
        $componentObject = json_decode($componentDetails);

        $this->setId((is_string($contractObject->Id) ? ''.$contractObject->Id.'' : ''));
        $this->setLastBillingDate((is_string($contractObject->LastBillingDate) ? ''.$contractObject->LastBillingDate.'' : ''));
        $this->setNextBillingDate((is_string($contractObject->NextBillingDate) ? ''.$contractObject->NextBillingDate.'' : ''));
        $this->setPlanId((is_string($contractObject->PlanId) ? ''.$contractObject->PlanId.'' : ''));
        $this->setIsDeletable((bool)$contractObject->IsDeletable);
        $this->setLifecycleStatus((is_string($contractObject->LifecycleStatus) ? ''.$contractObject->LifecycleStatus.'' : ''));
        $this->setTrialEndDate((is_string($contractObject->TrialEndDate) ? ''.$contractObject->TrialEndDate.'' : ''));
        $this->setCustomerName((is_string($contractObject->CustomerName) ? ''.$contractObject->CustomerName.'' : ''));
        $this->setCustomerIsLocked((bool)$contractObject->CustomerIsLocked);
        $this->setPhases((is_array($phases = $this->setPhaseArray($contractObject->Phases)) ? $phases : []));
        $this->setBalance((is_numeric($contractObject->Balance) ? $contractObject->Balance : 0));
        $this->setReferenceCode((is_string($contractObject->ReferenceCode) ? ''.$contractObject->ReferenceCode.'' : ''));
        $this->setCurrency((is_string($contractObject->Currency) ? ''.$contractObject->Currency.'' : ''));
        $this->setPlanGroupId((is_string($contractObject->PlanGroupId) ? ''.$contractObject->PlanGroupId.'' : ''));
        $this->setPaymentBearer((is_array($paymentBearer = $this->setPaymentBearerArray($contractObject->PaymentBearer)) ? $paymentBearer : []));
        $this->setPaymentProvider((is_string($contractObject->PaymentProvider) ? ''.$contractObject->PaymentProvider.'' : ''));
        $this->setPaymentProviderRole((is_string($contractObject->PaymentProviderRole) ? ''.$contractObject->PaymentProviderRole.'' : ''));
        $this->setInitialPaymentProviderRole((is_string($contractObject->InitialPaymentProviderRole) ? ''.$contractObject->InitialPaymentProviderRole.'' : ''));
        $this->setEscalationSuspended((bool)$contractObject->EscalationSuspended);
        $this->setRecurringPaymentsPaused((bool)$contractObject->RecurringPaymentsPaused);
        $this->setCurrentPhase((is_array($currentPhase = $this->setPhaseArray($contractObject->CurrentPhase)) ? $currentPhase : []));
        $this->setPaymentProviderSupportRefunds((bool)$contractObject->PaymentProviderSupportRefunds);
        $this->setCurrentDunning((is_array($currentDunning = $this->setCurrentDunningArray($contractObject->CurrentDunning)) ? $currentDunning : []));
        $this->setBillingSuspended((bool)$contractObject->BillingSuspended);
        $this->setThresholdBillingDisabled((bool)$contractObject->ThresholdBillingDisabled);
        $this->setTurnoverGross((is_string($contractObject->TurnoverGross) ? ''.$contractObject->TurnoverGross.'' : ''));
        $this->setTurnoverNet((is_string($contractObject->TurnoverNet) ? ''.$contractObject->TurnoverNet.'' : ''));
        $this->setExternalSubscription((is_array($externalSubscription = $this->setExternalSubscriptionArray($contractObject->ExternalSubscription)) ? $externalSubscription : []));
        $this->setPrepaidCardsAmountRemaining((is_numeric($contractObject->PrepaidCardsAmountRemaining) ? $contractObject->PrepaidCardsAmountRemaining : 0));
        $this->setExternalId((is_string($contractObject->ExternalId) ? ''.$contractObject->ExternalId.'' : ''));
        $this->setSalesEntityId((is_string($contractObject->SalesEntityId) ? ''.$contractObject->SalesEntityId.'' : ''));
        $this->setDeletionRequestedAt((is_string($contractObject->DeletionRequestedAt) ? ''.$contractObject->DeletionRequestedAt.'' : ''));
        $this->setWriteOff((is_array($writeOff = $this->setWriteOffArray($contractObject->WriteOff)) ? $writeOff : []));
        $this->setStartDate((is_string($contractObject->StartDate) ? ''.$contractObject->StartDate.'' : ''));
        $this->setEndDate((is_string($contractObject->EndDate) ? ''.$contractObject->EndDate.'' : ''));
        $this->setBilledUntil((is_string($contractObject->BilledUntil) ? ''.$contractObject->BilledUntil.'' : ''));
        $this->setPlanVariantId((is_string($contractObject->PlanVariantId) ? ''.$contractObject->PlanVariantId.'' : ''));
        $this->setNotes((is_string($contractObject->Notes) ? ''.$contractObject->Notes.'' : ''));
        $this->setPaymentMethod((is_string($contractObject->PaymentMethod) ? ''.$contractObject->PaymentMethod.'' : ''));
        $this->setMandateReference((is_string($contractObject->MandateReference) ? ''.$contractObject->MandateReference.'' : ''));
        $this->setMandateSignatureDate((is_string($contractObject->MandateSignatureDate) ? ''.$contractObject->MandateSignatureDate.'' : ''));
        $this->setDestinationCountry((is_string($contractObject->DestinationCountry) ? ''.$contractObject->DestinationCountry.'' : ''));
        $this->setCustomFields((is_array($customFields = $this->setCustomFieldsArray($contractObject->CustomFields)) ? $customFields : []));
        $this->setOnAccountDueAfter((is_array($onAccountDueAfter = $this->setOnAccountDueAfterArray($contractObject->OnAccountDueAfter)) ? $onAccountDueAfter : []));
        $this->setComponents((is_array($components = $this->setComponentsArray($componentObject)) ? $components : []));
    }

    public function setPhaseArray($phases): array
    {
        $contractPhases = [];
        if(is_array($phases)) {
            foreach ($phases as $phase) {
                $contractPhase = new ContractPhases();
                $contractPhase->setType((is_string($phase->Type) ? ''.$phase->Type.'' : ''));
                $contractPhase->setStartDate((is_string($phase->StartDate) ? ''.$phase->StartDate.'' : ''));
                $contractPhase->setPlanVariantId((is_string($phase->PlanVariantId) ? ''.$phase->PlanVariantId.'' : ''));
                $contractPhase->setPlanId((is_string($phase->PlanId) ? ''.$phase->PlanId.'' : ''));
                $contractPhase->setQuantity((int)$phase->Quantity);
                $contractPhase->setInheritStartDate((bool)$phase->InheritStartDate);
                $contractPhases[] = $contractPhase;
            }
        } else {
            $contractPhase = new ContractPhases();
            $contractPhase->setType((is_string($phases->Type) ? ''.$phases->Type.'' : ''));
            $contractPhase->setStartDate((is_string($phases->StartDate) ? ''.$phases->StartDate.'' : ''));
            $contractPhase->setPlanVariantId((is_string($phases->PlanVariantId) ? ''.$phases->PlanVariantId.'' : ''));
            $contractPhase->setPlanId((is_string($phases->PlanId) ? ''.$phases->PlanId.'' : ''));
            $contractPhase->setQuantity((int)$phases->Quantity);
            $contractPhase->setInheritStartDate((bool)$phases->InheritStartDate);
            $contractPhases[] = $contractPhase;
        }
        return $contractPhases;
    }

    public function setComponentsArray($components): array
    {
        $contractComponents = [];
        if(is_array($components)) {
            foreach ($components as $component) {
                $contractComponent = new ContractComponent();
                $contractComponent->setId((is_string($component->Id) ? ''.$component->Id.'' : ''));
                $contractComponent->setContractId((is_string($component->ContractId) ? ''.$component->ContractId.'' : ''));
                $contractComponent->setCustomerId((is_string($component->CustomerId) ? ''.$component->CustomerId.'' : ''));
                $contractComponent->setComponentId((is_string($component->ComponentId) ? ''.$component->ComponentId.'' : ''));
                $contractComponent->setQuantity((int)$component->Quantity);
                $contractComponent->setStartDate((is_string($component->StartDate) ? ''.$component->StartDate.'' : ''));
                $contractComponent->setEndDate((is_string($component->EndDate) ? ''.$component->EndDate.'' : ''));
                $contractComponent->setBilledUntil((is_string($component->BilledUntil) ? ''.$component->BilledUntil.'' : ''));
                $contractComponent->setMemo((is_string($component->Memo) ? ''.$component->Memo.'' : ''));
                $componentMemo = explode(" ", $component->Memo);
                $contractComponent->setEmail((is_string($component->Memo) ? ''.$componentMemo[0].'' : ''));
                $contractComponents[] = $contractComponent;
            }
        } else {
            $contractComponent = new ContractComponent();
            $contractComponent->setId((is_string($components->Id) ? ''.$components->Id.'' : ''));
            $contractComponent->setContractId((is_string($components->ContractId) ? ''.$components->ContractId.'' : ''));
            $contractComponent->setCustomerId((is_string($components->CustomerId) ? ''.$components->CustomerId.'' : ''));
            $contractComponent->setComponentId((is_string($components->ComponentId) ? ''.$components->ComponentId.'' : ''));
            $contractComponent->setQuantity((int)$components->Quantity);
            $contractComponent->setStartDate((is_string($components->StartDate) ? ''.$components->StartDate.'' : ''));
            $contractComponent->setEndDate((is_string($components->EndDate) ? ''.$components->EndDate.'' : ''));
            $contractComponent->setBilledUntil((is_string($components->BilledUntil) ? ''.$components->BilledUntil.'' : ''));
            $contractComponent->setMemo((is_string($components->Memo) ? ''.$components->Memo.'' : ''));
            $componentMemo = explode(" ", $components->Memo);
            $contractComponent->setEmail((is_string($components->Memo) ? ''.$componentMemo[0].'' : ''));
            $contractComponents[] = $contractComponent;
        }
        return $contractComponents;
    }

    public function setPaymentBearerArray($fields): array
    {
        $paymentBearers = [];
        if(!empty($fields)) {
            $paymentBearer = new ContractPaymentBearer();
            $paymentBearer->setCardType((is_string($fields->CardType) ? ''.$fields->CardType.'' : ''));
            $paymentBearer->setHolder((is_string($fields->Holder) ? ''.$fields->Holder.'' : ''));
            $paymentBearer->setLast4((is_string($fields->Last4) ? ''.$fields->Last4.'' : ''));
            $paymentBearer->setType((is_string($fields->Type) ? ''.$fields->Type.'' : ''));
            $paymentBearer->setCountry((is_string($fields->Country) ? ''.$fields->Country.'' : ''));
            $paymentBearer->setExpiryMonth((is_numeric($fields->ExpiryMonth) ? $fields->ExpiryMonth : 0));
            $paymentBearer->setExpiryYear((is_numeric($fields->ExpiryYear) ? $fields->ExpiryYear : 0));
            $paymentBearers[] = $paymentBearer;
        }
        return $paymentBearers;
    }

    public function setCurrentDunningArray($fields): array
    {
        $currentDunnings = [];
        if(!empty($fields)) {
            $currentDunning = new ContractCurrentDunning();
            $currentDunning->setLevel((int)$fields->Level);
            $currentDunning->setAmount((is_numeric($fields->Amount) ? $fields->Amount : 0));
            $currentDunning->setRemaining((is_numeric($fields->Remaining) ? $fields->Remaining : 0));
            $currentDunning->setThreshold((is_numeric($fields->Threshold) ? $fields->Threshold : 0));
            $currentDunning->setDocumentId((is_string($fields->DocumentId) ? '' . $fields->DocumentId . '' : ''));
            $currentDunning->setTimestamp((is_string($fields->Timestamp) ? '' . $fields->Timestamp . '' : ''));
            $currentDunning->setIsAtrigaEscalated((bool)$fields->IsAtrigaEscalated);
            $currentDunning->setAtrigaStatus((is_string($fields->AtrigaStatus) ? '' . $fields->AtrigaStatus . '' : ''));
            $currentDunning->setAtrigaDunningLevel((int)$fields->AtrigaDunningLevel);
            $currentDunnings[] = $currentDunning;
        }
        return $currentDunnings;
    }

    public function setExternalSubscriptionArray($fields): array
    {
        $externalSubscriptions = [];
        if(!empty($fields)) {
            $externalSubscription = new ContractExternalSubscription();
            $externalSubscription->setId((is_string($fields->Id) ? '' . $fields->Id . '' : ''));
            $externalSubscription->setType((is_string($fields->Type) ? '' . $fields->Type . '' : ''));
            $externalSubscriptions[] = $externalSubscription;
        }
        return $externalSubscriptions;
    }

    public function setOnAccountDueAfterArray($fields): array
    {
        $onAccountDueAfters = [];
        if(!empty($fields)) {
            $onAccountDueAfter = new OnAccountDueAfter();
            $onAccountDueAfter->setQuantity((int)$fields->Quantity);
            $onAccountDueAfter->setUnit((is_string($fields->Unit) ? '' . $fields->Unit . '' : ''));
            $onAccountDueAfters[] = $onAccountDueAfter;
        }
        return $onAccountDueAfters;
    }

    public function setWriteOffArray($fields): array
    {
        $writeOffs = [];
        if(!empty($fields)) {
            $writeOff = new ContractWriteOff();
            $writeOff->setBookingDate((is_string($fields->BookingDate) ? '' . $fields->BookingDate . '' : ''));
            $writeOff->setWriteOffDateTime((is_string($fields->WriteOffDateTime) ? '' . $fields->WriteOffDateTime . '' : ''));
            $writeOff->setTotalGross((is_numeric($fields->TotalGross) ? $fields->TotalGross : 0));
            $writeOffs[] = $writeOff;
        }
        return $writeOffs;
    }

    public function setCustomFieldsArray($fields): array
    {
        $customFields = [];
        if(!empty($fields)) {
            $customField = new ContractCustomFields();
            $customField->setContractId((is_string($fields->ContractId) ? '' . $fields->ContractId . '' : ''));
            $customField->setCSEmailUser((is_string($fields->CSEmailUser) ? '' . $fields->CSEmailUser . '' : ''));
            $customField->setCSFirstName((is_string($fields->CSFirstName) ? '' . $fields->CSFirstName . '' : ''));
            $customField->setCSLastName((is_string($fields->CSLastName) ? '' . $fields->CSLastName . '' : ''));
            $customField->setCSServer((is_string($fields->CSServer) ? '' . $fields->CSServer . '' : ''));
            $customField->setCSServerStatus((is_string($fields->CSServerStatus) ? '' . $fields->CSServerStatus . '' : ''));
            $customField->setCustomerId((is_string($fields->CustomerId) ? '' . $fields->CustomerId . '' : ''));
            $customFields[] = $customField;
        }
        return $customFields;
    }

    public function saveToDB($contract, $input, $webhookParameter, $sandbox = '0') {
        $dbConfig = $contract->getConfig();
        $startDate = new DateTime($this->getStartDate());
        $startDateTimestamp = $startDate->getTimestamp();
        $lastBillingDate = new DateTime($this->getLastBillingDate());
        $lastBillingTimestamp = $lastBillingDate->getTimestamp();
        $nextBillingDate = new DateTime($this->getNextBillingDate());
        $nextBillingTimestamp = $nextBillingDate->getTimestamp();
        $currentPhaseType = $this->getCurrentPhase()[0]->getType();
        setWebhookLog($dbConfig['db_kpi_host'], $dbConfig['db_kpi_user'], $dbConfig['db_kpi_pwd'], $dbConfig['db_kpi_name'], $contract->getContractId(), $input['CustomerId'], $input['EntityId'], $input['OrderId'], $contract->getLifecycleStatus(), $input['Event'], $webhookParameter, $sandbox, $startDateTimestamp, $lastBillingTimestamp, $nextBillingTimestamp, $currentPhaseType);
    }

    function sendMail($mailSubject,$MailContent,$recipient,$cc = true) {
        $subject = $mailSubject;
        $mail = $this->getMail();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAutoTLS = false;
        $mail->Password = $this->getConfig()['SMTPPassword'];
        $mail->Username = $this->getConfig()['SMTPUsername'];
        $mail->SMTPDebug  = 0;
        $mail->Port = $this->getConfig()['SMTPPort'];
        $mail->Host = $this->getConfig()['SMTPHost'];
        $mail->CharSet = CURL_CHARSET;
        $mail->IsHTML(true);
        $mail->SetFrom($this->getConfig()['MAILFrom']);
        $mail->Subject  = $subject;
        $mail->Body     = $MailContent;
        if(isset($this->getConfig()['forceRecipientAddress'])){
            $mail->AddAddress($this->getConfig()['forceRecipientAddress']);
        }else{
            $mail->AddAddress($recipient);
        }
        if($cc) {
            if(isset($this->getConfig()['forceCCRecipientAddress'])){
                $mail->AddBCC($this->getConfig()['forceCCRecipientAddress']);
            }
            if(isset($this->getConfig()['forceCCRecipientAddress2'])){
                $mail->AddBCC($this->getConfig()['forceCCRecipientAddress2']);
            }
            if(isset($this->getConfig()['forceCCRecipientAddress3'])){
                $mail->AddBCC($this->getConfig()['forceCCRecipientAddress3']);
            }
        }
        if(!$mail->send()) {
            return 'Mailer error: ' . $mail->ErrorInfo.'HOST :' .$this->getConfig()['SMTPHost'].":".$mail->Port = $this->getConfig()['SMTPPort'];
        } else {
            return 'Message has been sent.';
        }
    }
}
