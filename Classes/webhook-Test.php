<?php
if($_GET['token'] != '5f58d21e3af14d0df470ba845f58cda63af14d0df470ae1a5f58cc5e3af14d0df470aad6') {
    header('HTTP/1.0 401');
    die('permission denied');
} else {
    if ($_SERVER['SERVER_NAME'] == 'api.cryptshare.express') {
        $_SERVER['TYPO3_CONTEXT'] = 'Production';
        $rootPath = '/srv/www/virtual/cs-x-www.equinoxe.de/';
    } else {
        $_SERVER['TYPO3_CONTEXT'] = 'Development';
        $rootPath = '/srv/www/virtual/cs-x-dev.equinoxe.de/';
        $input['sandbox'] = 1;
    }
    $is_webhook = true;
    require_once('lib/config.php');
    require_once('lib/functions.php');
    require_once('webhook/webhook.php');
    require_once('lib/PHPMailer/src/PHPMailer.php');
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $headerText = "HTTP/1.0 200 OK";
    if ($input = json_decode(file_get_contents("php://input"), true)) {
        $webhookParameter = "<pre>" . print_r($input, true) . "</pre>";
        $contract = null;
        $customer = null;
        switch($input['Event']) {
            case 'ContractCreated':
            case 'ContractChanged':
            case 'ContractDataChanged':
            case 'ContractCancelled':
            case 'ContractDeleted':
            case 'RecurringBillingApproaching':
            case 'DebitAuthCancelled':
            case 'PaymentBearerExpired':
            case 'PaymentBearerExpiring':
            case 'PaymentDataChanged':
            case 'PaymentEscalated':
            case 'PaymentEscalationReset':
            case 'PaymentProcessStatusChanged':
            case 'PaymentRegistered':
            case 'DunningCreated':
            case 'InvoiceCreated':
            case 'InvoiceCorrected':
            case 'OrderSucceeded':
            case 'TrialEndApproaching':
            case 'ComponentCreated':
            case 'ComponentChanged':
            case 'ComponentDeleted':
            case 'AccountCreated':
                $contract = buildContract();
                $contract->setContractId($input['ContractId']);
                $contract->setCustomerId(($input['CustomerId'] !== '') ? ''.$input['CustomerId'].'' : 'webhook');
                if (isset($config)) {
                    $contract->setConfig($config);
                }
                $contract->setToken($contract->getConfig());
                //$contract->setMail($mail);
                $contract->setContract();
                break;
            case 'PaymentFailed':
                $contract = buildContract();
                $contract->setContractId($input['ContractId']);
                $contract->setCustomerId(($input['CustomerId'] !== '') ? ''.$input['CustomerId'].'' : 'webhook');
                $contract->setPaymentTransactionId(($input['PaymentTransactionId'] !== '') ? ''.$input['PaymentTransactionId'].'' : 'webhook');
                if (isset($config)) {
                    $contract->setConfig($config);
                }
                $contract->setToken($contract->getConfig());
                $contract->setContract();
                break;
            case 'CustomerCreated':
            case 'CustomerChanged':
            case 'CustomerDeleted':
            case 'CustomerLocked':
            case 'CustomerUnlocked':
                $customer = buildCustomer();
                $customer->setCustomerId($input['CustomerId']);
                if (isset($config)) {
                    $customer->setConfig($config);
                }
                $customer->setToken($customer->getConfig());
                break;
        }
        switch($input['Event']) {
            case 'ContractCreated':
                //bei erfolgreicher Vertragserzeugung
                $contract->contractCreated();
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('contractCreated() done!');
                break;
            case 'ContractChanged':
                //wenn ein Vertrag in eine neue Phase eintritt
                $contract->contractChanged();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('contractChanged() done!');
                break;
            case 'ContractDataChanged':
                //wenn Vertragsdaten modifiziert wurden (Zusatzfelder, External Id, etc.)
                $contract->contractDataChanged();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('contractDataChanged() done!');
                break;
            case 'ContractCancelled':
                //wenn eine Kündigung eingereicht wurde
                $contract->contractCancelled();
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('contractCancelled() done!');
                break;
            case 'ContractDeleted':
                //wenn ein Vertrag gelöscht wird
                $contract->contractDeleted();
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('contractDeleted() done!');
                break;
            case 'CustomerCreated':
                //wenn ein Kunde angelegt wurde
                $customer->customerCreated();
                $customer->saveToDB($customer, $input, $webhookParameter, $input['sandbox']);
                var_dump('customerCreated() done!');
                break;
            case 'CustomerChanged':
                //wenn Kundendaten geändert wurden
                $customer->customerChanged();
                $customer->saveToDB($customer, $input, $webhookParameter, $input['sandbox']);
                var_dump('customerChanged() done!');
                break;
            case 'CustomerDeleted':
                //wenn ein Kunde gelöscht wird
                $customer->customerDeleted();
                $customer->saveToDB($customer, $input, $webhookParameter, $input['sandbox']);
                var_dump('customerDeleted() done!');
                break;
            case 'DunningCreated':
                //wenn ein Mahnungs-Pdf erzeugt und verschickt wurde
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "DunningCreated",
                "DunningId" : "51d97067cb596a1239fff424"
                }
                 */
                //$contract->dunningCreated();
                //$webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                //$contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('dunningCreated() done!');
                break;
            case 'InvoiceCreated':
                //wenn ein Rechnungs-/Gutschriften-Pdf erzeugt und verschickt wurde
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "InvoiceCreated",
                "InvoiceId" : "51d97067cb596a1239fff423"
                }
                 */
                $contract->invoiceCreated();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('invoiceCreated() done!');
                break;
            case 'InvoiceCorrected':
                //wenn ein Rechnungs-/Gutschriften-Pdf geändert wurde
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "InvoiceCorrected",
                "OldInvoiceId" : "51d97067cb596a1239fff423", //Deprecated. Do not use this anymore
                "NewInvoiceId" : "51d97067cb596a1239fff424", //Deprecated. Do not use this anymore
                "OldInvoiceDraftId" : "51d97067cb596a1239fff423",
                "NewInvoiceDraftId" : "51d97067cb596a1239fff424"
                }
                 */
                $contract->invoiceCorrected();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('invoiceCorrected() done!');
                break;
            case 'OrderSucceeded':
                //wenn eine Bestellung erfolgreich abgeschlossen wurde
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "OrderSucceeded",
                "ContractId" : "51d970c8eb596a1168df119a",
                "OrderId":"5da4429dd41dae0e9c037728"
                }
                 */
                $contract->orderSucceeded();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('orderSucceeded() done!');
                break;
            case 'RecurringBillingApproaching':
                //wenn ein Vertrag die nächste Abrechnungsperiode erreicht und die Abrechnungsverzögerung läuft. Verwendbar als Trigger zum Übertragen von Nutzungsdaten
                $contract->recurringBillingApproaching();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('recurringBillingApproaching() done!');
                break;
            case 'TrialEndApproaching':
                //wenn die Trialphase eines Vertrages demnächst endet. Zeitpunkt kann in Paket definiert werden.
                $contract->trialEndApproaching();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('trialEndApproaching() done!');
                break;
            case 'AccountCreated':
                //Veraltet! Bitte ContractCreated verwenden
                $contract->accountCreated();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('trialEndApproaching() done!');
                break;
            case 'CustomerLocked':
                //wenn der Kunde gesperrt wurde
                $customer->customerLocked();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$customer, true) . "</pre>";
                $customer->saveToDB($customer, $input, $webhookParameter, $input['sandbox']);
                var_dump('customerLocked() done!');
                break;
            case 'CustomerUnlocked':
                //wenn der Kunde entsperrt wurde
                $customer->customerUnlocked();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$customer, true) . "</pre>";
                $customer->saveToDB($customer, $input, $webhookParameter, $input['sandbox']);
                var_dump('customerUnlocked() done!');
                break;
            case 'DebitAuthCancelled':
                //wenn ein Kunde die Einzugsermächtigung zurückzieht
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "DebitAuthCancelled",
                "ContractId" : "51d970c8eb596a1168df119a",
                "CustomerId" : "51d140d8fc787ac88a4afc4a",
                "YourCustomerId" : "23213",
                "PaymentProvider" : "PayPal",
                }
                 */
                $contract->debitAuthCancelled();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('debitAuthCancelled() done!');
                break;
            case 'PaymentBearerExpired':
                //ausgelöst, wenn ein Zahlungsmedium abgelaufen ist
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "PaymentBearerExpired",
                "ContractId" : "51d970c8eb596a1168df119a",
                "ExpiryDate" : "2013-12-22T11:11:11Z"
                }
                 */
                $contract->paymentBearerExpired();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('paymentBearerExpired() done!');
                break;
            case 'PaymentBearerExpiring':
                //wenn ein Zahlungsmedium nur noch einen Monat gültig ist
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "PaymentBearerExpiring",
                "ContractId" : "51d970c8eb596a1168df119a",
                "ExpiryDate" : "2013-12-22T11:11:11Z"
                }
                 */
                $contract->paymentBearerExpiring();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('paymentBearerExpiring() done!');
                break;
            case 'PaymentDataChanged':
                //wenn Zahlungsdaten für existierende Verträge geändert wurden
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "PaymentDataChanged",
                "ContractId" : "51d970c8eb596a1168df119a"
                }
                 */
                $contract->paymentDataChanged();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('paymentDataChanged() done!');
                break;
            case 'PaymentEscalated':
                //bei erfüllter Bedingung eines Zahlungseskalationsschrittes mit Aktion "Webhook auslösen"
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "PaymentEscalated",
                "ContractId" : "51d970c8eb596a1168df119a",
                "CustomerId" : "51d140d8fc787ac88a4afc4a",
                "YourCustomerId" : "23213",
                "TriggerDays" : 6,
                "DueDate" : "2012-11-15T19:28:34Z",
                "PaymentProvider" : "PayPal",
                "PaymentEscalationProcessId" : "50c257d8fc923ac88a49fdc0"
                }
                 */
                $contract->paymentEscalated();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('paymentEscalated() done!');
                break;
            case 'PaymentEscalationReset':
                //wenn die Zahlungseskalation für einen Vertrag zurückgesetzt wurde, z.B. durch Zahlung eines Kunden
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "PaymentEscalationReset",
                "ContractId" : "51d970c8eb596a1168df119a",
                "CustomerId" : "51d140d8fc787ac88a4afc4a"
                }
                 */
                $contract->paymentEscalationReset();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('paymentEscalationReset() done!');
                break;
            case 'PaymentFailed':
                //bei Zahlungsfehlern
                $today = new DateTime(date());
                $mailContent = 'Die Zahlung '.$this->getPaymentTransactionId().' am '.$today.' ist fehlgeschlagen.';
                sendMail('CSX PaymentFailed - Test Mail ', $mailContent, 'lutz.eckelmann@pointsharp.de', false);
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "PaymentFailed",
                "PaymentTransactionId" : "51d970c8eb596a1168df119a"
                }
                 */
                break;
            case 'PaymentProcessStatusChanged':
                //wird erzeugt, wenn Zahlungsprozess eines Vertrages gestartet / gestoppt wurde
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "PaymentProcessStatusChanged",
                "ContractId" : "51d970f8cb596a2269df14ab"
                }
                 */
                $contract->paymentProcessStatusChanged();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('paymentProcessStatusChanged() done!');
                break;
            case 'PaymentRegistered':
                //bei manuell registrierten Zahlungen
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "PaymentRegistered",
                "ContractId" : "51d970f8cb596a2269df14ab"
                }
                 */
                $contract->paymentRegistered();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('paymentRegistered() done!');
                break;
            case 'PaymentSucceeded':
                //bei erfolgreicher Zahlung
                /**
                HTTP/1.1
                POST /billwerk-hook
                Host: example.com
                Content-Type: application/json

                {
                "Event" : "PaymentSucceeded",
                "PaymentTransactionId" : "51d970c8eb596a1168df119a"
                }
                 */
                break;
            case 'PlanCreated':
                //Beim Erstellen eines Pakets
                break;
            case 'PlanChanged':
                //Bei Änderungen eines Pakets
                break;
            case 'PlanDeleted':
                //Beim Löschen eines Pakets
                break;
            case 'PlanVariantCreated':
                //Beim Erstellen einer Paketvariante
                break;
            case 'PlanVariantChanged':
                //Bei Änderungen einer Paketvariante
                break;
            case 'PlanVariantDeleted':
                //Beim Löschen einer Paketvariante
                break;
            case 'ComponentCreated':
                //Beim Erstellen einer Komponente
                $contract->componentCreated();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('componentCreated() done!');
                break;
            case 'ComponentChanged':
                //bei Änderungen einer Komponente
                $contract->componentChanged();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('componentChanged() done!');
                break;
            case 'ComponentDeleted':
                //Beim Löschen einer Komponente
                $contract->componentDeleted();
                $webhookParameter = $webhookParameter."<pre>" . print_r((array)$contract, true) . "</pre>";
                $contract->saveToDB($contract, $input, $webhookParameter, $input['sandbox']);
                var_dump('componentDeleted() done!');
                break;
            case 'ReportSucceeded':
                //bei erfolgreicher Report-Generierung
                break;
            case 'ReportFailed':
                //bei fehlgeschlagener Report-Generierung
                break;
            case 'AccountingExportFileCreated':
                //bei erfolgreicher Generierung von FiBu-Export-Datei
                break;
            case 'PaymentsExportFileCreated':
                //bei erfolgreicher Erstellung der Zahlungsexportdatei
                break;
        }
    }
}

function buildContract(): Contract
{
    return new Contract();
}

function buildCustomer(): Customer
{
    return new Customer();
}

function saveLogToDB($dbConfig, $id, $input, $webhookParameter) {
    setWebhookLog($dbConfig['db_kpi_host'], $dbConfig['db_kpi_user'], $dbConfig['db_kpi_pwd'], $dbConfig['db_kpi_name'], $id, '', $input['CustomerId'], $input['EntityId'], $input['OrderId'], $input['Event'], $webhookParameter);
}

header($headerText);
