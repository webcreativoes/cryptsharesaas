<?php

/*
 * Load config, functions and clean inputs
 */
require_once('lib/init.php');

const COUNTRY = 'country';
const BW_CUSTOMER_ID_1 = 'bw_customer_id';

/*
 * sr_feuser_register saves ISO 3, but billwerk needs ISO 2, so we give them what they need dynamically here
 */
$fe_user_data[COUNTRY] = getIso2FromIso3($config, $fe_user_data['static_info_country']);

switch($action){
    case 'get_customer':
    case 'get_customer_contracts':
        $data = [
            'CustomerId' => $input['bw_CustomerId']
        ];
        $result = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $fe_user_data[BW_CUSTOMER_ID_1]);
        break;
    case 'create_customer':
        $data = array(
                    'FirstName' => $fe_user_data['first_name'],
                    'LastName' => $fe_user_data['last_name'],
                    'CompanyName' => $fe_user_data['company'],
                    'Address' => array( 'Street' => $fe_user_data['address'],
                                        'HouseNumber' => $fe_user_data['house_no'],
                                        'PostalCode' => $fe_user_data['zip'],
                                        'City' => $fe_user_data['city'],
                                        COUNTRY => $fe_user_data[COUNTRY],
                                        ),
                    'EmailAddress' => $fe_user_data['email'],
                    'PhoneNumber' => $fe_user_data['telephone'],
                    'DefaultBearerMedium' => 'Email',
                    'ExternalCustomerId' => $typo3_fe_user_id,
                    'Locale' => strtolower( $fe_user_data['language']),
                    'Hidden' => false,
                    'CustomFields' => array ('CSDpaAccepted' => 0)
                );
        $result = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], false);
        /*if($_SERVER['TYPO3_CONTEXT'] !== 'Development/Local') {
            submitFormOnHubspot($config, $data, 'signup', $_SERVER['HTTP_REFERER']);
        }*/
        if(isset($result->{'Id'})){
            $data[BW_CUSTOMER_ID_1] = $result->{'Id'};
            setCustomerIdOnFeUser($config, $typo3_fe_user_id, $result->{'Id'});
            die( json_encode( array('Result' => 1), true) );
        } else {
            setDieError('Error while creating your user in our database. '.$result->{'Message'}, __FILE__, __LINE__);
        }
        break;
    case 'update_customer':
        $data = array(
            'CustomerId' => $fe_user_data['bw_customer_id'],
            'FirstName' => $fe_user_data['first_name'],
            'LastName' => $fe_user_data['last_name'],
            'CompanyName' => $fe_user_data['company'],
            'Address' => array( 'Street' => $fe_user_data['address'],
                                'HouseNumber' => $fe_user_data['house_no'],
                                'PostalCode' => $fe_user_data['zip'],
                                'City' => $fe_user_data['city'],
                                COUNTRY => $fe_user_data[COUNTRY],
                        ),
            'EmailAddress' => $fe_user_data['email'],
            'VatId' => $fe_user_data['vat'],
            'PhoneNumber' => $fe_user_data['telephone'],
            'DefaultBearerMedium' => 'Email',
            'Hidden' => false,
            'Locale' => strtolower( $fe_user_data['language'] ),
            'CustomFields' =>   array (
                                    'CSDpaAccepted' => $fe_user_data['dpa_accepted'],
                                    'CSBusinessPartnerChangeAccepted'  => $fe_user_data['business_partner_change_accepted']
                                )
        );
        $result = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $fe_user_data[BW_CUSTOMER_ID_1]);
        break;
    case 'end_trial_on_feuser':
        echo setEndTrialOnFeUser($config, $typo3_fe_user_id);
        break;
    case 'first_order':
        $result = replaceUserGroupOnFeUser($config, $typo3_fe_user_id, 14, 16);
        die( json_encode( array('Result' => $result), true) );
        break;
    case 'save_business_partner_change_decision':
        if(!$input['decision']){ die('No decision transmitted');}

        $data = array(
            'CustomerId' => $fe_user_data['bw_customer_id'],
            'FirstName' => $fe_user_data['first_name'],
            'LastName' => $fe_user_data['last_name'],
            'CompanyName' => $fe_user_data['company'],
            'Address' => array( 'Street' => $fe_user_data['address'],
                'HouseNumber' => $fe_user_data['house_no'],
                'PostalCode' => $fe_user_data['zip'],
                'City' => $fe_user_data['city'],
                COUNTRY => $fe_user_data[COUNTRY],
            ),
            'EmailAddress' => $fe_user_data['email'],
            'VatId' => $fe_user_data['vat'],
            'PhoneNumber' => $fe_user_data['telephone'],
            'DefaultBearerMedium' => 'Email',
            'Hidden' => false,
            'Locale' => strtolower( $fe_user_data['language'] ),
            'CustomFields' =>   array (
                'CSDpaAccepted' => $fe_user_data['dpa_accepted'],
                'CSBusinessPartnerChangeAccepted'  => $input['decision']
            )
        );
        $result1 = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $fe_user_data[BW_CUSTOMER_ID_1]);

        $result2 = setBusinessPartnerChangeDecisionOnFeUser($config, $typo3_fe_user_id, $input['decision']);

        die( $result2 );
    case 'set_customer':
        $data = [
            'CustomerId' => $input['Id'],
            'FirstName' => $input['Firstname'],
            'LastName' => $input['Lastname'],
            'CompanyName' => $input['Company'],
            'Address' => [ 'Street' => $input['Street'],
                'HouseNumber' => $input['Housenumber'],
                'PostalCode' => $input['Zip'],
                'City' => $input['City'],
                'Country' => $input['Country'],
            ],
            'EmailAddress' => $input['Email'],
            'VatId' => $input['Vat'],
            'PhoneNumber' => $input['Phone'],
            'DefaultBearerMedium' => 'Email',
            'Hidden' => false
        ];
        $result = callRestAPI($config, $data, $action, $fe_user_data['bw_access_token'], $input['Id']);
        break;
    default:
        setDieError('Unknown action transmitted', __FILE__, __LINE__);
}
