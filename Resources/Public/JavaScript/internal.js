// internal 2.3.0

const VALUE_PHP_SCRIPT_CUSTOMERS = '/typo3conf/ext/cryptsharesaas/Classes/customers.php';
const VALUE_PHP_SCRIPT_ORDERS = '/typo3conf/ext/cryptsharesaas/Classes/orders.php';
const VALUE_PHP_SCRIPT_COMPONENTS = '/typo3conf/ext/cryptsharesaas/Classes/components.php';
const VALUE_PHP_SCRIPT_CONTACTS = '/typo3conf/ext/cryptsharesaas/Classes/contracts.php';
const VALUE_PHP_SCRIPT_CRYPTSHAREAPI = '/typo3conf/ext/cryptsharesaas/Classes/cryptshareapi.php';
const VALUE_MIMETYPE_TEXT = 'text/plain; charset=UTF-8';
const VALUE_AJAX_ERROR = 'AJAX ERROR';
const KEY_CS_FIRSTNAME = '#cs_first_name';
const KEY_CS_LASTNAME = '#cs_last_name';
const ID_CURRENT_EMAIL = '#currentEmail';
const ID_CS_EMAIL_COLLECTIVE_STATUS = '#cs_email_collective_status';
const ID_COLLECTIVE_MAILBOX = '#collectiveMailboxContainer, #CollectiveMailboxHint, #CollectiveMailboxCheckbox';
const ID_USER_DATA_FIELDS = '#user-data-fields';
const ID_COLLECTIVE_MAILBOX_ACKNOWLEDGED = '#collective_mailboxes_acknowledged';
const ID_INPUT_CS_MAIL = 'input.cs_email';
const ID_COUPONCODE = '#couponcode';
const ID_FIRSTNAME = '#first_name';
const ID_LASTNAME = '#last_name';
const ID_CONTRACT_ID = '#contractId';
const ID_EMAILLIST_LISTITEM = '#emailList > li';
const ID_CARD_SUMMARY = '.card.summary';
const ID_CARD_PAYMENT_HINT = '.card.paymenthint';
const ID_CARD_DECK_WHATYOUGET = '.card-deck.whatyouget';
const ID_APPLY_VOUCHER = '#applyvoucher';
const ID_FINAL_ORDER_STEPS = '.final-order-steps';
const ID_HTML_BODY = 'html, body';
const ID_CARD_PAYMENT = '.card.payment';
const ID_PAY1_PAY2 = '#pay1, #pay2';
const ID_TARGET_URL = '#targeturl';
const ID_COMPONENT_EMAIL = '#componentEmail';
const ID_COMPONENT_NAME = '#componentName';
const ID_EDIT_BUTTON = '#editButton';
const ID_PLAN_VARIANT = '.plan-variant';
const ID_CARD_ADD_ACCOUNT = '.card.add-account';
const ID_INPUT_PLANVARIANT_ID = '.custom-control-input#planvariantid-';
const ID_ORDERED_EMAILS = "#orderedEmails";
const ID_AVAILABLE_EMAILS = '#availableEmails';
const ID_LEFT_EMAILS = '#leftemails';
const ID_ADDITIONAL_USER_HINT = '#additionaluserhint';
const ID_DATA_PLAN_VARIANT_ID = '.plan-variant[data-plan-variant-id="';
const ID_SRFEUSERREGISTER_VAT = '#tx-srfeuserregister-pi1-vat';
const ID_EMAIL_ITEM = "#emailItem";
const ID_INPUT_FIRSTNAME = "input.cs_first_name";
const ID_INPUT_LASTNAME = "input.cs_last_name";
const ID_ADD_EMAILS = "#addedEmails";
const ID_ALREADY_CHANGED = '#alreadyChanged';
const ID_COMPONENT_EMAIL_INPUT = '#componentEmailInput';
const ID_COMPONENT_ID = '#componentId';
const ATTR_DATA_BW_ORDER_ID = 'data-bworderid';
const ATTR_DATA_BW_CONTRACT_ID = 'data-bwcontractid';
const ATTR_DATA_BW_VARIANT_ID = 'data-bwplanvariantid';
const ATTR_DATA_ORDER_TOTAL_GROSS = 'data-ordertotalgross';
const ATTR_DATA_BW_ENVIRONMENT = 'data-bwenvironment';
const ATTR_DATA_PAYMENT_METHOD = 'data-paymentmethod';
const VALUE_AJAX_NO_ARRAY = 'AJAX SUCCESS but NO array';
const STRING_MSG_AJAX_SUCCESS = 'AJAX SUCCESS but Message : ';
const STRING_URL_PARAM_CONTRACT_ID = '?contractId=';
const STRING_CREDITCARD_FAKE_PSP = "CreditCard:FakePSP";
const STRING_CREDITCARD_PAYONE = "CreditCard:PayOne";
const STRING_DEBIT_FAKE_PSP = "Debit:FakePSP";
const STRING_DEBIT_PAYONE = "Debit:PayOne";
const STRING_ADYEN_IDEAL = "iDEAL:Adyen";
const PATH_TRACKING_CHECKOUT_ERROR_4 = '/checkout-4-error';

let emailList = [0];
let localLangInt = TYPO3.lang;

function maskCharacter(str, mask, n = 1) {
    return ('' + str).slice(0, -n).replace(/./g, mask) + ('' + str).slice(-n);
}

function removeHighlighting(highlightedElements){
    highlightedElements.each(function(){
        var element = $(this);
        element.replaceWith(element.html());
    })
}

function addHighlighting(element, textToHighlight){
    var text = element.text();
    var highlightedText = '<em>' + textToHighlight + '</em>';
    var newText = text.replace(textToHighlight, highlightedText);

    element.html(newText);
}

$("#fulltextsearch").on("keyup", function() {
    var value = this.value.toLowerCase().trim();

    if(!value) {
        $('#UserCards').find(".user-contract").each(function () {
            $(this).attr("data-search", '0');
            $(this).attr("data-subsearch", '0');
            $(this).removeClass('d-none');
        });
    } else {
        $(".user-contract").each(function (index) {
            var dataCustomer = $(this).data("customer").toLowerCase().trim();
            var customer_not_found = (dataCustomer.indexOf(value) == -1);
            if (!customer_not_found) {
                $(this).attr("data-search", 1);
            } else {
                $(this).attr("data-search", 0);
            }
            $(this).attr("data-subsearch", 0);
        }).promise().done( function(){
            $(".user-contract table tr").each(function (index) {
                $(this).find("td.enabled-search").each(function () {
                    var dataUser = $(this).text().toLowerCase().trim();
                    var not_found = (dataUser.indexOf(value) == -1);
                    if(!not_found) {
                        $(this).parent( "tr" ).attr("data-search", 1);
                        $( this ).parent().parent().parent().parent().parent().attr("data-subsearch", 1);
                    } else {
                        $(this).parent( "tr" ).attr("data-search", 0);
                    }
                });
            }).promise().done( function(){
                var numSearch = 0;
                var numSubsearch = 0;
                $(".user-contract").each(function (index) {
                    numSearch = $(this).attr('data-search');
                    numSubsearch = $(this).attr('data-subsearch');
                    $(this).removeClass('d-none');
                    if(numSearch == 0 && numSubsearch == 0) {
                        $(this).addClass('d-none');
                    }
                });
            });
        });
    }
});

/**
 * firstOrder
 *
 * Triggers the first_order action in the customers.php to change the users usertype in the frontend
 *
 * @returns void
 */
function firstOrder() {
	var action = 'first_order';
	$.ajax({
		url: VALUE_PHP_SCRIPT_CUSTOMERS,
		beforeSend: function(xhr) {
			xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
		},
		type: 'get',
		data: {
			action: action
		},
		dataType: 'json',
		success: function(response) {
			if (typeof response !== 'object') {
				console.info(VALUE_AJAX_NO_ARRAY + ' => for firstOder');
			}
		},
		error: function(xhr) {
			logAjaxError(VALUE_AJAX_ERROR, 'first_order', 'get json', xhr);
			handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
		}
	});
}


/**
 * saveBusinessPartnerChangeDecision
 *
 * Triggers the save_business_partner_change_decision action in the customers.php to change the users decision in the frontend
 *
 * @returns void
 */
function saveBusinessPartnerChangeDecision(decision) {
	var action = 'save_business_partner_change_decision';
	$.ajax({
		url: VALUE_PHP_SCRIPT_CUSTOMERS,
		beforeSend: function(xhr) {
			xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
		},
		type: 'get',
		data: {
			action: action,
			decision: decision
		},
		dataType: 'json',
		success: function(response) {
			if (response && response['Result'] === 1) {
				handleFlashMessage('success', 'Ihre Entscheidung wurde gespeichert. Sie werden nicht erneut gefragt.', false);
			}
		},
		error: function(xhr) {
			logAjaxError(VALUE_AJAX_ERROR, 'first_order', 'get json', xhr);
			handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
		}
	});
}

/**
 * checkIfEmailAddressIsCollectiveMailbox
 *
 * checks if the entered Email on the order-page is a collective Mailbox or not based on the CSV-file "collectivemailbox.csv"
 * Shows or hides the CollectiveMailboxHint if necessary
 *
 * @returns void
 */
function checkIfEmailAddressIsCollectiveMailbox() {
    var action = 'get_collectivemailbox_status';
    var cs_email = $(ID_CURRENT_EMAIL).val();
    $.ajax({
        url: VALUE_PHP_SCRIPT_ORDERS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            cs_email: cs_email
        },
        dataType: 'json',
        success: function(response) {
            if (typeof response !== 'object') {
                console.info(VALUE_AJAX_NO_ARRAY + ' => for checkIfEmailAddressIsCollectiveMailbox');
            }
            if (response && response['Result'] === 1) {
                $('#cs_email_collective').text(cs_email.substring(0, cs_email.lastIndexOf("@") + 1));
                $(ID_CS_EMAIL_COLLECTIVE_STATUS).val(1);
                $('#cs_email').addClass('error');

                $(ID_COLLECTIVE_MAILBOX).removeClass('d-none');
                $(ID_USER_DATA_FIELDS).addClass('d-none');
                $('#addbtn').addClass("disabled");
                $('#buy').prop("disabled",true);
                $(ID_COLLECTIVE_MAILBOX_ACKNOWLEDGED).prop('required', true);
            } else {
                $(ID_COLLECTIVE_MAILBOX).addClass('d-none');
                $(ID_USER_DATA_FIELDS).removeClass('d-none');
                $('#addbtn').removeClass("disabled");
                $('#buy').prop("disabled",false);
                $(ID_CS_EMAIL_COLLECTIVE_STATUS).val(0);
                $('#cs_email').removeClass('error');
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'checkIfEmailAddressIsCollectiveMailbox', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

/**
 * scrollToFirstErrorField
 *
 * scrolls to the first error that occured in the form so that the user immediately sees which inputs did not validate
 *
 * @returns void
 */
function scrollToFirstErrorField() {
    $('html,body').animate({
        scrollTop: $('.error').first().offset().top
    }, 1000, '');
    $(".error").first().focus();
}

function hasErrors(errors) {
    if (company.length < 2) {
        ++errors;
        $('#company').addClass('error');
    }
    if (address.length < 2) {
        ++errors;
        $('#address').addClass('error');
    }
    if (house_no.length < 1) {
        ++errors;
        $('#house_no').addClass('error');
    }
    if (zip.length < 2) {
        ++errors;
        $('#zip').addClass('error');
    }
    if (city.length < 2) {
        ++errors;
        $('#city').addClass('error');
    }
    return errors;
}

function getCountOfOrderMails() {
    var orderMails = 0;
    $(ID_INPUT_CS_MAIL).each(function() {
        if( $(this).val().length > 0 ) {
            orderMails++;
        }
    });
    return orderMails;
}

/**
 * createOrderPreview
 *
 * validates order-input and sends Ajax-Request to receive the Preview of the Order that will be shown after selecting the pricing-plan
 *
 * @param {*} sys_language_uid
 * @param {*} bw_customer_id
 *
 * @returns void
 */
function createOrderPreview(sys_language_uid, bw_customer_id) {
    checkIfEmailAddressIsCollectiveMailbox();
    $('input, select, label').removeClass('error');
    var errors = 0;
    var action = 'get_order_preview';
    var bw_planvariant_id = $('input[name="planvariant"]:checked').val();
    var cs_first_name = $(KEY_CS_FIRSTNAME).val();
    var cs_last_name = $(KEY_CS_LASTNAME).val();
    var cs_email = $('#cs_email').val();
    var orderMails = getCountOfOrderMails();
    var bw_couponcode = $(ID_COUPONCODE).val();
    var first_name = $(ID_FIRSTNAME).val();
    var last_name = $(ID_LASTNAME).val();
    var company = $('#company').val();
    var address = $('#address').val();
    var house_no = $('#house_no').val();
    var zip = $('#zip').val();
    var city = $('#city').val();
    var email = $('#email').val();
    var vat = $('#vat').val();
    errors = hasErrors(errors);
    if (errors === 0) {
        $.ajax({
            url: VALUE_PHP_SCRIPT_ORDERS,
            beforeSend: function(xhr) {
                xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            },
            type: 'get',
            data: {
                action: action,
                bw_PlanVariantId: bw_planvariant_id,
                bw_CouponCode: bw_couponcode,
                cs_first_name: cs_first_name,
                cs_last_name: cs_last_name,
                cs_email: cs_email,
                first_name: first_name,
                last_name: last_name,
                company: company,
                address: address,
                house_no: house_no,
                zip: zip,
                city: city,
                email: email,
                vat: vat
            },
            dataType: 'json',
            success: function(response) {
                if (typeof response !== 'object') {
                    console.info(VALUE_AJAX_NO_ARRAY + ' => for createOrderPreview');
                }
                if(response['Order'] !== undefined && response['Order']['NextTotalGrossDate'] !== undefined) {
                    $('#trialEndDate').val(response['Order']['NextTotalGrossDate']);
                }
                updateSummaryValues(response['Order'], 'order-preview', orderMails);
                createOrderSuccessfulView(response);
            },
            error: function(xhr) {
                logAjaxError(VALUE_AJAX_ERROR, 'get_order_preview', 'get json', xhr);
                handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
            }
        });
    } else {
        scrollToFirstErrorField();
    }
}

function setCustomer(customer) {
    var action = 'set_customer';
    $.ajax({
        url: VALUE_PHP_SCRIPT_CUSTOMERS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            $('#loader').removeClass('hidden');
        },
        type: 'get',
        data: {
            action: action,
            Id: customer.Id,
            Firstname: customer.Firstname,
            Lastname: customer.Lastname,
            Company: customer.Company,
            Street: customer.Street,
            Housenumber: customer.Housenumber,
            Zip: customer.Zip,
            City: customer.City,
            Country: customer.Country,
            Phone: customer.Phone,
            Email: customer.Email,
            Vat: customer.Vat
        },
        dataType: 'json',
        success: function(response) {
            getCustomer(customer.Id);
            $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                $("#success-alert").slideUp(500);
            });
        },
        complete: function () {
            $('#loader').addClass('hidden');
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'set_customer', 'set json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function getCustomer(id) {
    var action = 'get_customer';
    $.ajax({
        url: VALUE_PHP_SCRIPT_CUSTOMERS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            $('#loader').removeClass('hidden');
        },
        type: 'get',
        data: {
            action: action,
            bw_CustomerId: id
        },
        dataType: 'json',
        success: function(response) {
            $("#partnerFirstName").text((response['FirstName']) ? response['FirstName'] : '');
            $("#partnerLastName").text((response['LastName']) ? response['LastName'] : '');
            $("#partnerCompany").text(response['CompanyName'] ? response['CompanyName'] : '');
            $("#partnerStreet").text((response['Address']['Street']) ? response['Address']['Street'] : '');
            $("#partnerHouseNumber").text((response['Address']['HouseNumber']) ? response['Address']['HouseNumber'] : '');
            $("#partnerZip").text((response['Address']['PostalCode']) ? response['Address']['PostalCode'] : '');
            $("#partnerCity").text((response['Address']['City']) ? response['Address']['City'] : '');
            $("#partnerCountry").text(response['Address']['Country'] ? response['Address']['Country'] : '');
            $("#partnerPhone").text(response['PhoneNumber'] ? response['PhoneNumber'] : '');
            $("#partnerEmail").text(response['EmailAddress'] ? response['EmailAddress'] : '');
            $("#partnerVat").text(response['VatId'] ? response['VatId'] : '');
            $("#inputPartnerId").val(id);
            $("#inputPartnerFirstName").val((response['FirstName']) ? response['FirstName'] : '');
            $("#inputPartnerLastName").val((response['LastName']) ? response['LastName'] : '');
            $("#inputPartnerCompany").val(response['CompanyName'] ? response['CompanyName'] : '');
            $("#inputPartnerStreet").val((response['Address']['Street']) ? response['Address']['Street'] : '');
            $("#inputPartnerHouseNumber").val((response['Address']['HouseNumber']) ? response['Address']['HouseNumber'] : '');
            $("#inputPartnerZip").val((response['Address']['PostalCode']) ? response['Address']['PostalCode'] : '');
            $("#inputPartnerCity").val((response['Address']['City']) ? response['Address']['City'] : '');
            $("#inputPartnerCountry").val(response['Address']['Country'] ? response['Address']['Country'] : '');
            $("#inputPartnerPhone").val(response['PhoneNumber'] ? response['PhoneNumber'] : '');
            $("#inputPartnerEmail").val(response['EmailAddress'] ? response['EmailAddress'] : '');
            $("#inputPartnerVat").val(response['VatId'] ? response['VatId'] : '');
        },
        complete: function () {
            var loaders = $('#loaders').val();
            loaders--;
            if(loaders == '0') {
                $('#loader').addClass('hidden');
                $('#loaders').val('0');
            } else {
                $('#loaders').val(loaders);
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_customer', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function createOrderSuccessfulView(response) {
    var bw_contract_id = $(ID_CONTRACT_ID).val();
    if($(ID_EMAILLIST_LISTITEM).length > 0) {
        $(ID_CARD_SUMMARY).removeClass('d-none');
        if(bw_contract_id !== "") {
            $(ID_CARD_PAYMENT_HINT).removeClass('d-none');
        }
        $(ID_CARD_DECK_WHATYOUGET).addClass('d-none');
    }
    if (typeof response['Order']['Coupon'] === 'undefined' || response['Order']['Coupon'] === null) {
        console.info('AJAX SUCCESS but no Order Coupon');
    } else {
        if (typeof response['Order']['Coupon']['ErrorCode'] === 'undefined' || response['Order']['Coupon']['ErrorCode'] === null) {
            $(ID_APPLY_VOUCHER).removeClass('btn-secondary');
            $(ID_APPLY_VOUCHER).addClass('btn-success');
            $('#applyvoucher i').removeClass('d-none');
            $('#applyvoucher magick').addClass('d-none');
            $(ID_COUPONCODE).removeClass('form-control-danger');
            $(ID_COUPONCODE).addClass('form-control-success');
        } else {
            $(ID_APPLY_VOUCHER).addClass('btn-secondary');
            $(ID_APPLY_VOUCHER).removeClass('btn-success');
            $('#applyvoucher i').addClass('d-none');
            $('#applyvoucher magick').removeClass('d-none');
            $(ID_COUPONCODE).removeClass('form-control-success');
            $(ID_COUPONCODE).addClass('form-control-danger');
            logAjaxError('AJAX SUCCESS but no Order Coupon Errorcode:' + response['Order']['Coupon']['ErrorCode'], 'get_order_preview', 'get json');
            handleFlashMessage('danger', localLangInt['javaScriptPrefix' + response['Order']['Coupon']['ErrorCode']], false);
        }
    }
    if (typeof response['Message'] === 'undefined' || response['Message'] === null) {
        removeFlashMessages();
    } else {
        logAjaxError('AJAX SUCCESS but Message:'.response['Message'], 'get_order_preview', 'get json');
        handleFlashMessage('danger', response['Message'], false);
    }
}

/**
 * Creates Order
 *
 *  * Last Change 2019-05-15(Linecommented Vatcheck to reduce errors)
 * @param sys_language_uid
 * @param bw_customer_id
 */
function createOrder(sys_language_uid, bw_customer_id, paymentMethods) {
    $('#buy').on('click', function(e) {
        e.preventDefault();
        var orders = [],
            i = 0;
        $(".added input.cs_first_name").each(function() {
            var item = {};
            item[this.name] = this.value;
            orders.push(item);
        });
        i = 0;
        $(".added input.cs_last_name").each(function() {
            orders[i][this.name] = this.value;
            i++;
        });
        i = 0;
        $(".added input.cs_email").each(function() {
            orders[i][this.name] = this.value;
            i++;
        });
        createSuborder(orders, sys_language_uid, bw_customer_id, paymentMethods);
    });
}

function hasRegisterErrors(orders) {
    var errors = 0;
    var cs_first_name = orders[0]['cs_first_name'];
    var cs_last_name = orders[0]['cs_last_name'];
    var cs_email = orders[0]['cs_email'];
    var first_name = $(ID_FIRSTNAME).val();
    var last_name = $(ID_LASTNAME).val();
    var email = $('#email').val();
    var company = $('#company').val();
    var address = $('#address').val();
    var house_no = $('#house_no').val();
    var zip = $('#zip').val();
    var city = $('#city').val();
    var GeneralTermsAndConditions = $('#gtac').prop('checked');
    var cs_email_collective_status = $(ID_CS_EMAIL_COLLECTIVE_STATUS).val();
    var collective_mailboxes_acknowledged = $(ID_COLLECTIVE_MAILBOX_ACKNOWLEDGED).prop('checked');
    if (cs_first_name.length < 2) {
        ++errors;
        $(KEY_CS_FIRSTNAME).addClass('error');
    }
    if (cs_last_name.length < 2) {
        ++errors;
        $(KEY_CS_LASTNAME).addClass('error');
    }
    if (!isEmail(cs_email)) {
        ++errors;
        $('#cs_email').addClass('error');
    }
    if (first_name.length < 2) {
        ++errors;
        $(ID_FIRSTNAME).addClass('error');
    }
    if (last_name.length < 2) {
        ++errors;
        $(ID_LASTNAME).addClass('error');
    }
    if (!isEmail(email)) {
        ++errors;
        $('#email').addClass('error');
    }
    if (company.length < 2) {
        ++errors;
        $('#company').addClass('error');
    }
    if (address.length < 2) {
        ++errors;
        $('#address').addClass('error');
    }
    if (house_no.length < 1) {
        ++errors;
        $('#house_no').addClass('error');
    }
    if (zip.length < 2) {
        ++errors;
        $('#zip').addClass('error');
    }
    if (city.length < 2) {
        ++errors;
        $('#city').addClass('error');
    }
    if (!GeneralTermsAndConditions) {
        ++errors;
        $('label[for="gtac"]').addClass('error');
    }
    if (cs_email_collective_status === '1' && !collective_mailboxes_acknowledged) {
        ++errors;
        $('label[for="collective_mailboxes_acknowledged"]').addClass('error');
    }
    return errors;
}

function createSuborderSuccessfulView(response, sys_language_uid, paymentMethods, orders, company) {
    var bw_customer_id = $('body').data('bwcustomerid');
    var type = false;
    if (typeof response !== 'object') {
        console.info(VALUE_AJAX_NO_ARRAY + ' => for createSuborderSuccessfulView');
    }
    if (typeof response['Message'] === 'undefined' || response['Message'] === null) {
        if(typeof response['Contract'] !== 'undefined'){
            if(typeof response['Contract']['PaymentBearer'] !== 'undefined') {
                if(typeof response['Contract']['PaymentBearer']['Type'] !== 'undefined'){
                    type = true;
                }
            }
        }
        if ((response['TotalGross'] === 0 && response['AllowWithoutPaymentData'] === true && response['Contract']['CurrentPhase']['Type'] !== 'Trial') || type)
        {
            $(ID_FINAL_ORDER_STEPS).removeClass('d-none');
            $(ID_HTML_BODY).animate({
                scrollTop: $(ID_FINAL_ORDER_STEPS).offset().top
            }, 800);
            commitOrder(sys_language_uid, response['Id'], response['Contract']['Id'], bw_customer_id, orders);
        } else {
            $(ID_CARD_PAYMENT).removeClass('d-none');
            $('body').attr(ATTR_DATA_BW_ORDER_ID, response['Id']);
            $('body').attr(ATTR_DATA_BW_CONTRACT_ID, response['Contract']['Id']);
            $('body').attr(ATTR_DATA_BW_VARIANT_ID, response['PlanVariantId']);
            $('body').attr(ATTR_DATA_ORDER_TOTAL_GROSS, response['TotalGross']);
            createPaymentIframe(sys_language_uid, response['Id'], response['Contract']['Id'], response['PlanVariantId'], response['TotalGross'], paymentMethods, orders);
            $('.card.user-data input, .card-deck.plan-variant input, .card.billing-data input, .card.billing-data select').prop('disabled', true);
            $('.loader, #buy, .billing-data .card-footer').remove();
            $(ID_HTML_BODY).animate({
                scrollTop: $(ID_CARD_PAYMENT).offset().top
            }, 800);
        }
    } else {
        logAjaxError(STRING_MSG_AJAX_SUCCESS + response['Message'], 'create_order', 'get json');
        handleFlashMessage('danger', response['Message'], false);
        $('.loader').remove();
        $('#buy').prop('disabled', false);
    }
}

function createSuborder(orders, sys_language_uid, bw_customer_id, paymentMethods) {
    var is_partner = $('body').attr('data-ispartner');
    var newContract = getUrlParameter('new');
    var orderMails = getCountOfOrderMails();
    $('input, select, label').removeClass('error');
    var errors = 0;
    var action = 'create_order';
    var bw_planvariant_id = $('input[name="planvariant"]:checked').val();
    var bw_component_id = $('#component-' + bw_planvariant_id).val();
    var bw_contract_id = $("#contractId").val();
    var bw_contract_details = $("#contractDetails").val();
    var bw_couponcode = $(ID_COUPONCODE).val();
    var vat = '';
    var company = '';
    var address = '';
    var house_no = '';
    var zip = '';
    var city = '';
    var country = '';
    var phone = '';
    errors = hasRegisterErrors(orders);
    var cs_first_name = orders[0]['cs_first_name'];
    var cs_last_name = orders[0]['cs_last_name'];
    var cs_email = orders[0]['cs_email'];
    var first_name = $(ID_FIRSTNAME).val();
    var last_name = $(ID_LASTNAME).val();
    var email = $('#email').val();
    var is_trial = 0;
    if(newContract && is_partner) {
        company = $('#cs_company').val();
        address = $('#cs_street').val();
        house_no = $('#cs_housenumber').val();
        zip = $('#cs_zip').val();
        city = $('#cs_city').val();
        country = $('#cs_country').val();
        phone = $('#cs_phone').val();
        vat = $('#cs_vat').val();
        is_trial = 1;
    } else {
        company = $('#company').val();
        address = $('#address').val();
        house_no = $('#house_no').val();
        zip = $('#zip').val();
        city = $('#city').val();
        country = $('#countryiso3').val();
        phone = $('#phone').val();
        vat = vat + $('#vat').val();
        is_trial = $('body').data('istrial');
    }
    var trial_enddate = $('#trialEndDate').val();
    if (errors === 0) {
        $('#buy').after('<div class="loader pull-right"></div>');
        $('#buy, #gtac').prop('disabled', true);
        $('.deleteIcon, #adduserbtn, #triallimit').hide();

        $.ajax({
            url: VALUE_PHP_SCRIPT_ORDERS,
            beforeSend: function(xhr) {
                xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            },
            type: 'get',
            data: {
                action: action,
                bw_PlanVariantId: bw_planvariant_id,
                bw_ComponentId: bw_component_id,
                bw_ContractId: bw_contract_id,
                bw_ContractDetails: bw_contract_details,
                quantity: orderMails,
                orders: JSON.stringify(orders),
                cs_first_name: cs_first_name,
                cs_last_name: cs_last_name,
                cs_email: cs_email,
                bw_CouponCode: bw_couponcode,
                first_name: first_name,
                last_name: last_name,
                company: company,
                address: address,
                house_no: house_no,
                zip: zip,
                city: city,
                email: email,
                vat: vat,
                country: country,
                phone: phone,
                trial: is_trial,
                trial_enddate: trial_enddate
            },
            dataType: 'json',
            success: function(response) {
                logAjaxError('IS ORDER EMPTY?: ' + JSON.stringify(orders) + ', Quantity: ' + orderMails + ', Firstname: ' + cs_first_name + ', Lastname: ' + cs_last_name + ', Email: ' + cs_email, 'create_order', 'get json');
                createSuborderSuccessfulView(response, sys_language_uid, paymentMethods, orders, company);
            },
            error: function(xhr) {
                logAjaxError(VALUE_AJAX_ERROR, 'create_order', 'get json', xhr);
                handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
                $('.loader').remove();
                $('#buy').prop('disabled', false);
            }
        });
    } else {
        scrollToFirstErrorField();
    }
}

/**
 * Creates Iframe via subscriptionJs.createElement() based on subscriptionJs.Payment() & subscriptionJs.Payment()
 * Payment Process via signupService.paySignupInteractive()
 * Success calls setCsUserData()
 *
 * @param sys_language_uid
 * @param bw_order_id
 * @param bw_contract_id
 * @param bw_planvariant_id
 * @param bw_order
 * @constructor
 * @return Object iframeObj
 * @return string? success_callback
 * @return string? error_callback
 *
 *
 */
function createPaymentIframe(sys_language_uid, bw_order_id, bw_contract_id, bw_planvariant_id, bw_orderTotalGross, paymentMethods, orders) {
    var publicApiKey = $('body').attr('data-bwpublicapikey');
    let languageParameters = LanguagesIframeAndSuccess(sys_language_uid);
    var parameterLang = languageParameters.parameterLang;
    var signupService = new SubscriptionJS.Signup();
    var style = {
        body: {},
        label: {},
        input: {},
        inputRequired: {},
        inputInvalid: {}
    };
    var selectedPaymentMethod = paymentMethods[$('body').attr(ATTR_DATA_BW_ENVIRONMENT)][$('body').attr(ATTR_DATA_PAYMENT_METHOD)];
    if (selectedPaymentMethod === undefined || selectedPaymentMethod.length <= 1) {
        selectedPaymentMethod = paymentMethods[$('body').attr(ATTR_DATA_PAYMENT_METHOD)]['credit'];
    }
    var config = null;
    if ($('body').attr(ATTR_DATA_BW_ENVIRONMENT) !== 'app') {
        config = {
            paymentMethods: [selectedPaymentMethod],
            publicApiKey: publicApiKey,
            locale: parameterLang,
            providerReturnUrl: "https://" + $('body').attr(ATTR_DATA_BW_ENVIRONMENT) + ".billwerk.com/portal/finalize.html",
        };
    } else {
        config = {
            paymentMethods: [paymentMethods[$('body').attr(ATTR_DATA_BW_ENVIRONMENT)][$('body').attr(ATTR_DATA_PAYMENT_METHOD)]],
            publicApiKey: publicApiKey,
            locale: parameterLang,
            providerReturnUrl: "https://selfservice.billwerk.com/portal/finalize.html",
        };
    }
    var error_callback_iframe = function(data) {
        handleFlashMessage('danger', data.errorMessage, false);
    }
    var iframeObj = new SubscriptionJS.createElement(
        'paymentForm',
        document.getElementById("payment"),
        config,
        style,
        error_callback_iframe
    );
    var success_callback = function(data) {

        if (!data.Url) {
            $(ID_FINAL_ORDER_STEPS).removeClass('d-none');
            $(ID_CARD_PAYMENT).addClass('d-none');
            $('.card.final-order-steps').removeClass('d-none');
            $('.card.final-order-steps .payment_success').removeClass('d-none');
            $(ID_PAY1_PAY2).after('<div class="loader pull-right"></div>');
            $(ID_PAY1_PAY2).prop('disabled', true);
            firstOrder();
            setCsUserData(bw_contract_id, orders);
        } else {
            top.location = data.Url;
        }
    };
    var error_callback = function(data) {
        if (data.errorMessage !== "PayOne bearer check failed" && data.errorMessage !== "Unknown payment bearer 'undefined!'") {
            handleFlashMessage('danger', data.errorMessage, false);
        }
        console.dir(data);
        console.dir(data.errorMessage);
        $(ID_PAY1_PAY2).prop('disabled', false);
    };
    $(ID_PAY1_PAY2).unbind().click(function(ev) {
        ev.target.checkValidity();
        ev.preventDefault();
        $(ID_PAY1_PAY2).prop('disabled', true);
        var order = { OrderId: bw_order_id, GrossTotal: bw_orderTotalGross, Currency: paymentMethods['currency'] }
        signupService.paySignupInteractive(null, iframeObj, order, success_callback, error_callback);
    });
}

/**
 * createCustomerOnBwAndGetCustomerId
 *
 * Triggers the create_customer-action in customers.php and gets the ID of the customer
 * @returns void
 */
function createCustomerOnBwAndGetCustomerId() {
    console.log('createCustomerOnBwAndGetCustomerId');
    var action = 'create_customer';
    $.ajax({
        url: VALUE_PHP_SCRIPT_CUSTOMERS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
        },
        dataType: 'json',
        success: function(response) {
            if (typeof response !== 'object') {
                console.info(VALUE_AJAX_NO_ARRAY + ' => for createCustomerOnBwAndGetCustomerId');
            }
            if (response['Result'] && response['Result'] === 1) {
                setTimeout(function() { redirectTo($(ID_TARGET_URL).val()); }, 2500);
            } else {
                handleFlashMessage('danger', response['Message'], false);
            }
            return true;
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'create_customer', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
            return false;
        }
    });
    return false;
}

/**
 * updateCustomerOnBw
 *
 * Triggers the update_customer-action in the customers.php to update customer-data on the BW-Server
 * @returns void
 */
function updateCustomerOnBw() {
    var action = 'update_customer';
    $.ajax({
        url: VALUE_PHP_SCRIPT_CUSTOMERS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
        },
        dataType: 'json',
        success: function(response) {
            if (response['Message']) {
                handleFlashMessage('danger', localLangInt.javaScriptPrefixCustomerUpdateError, false);
                logAjaxError('AJAX SUCCESS but ' + response['Message'], 'update_customer', 'get ');
                setTimeout(function() { redirectTo($(ID_TARGET_URL).val()); }, 2500);
            }
            if (typeof response !== 'object') {
                console.info(VALUE_AJAX_NO_ARRAY + ' => for updateCustomerOnBw');
            }
            setTimeout(function() { redirectTo($(ID_TARGET_URL).val()); }, 2500);
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'update_customer', 'get ', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function translateBwResponseMessage(str1) {
    var str2 = 'not a valid VAT';
    var message = "";
    if (str1.indexOf(str2) > -1) {
        message = "Bitte geben Sei eine valide Steuernummer ein"
    }
    return message;
}

function toTimestamp(strDate){
    var datum = Date.parse(strDate);
    return Math.round(datum/1000);
}

/**
 * createContractCard
 *
 * Creates the Bootstrap-Cards with content for the users on the users-page
 *
 * @param {*} contract
 * @param {*} emails
 * @param {*} number
 * @param {*} sys_language_uid
 * @returns void
 */
function createContractCard(contract, emails, number, val, sys_language_uid) {
    let emailuser = val.length + 1;
    let user = emails['Memo'].split(' (');
    let endHint = '';
    let managementurl = '';
    let managebutton = '';
    let endDate = '';
    let statustext = '';
    let statustype = '';
    let today = new Date();
    let current_month = today.getMonth();
    let current_year = today.getFullYear();
    let addlink = '';
    let addurl = $('#addurl').val();
    let is_partner = $('body').data('ispartner');
    if(is_partner) {
        addurl = addurl + '?cid=' + contract['Id'] + '&phase=' + contract['LifecycleStatus'];
    }

    if (typeof contract != 'undefined') {
        if (user[1] === '') {
            user[1] = localLangInt.javaScriptPrefixLabelDummyFirstname;
        }
        if(emails['ComponentId'] === 0) {
            managementurl = $('#editurl').val() + '?contractId=' + contract['Id'];
            managebutton = '<a href="'+managementurl+'" class="btn btn-secondary btn-sm pull-right">'+ localLangInt.javaScriptPrefixManageContract + '</a>';
        } else {
            managementurl = $('#editurlcomponent').val() + '?contractId=' + contract['Id'] + '&componentId=' + emails['Id'];
            managebutton = '<a href="'+managementurl+'" class="btn btn-secondary btn-sm pull-right">'+ localLangInt.javaScriptPrefixManageContract + '</a>';
        }
        if(number === 1 || is_partner) {
            addlink = '<a href="'+addurl+'" data-contract="' + contract['Id'] + '" class="btn btn-primary btn-sm add-account pull-right"><i class="fa fa-plus" aria-hidden="true"></i> '+ localLangInt.javaScriptPrefixAddEmailUser + '</a>';
        }
        if($('body').hasClass('page-1991')) {
            let partnerContractHtml = '<div class="card w-100 only-header"><div class="card-header"><div class="row"><div class="col-md-3"><a href="'+managementurl+'" class="btn btn-sm pull-left"> <i class="fa fa-gear"></i><strong>' + localLangInt.javaScriptPrefixContractCardHeader + '</strong> ' + contract.ReferenceCode + endHint + ' </a></div><div class="col-md-3"><strong> ' + localLangInt.javaScriptPrefixClientCardHeader + ' </strong> ' + contract.CustomFields.CSCompany + '</div><div class="col-md-3"><strong> ' + localLangInt.javaScriptPrefixEmailuserCardHeader + ' </strong> ' + emailuser + '</div><div class="col-md-3"> ' + addlink + '&nbsp;' + managebutton + '</div></div></div></div>';
            $('#PartnerContracts').append(partnerContractHtml);
        } else {
            if(emails['ComponentId'] === 0 && contract['EndDate']) {
                endDate = localLangInt.javaScriptPrefixLabelWillEnd + ' ' + contract['EndDate'].substr(8, 2) + '.' + contract['EndDate'].substr(5, 2) + '.' + contract['EndDate'].substr(0, 4);
                endHint = ' (' + localLangInt.javaScriptPrefixLabelCanceled + ' ' + endDate + ')';
            } else {
                if (emails['EndDate'] !== undefined) {
                    endDate = localLangInt.javaScriptPrefixLabelWillEnd + ' ' + emails['EndDate'].substr(8, 2) + '.' + emails['EndDate'].substr(5, 2) + '.' + emails['EndDate'].substr(0, 4);
                    endHint = ' (' + localLangInt.javaScriptPrefixLabelCanceled + ' ' + endDate + ')';
                }
            }
            let cardheader = '';
            if(typeof contract['PaymentBearer'] === 'object' && contract['RecurringPaymentsPaused'] === true){
                statustext += '<div class="row"><div class="col-md-12"><a href="' + $('#editurl').val() + STRING_URL_PARAM_CONTRACT_ID + contract['Id'] + '"><i class="fa fa-edit"></i> <u>' + localLangInt.javaScriptPrefixContractStatusPaymentFailed + '</u></a></div></div>';
                statustype = ' alert alert-danger';
            }
            if(typeof contract['PaymentBearer'] === 'object') {
                if(contract['PaymentBearer']['Type'] && contract['PaymentBearer']['Type'] === 'CreditCard'){
                    if(contract['PaymentBearer']['ExpiryYear'] === current_year ){
                        if(contract['PaymentBearer']['ExpiryMonth'] > current_month && contract['PaymentBearer']['ExpiryMonth'] - current_month < 3 ){
                            statustext += '<div class="row"><div class="col-md-12"><a href="' + $('#editurl').val() + STRING_URL_PARAM_CONTRACT_ID + contract['Id'] + '"><i class="fa fa-edit"></i> <u>' + localLangInt.javaScriptPrefixContractStatusCreditcardExpiresoon + '</u></a></div></div>';
                            statustype = ' alert alert-warning';
                        }
                    }
                }
            }
            if(emails['ComponentId'] === 0) {
                if(is_partner) {
                    cardheader = '<div class="card-header' + statustype + '">' + statustext + '<div class="row"><div class="col-md-3"><a href="'+managementurl+'" class="btn btn-sm pull-left"><i class="fa fa-gear"></i> <strong>' + localLangInt.javaScriptPrefixContractCardHeader + '</strong> ' + contract['ReferenceCode'] + endHint + '</a></div><div class="col-md-3"><strong>' + localLangInt.javaScriptPrefixClientCardHeader + '</strong> ' + ((contract['CustomFields']['CSCompany'] && contract['CustomFields']['CSCompany'] != 'undefined') ? contract['CustomFields']['CSCompany'] : '') + '</div><div class="col-md-3">' + emailuser + ' <strong>' + localLangInt.javaScriptPrefixEmailuserCardHeader + '</strong></div><div class="col-md-3"><div class="row"><div class="col-md-10">' + addlink + '&nbsp;' + managebutton + '</div><div class="col-md-2"><a href="javascript:void(0);" class="btn btn-light float-right card-toggle" data-index="' + number + '"><i class="fa fa-chevron-left"></i></a></div></div></div></div></div>';
                } else {
                    cardheader = '<div class="card-header' + statustype + '">' + statustext + '<div class="row"><div class="col-md-3"><a href="'+managementurl+'" class="btn btn-sm pull-left"><i class="fa fa-gear"></i> <strong>' + localLangInt.javaScriptPrefixContractCardHeader + '</strong> ' + contract['ReferenceCode'] + endHint + '</a></div><div class="col-md-3">' + emailuser + ' <strong>' + localLangInt.javaScriptPrefixEmailuserCardHeader + '</strong></div><div class="col-md-6"><div class="row"><div class="col-md-10">' + addlink + '&nbsp;' + managebutton + '</div><div class="col-md-2"><a href="javascript:void(0);" class="btn btn-light float-right card-toggle" data-index="' + number + '"><i class="fa fa-chevron-left"></i></a></div></div></div></div></div>';
                }
            } else {
                if(is_partner) {
                    cardheader = '<div class="card-header' + statustype + '">' + statustext + '<div class="row"><div class="col-md-3"><a href="' + managementurl + '" class="btn btn-sm pull-left"><i class="fa fa-gear"></i> <strong>' + localLangInt.javaScriptPrefixContractCardHeader + '</strong> ' + contract['ReferenceCode'] + endHint + '</a></div><div class="col-md-3"><strong>' + localLangInt.javaScriptPrefixClientCardHeader + '</strong> ' + ((contract['CustomFields']['CSCompany'] && contract['CustomFields']['CSCompany'] != 'undefined') ? contract['CustomFields']['CSCompany'] : '') + '</div><div class="col-md-3">' + emailuser + ' <strong>' + localLangInt.javaScriptPrefixEmailuserCardHeader + '</strong></div><div class="col-md-3"><div class="row"><div class="col-md-10">' + localLangInt.javaScriptPrefixEmailCardHeader + addlink + '&nbsp;' + managebutton + '</div><div class="col-md-2"><a href="javascript:void(0);" class="btn btn-light float-right card-toggle" data-index="' + number + '"><i class="fa fa-chevron-left"></i></a></div></div></div></div></div>';
                } else {
                    cardheader = '<div class="card-header' + statustype + '">' + statustext + '<div class="row"><div class="col-md-3"><a href="' + managementurl + '" class="btn btn-sm pull-left"><i class="fa fa-gear"></i> <strong>' + localLangInt.javaScriptPrefixContractCardHeader + '</strong> ' + contract['ReferenceCode'] + endHint + '</a></div><div class="col-md-3"><strong>' + localLangInt.javaScriptPrefixClientCardHeader + '</strong> ' + ((contract['CustomFields']['CSCompany'] && contract['CustomFields']['CSCompany'] != 'undefined') ? contract['CustomFields']['CSCompany'] : '') + '</div><div class="col-md-6"><div class="row"><div class="col-md-10">' + localLangInt.javaScriptPrefixEmailCardHeader + addlink + '&nbsp;' + managebutton + '</div><div class="col-md-2"><a href="javascript:void(0);" class="btn btn-light float-right card-toggle" data-index="' + number + '"><i class="fa fa-chevron-left"></i></a></div></div></div></div></div>';
                }
            }
            let dataCustomer = '';
            if(contract['CustomFields']['CSCompany']) {
                dataCustomer = contract['CustomFields']['CSCompany'].toLowerCase().split(' ').join('').replace(/[^A-Za-z']/g, "");
            }

            let card = '' +
                '<div class="card w-100 user-contract" data-search="" data-subsearch="" data-bw-contract-id="' + contract['Id'] + '" data-index="' + number + '" id="contract-'+contract['Id']+'" data-timestamp="' + toTimestamp(contract['StartDate']) + '" data-customer="' + dataCustomer + '"> '
                + cardheader
                + ' <div class="card-body"><table class="table table-striped table-bordered table-hover mb-0" class="UserTable" aria-describedby="User table"><thead><tr><th scope="col" style="width:40%">'+localLangInt.javaScriptPrefixUsertableEmail+'</th><th scope="col" style="width:40%">'+localLangInt.javaScriptPrefixUsertableName+'</th><th scope="col" style="width:10%">'+localLangInt.javaScriptPrefixUsertableStatus+'</th> <th scope="col" style="width:10%">'+localLangInt.javaScriptPrefixUsertableActions+'</th></tr></thead><tbody id="UserRows-'+contract['Id']+'"></tbody></table> </div> </div>';
            $('#UserCards').append(card);
        }
    }
}

function getSorted(selector, attrName, sortDir) {
    var result;
    switch(sortDir) {
        case 'asc':
            switch(attrName) {
                case 'timestamp':
                    result = $(selector).sort(function (a, b) {
                        var contentA = parseInt( $(a).data(attrName) );
                        var contentB = parseInt( $(b).data(attrName) );
                        if(contentA < contentB) {
                            return -1;
                        } else {
                            if(contentA > contentB) {
                                return 1;
                            }
                        }
                        return 0;
                    });
                    return result;
                case 'customer':
                    result = $(selector).sort(function (a, b) {
                        var contentA = $(a).data(attrName);
                        var contentB = $(b).data(attrName);
                        if(contentA < contentB) {
                            return -1;
                        } else {
                            if(contentA > contentB) {
                                return 1;
                            }
                        }
                        return 0;
                    });
                    return result;
            }
            break;
        case 'desc':
            switch(attrName) {
                case 'timestamp':
                    result = $(selector).sort(function (a, b) {
                        var contentA = parseInt($(a).data(attrName));
                        var contentB = parseInt($(b).data(attrName));
                        if(contentA < contentB) {
                            return 1;
                        } else {
                            if(contentA > contentB) {
                                return -1;
                            }
                        }
                        return 0;
                    });
                    return result;
                case 'customer':
                    result = $(selector).sort(function (a, b) {
                        var contentA = $(a).data(attrName);
                        var contentB = $(b).data(attrName);
                        if(contentA < contentB) {
                            return 1;
                        } else {
                            if(contentA > contentB) {
                                return -1;
                            }
                        }
                        return 0;
                    });
                    return result;
            }
    }
}

/**
 * createUserRow
 *
 * Creates the table with content for the users on the users-page if the frontend-user switches the view
 *
 * @param {*} contract
 * @param {*} number
 * @param {*} sys_language_uid
 * @returns void
 */
function createUserRow(contract, emails, number, sys_language_uid) {
    var user = emails['Memo'].split(' (');
    var errors = 0;
    var sendWelcomeMail = '';
    var managementurl = '';
    var statustext = '';
    var is_trial = $('body').data('istrial');
    let is_partner = $('body').data('ispartner');

    if (typeof contract != 'undefined') {
        if (
            contract['LifecycleStatus'] === undefined ||
            (contract['LifecycleStatus'] !== undefined &&
                contract['LifecycleStatus'] !== 'Active' &&
                contract['LifecycleStatus'] !== 'InTrial')
        ) {
            errors = 10;
        } else {
            if(emails['ComponentId'] === 0) {
                if (emails['cs_first_name'] === undefined) {
                    emails['cs_first_name'] = localLangInt.javaScriptPrefixLabelDummyFirstname;
                    ++errors;
                } else {
                    if (emails['cs_first_name'] === '') {
                        emails['cs_first_name'] = localLangInt.javaScriptPrefixLabelDummyFirstname;
                        ++errors;
                    }
                }
                if (emails['cs_last_name'] === undefined) {
                    emails['cs_last_name'] = localLangInt.javaScriptPrefixLabelDummyLastname;
                    ++errors;
                } else {
                    if (emails['cs_last_name'].length === '') {
                        emails['cs_last_name'] = localLangInt.javaScriptPrefixLabelDummyLastname;
                        ++errors;
                    }
                }
                if (emails['cs_email'] === undefined) {
                    emails['cs_email'] = localLangInt.javaScriptPrefixLabelDummyEmail;
                    ++errors;
                } else {
                    if (emails['cs_email'] === '') {
                        emails['cs_email'] = localLangInt.javaScriptPrefixLabelDummyEmail;
                        ++errors;
                    }
                }
            } else {
                if (user[1] === undefined) {
                    user[1] = localLangInt.javaScriptPrefixLabelDummyFirstname;
                    ++errors;
                } else {
                    if (user[1] === '') {
                        user[1] = localLangInt.javaScriptPrefixLabelDummyFirstname;
                        ++errors;
                    }
                }
                if (user[0] === undefined) {
                    user[0] = localLangInt.javaScriptPrefixLabelDummyEmail;
                    ++errors;
                } else {
                    if (user[0] === '') {
                        user[0] = localLangInt.javaScriptPrefixLabelDummyEmail;
                        ++errors;
                    }
                }
            }
            if (
                !contract['CustomFields']['CSServerStatus'] ||
                contract['CustomFields']['CSServerStatus'] === 'undefined' ||
                contract['CustomFields']['CSServerStatus'] !== 'Active'
            ) {
                errors = 10;
            }
        }
        if (errors == 0) {
            if (contract['LifecycleStatus'] === 'InTrial') {
                statustext += localLangInt.javaScriptPrefixContractStatusPaymentIntrial;
            } else {
                statustext += localLangInt.javaScriptPrefixContractStatusPaymentSuccess;
            }
        } else if (errors >= 5) {
            statustext += localLangInt.javaScriptPrefixContractStatusPaymentError;
        } else {
            statustext += localLangInt.javaScriptPrefixContractStatusPaymentWarning;
        }

        managementurl = $('#editurl').val() + STRING_URL_PARAM_CONTRACT_ID + contract['Id'];
        var row = '<tr data-bw-contract-id="'
            + contract['Id'] + '" data-search=""><td class="enabled-search"><span class="prevent-overflow-w100"><a href="'
            + managementurl + '">'
            + user[0] + '</a></span></td> <td class="enabled-search"><a href="'
            + managementurl + '">' +
            '<span class="" data-bw-csfirstname="">'
            + user[1].slice(0,-1) + '</span></a></td> <td>'+statustext+''
            + '</td> <td> '
            + sendWelcomeMail + ' <a href="'
            + managementurl + '" class="pull-left" title="'
            + localLangInt.javaScriptPrefixLabelManage + '">'+localLangInt.javaScriptPrefixLabelManage+'</a></td>' +
            ' </tr>';
        $('#UserRows-'+contract['Id']).append(row);
        if((!is_partner && is_trial && is_trial != 2) || contract['LifecycleStatus'] == 'InTrial') {
            $(".add-account").unbind().click(function (e) {
                e.preventDefault();
                var header = localLangInt.javaScriptPrefixOrderTrialModalCancelHeadline;
                var content = localLangInt.javaScriptPrefixOrderTrialModalCancelText;
                var strSubmitFunc = "endTrial('" + $(this).data('contract') + "')";
                var btnText = localLangInt.javaScriptPrefixOrderTrialModalCancelButton;
                var closeText = localLangInt.javaScriptPrefixOrderTrialModalCancelClose;
                $('#idDynModal').empty();
                doModal('idDynModal', 'window' + $(this).data('contract'), header, content, strSubmitFunc, btnText, closeText);
            });
        }
    }
}

/**
 * createInvoiceRow
 *
 * Creates a row in the invoice-table on the user-management page
 *
 * @param {*} invoice
 * @param {*} sys_language_uid
 * @returns void
 */
function createInvoiceRow(invoice, sys_language_uid) {
    var row = '<tr data-bw-invoice-id="'
        + invoice['Id'] + '"><td>'
        + invoice['Created'].substr(8, 2) + '.'
        + invoice['Created'].substr(5, 2) + '.'
        + invoice['Created'].substr(0, 4) + '</td><td>'
        + invoice['ContractId'] + '</td><td class="text-right">'
        + invoice['TotalGross'].toFixed(2).replace('.', ',') + '</td><td>'
        + invoice['Currency'] + '</td><td><a href="javascript:void(0);" class="DownloadInvoice" data-bw-invoice-id="'
        + invoice['Id'] + '"><i class="fa fa-download"></i></a></td></tr>';
    $('#InvoiceRows tr:last').after(row);
}

/**
 * getContractsComponents
 *
 * Fetches contracts for the given customerID via ajax from Billwerk
 *
 * Ajax-Chain: Self, handleContracts
 *
 * @param {*} contracts
 * @param {*} sys_language_uid
 * @returns array contracts_components
 */
function getContractsComponents(contracts, sys_language_uid) {
    var j = 0;
    let contracts_components = [];
    $.each(contracts, function(key, val) {
        getContractComponents(val).then( function(response) {
            contracts_components[j] = response;
        });
        j++;
    });
    return contracts_components;
}

function getContractComponents(contract) {
    var action = 'get_components';
    let components = [];
    return $.ajax({
        url: VALUE_PHP_SCRIPT_COMPONENTS,
        beforeSend: function (xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: contract['Id'],
        },
        async: false,
        dataType: 'json',
        success: function (response) {
            var k = 0;
            $.each(response, function(key, val) {
                if(val) {
                    components[k] = val;
                    k++;
                }
            });
            return components;
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_components', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function getCancellationPreview() {
    var action = 'cancel_preview';
    var bw_contract_id = $("#inputContractId").val();
    $.ajax({
        url: VALUE_PHP_SCRIPT_CONTACTS,
        beforeSend: function (xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            $('#loader').removeClass('hidden');
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
        },
        dataType: 'json',
        success: function (response) {
            setCancelSubscription(bw_contract_id, response['EndDate']);
        },
        complete: function () {
            $('#loader').addClass('hidden');
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'cancel_preview', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function setCancelSubscription(bw_contract_id, end_date) {
    var action = 'cancel_contract';
    var pid = parseInt($('body').data('pid'));
    var bw_customer_id = $('body').data('bwcustomerid');
    $.ajax({
        url: VALUE_PHP_SCRIPT_CONTACTS,
        beforeSend: function (xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            $('#loader').removeClass('hidden');
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
            endDate: end_date,
        },
        dataType: 'json',
        success: function (response) {
            getContract(bw_customer_id, bw_contract_id, pid, true, false);
            hideModal();
        },
        complete: function () {
            $('#loader').addClass('hidden');
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'cancel_contract', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function setCancelComponent(bw_contract_id, bw_component_id, end_date, memo) {
    var action = 'cancel_component';
    var pid = parseInt($('body').data('pid'));
    $.ajax({
        url: VALUE_PHP_SCRIPT_COMPONENTS,
        beforeSend: function (xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
            bw_ComponentId: bw_component_id,
            endDate: end_date,
            memo: memo,
        },
        async: false,
        dataType: 'json',
        success: function (response) {
            if(pid == 1415) {
                bwSubscriptionJS(bw_contract_id);
                $('#idDynModal').empty();
            } else {
                getComponent(bw_contract_id, bw_component_id);
                $('#cancelComponentSuccess').removeClass('d-none');
                $('#cancelModal').modal('hide');
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'cancel_components', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function setEditComponent(bw_contract_id, bw_component_id, end_date, memo, old_email, new_email, new_name) {
    var action = 'edit_component';
    $.ajax({
        url: VALUE_PHP_SCRIPT_COMPONENTS,
        beforeSend: function (xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            $('#loader').removeClass('hidden');
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
            bw_ComponentId: bw_component_id,
            endDate: end_date,
            memo: memo,
        },
        async: false,
        dataType: 'json',
        success: function (response) {
            $(ID_COMPONENT_EMAIL).text(new_email);
            $(ID_COMPONENT_NAME).text(new_name);
            $(ID_EDIT_BUTTON).prop('disabled', true);
            $(ID_EDIT_BUTTON).prop('title', localLangInt.javaScriptPrefixAlreadyChanged);
            removeEmailOnCryptshareServer(bw_contract_id, old_email);
            addEmailOnCryptshareServerSimple(bw_contract_id, new_email);
            bwSubscriptionJS(bw_contract_id);
        },
        complete: function () {
            $('#loader').addClass('hidden');
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'cancel_components', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

/**
 * getContracts
 *
 * Fetches contracts for the given customerID via ajax from Billwerk
 *
 * Ajax-Chain: Self, handleContracts
 *
 * @param {*} bw_customer_id
 * @param {*} sys_language_uid
 * @returns void
 */
function getContracts(bw_customer_id, sys_language_uid) {
    var action = 'get_contracts';
    var is_trial = $('body').data('istrial');
    var is_partner = $('body').data('ispartner');
    var newContract = getUrlParameter('new');
    $(ID_PLAN_VARIANT).addClass('d-none');
    $.ajax({
        url: VALUE_PHP_SCRIPT_CONTACTS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            $('#loader').removeClass('hidden');
        },
        type: 'get',
        data: {
            action: action
        },
        dataType: 'json',
        success: function(response) {
            if (typeof response !== 'object') {
                console.info(VALUE_AJAX_NO_ARRAY + ' => for getContracts');
            }
            if ($('body').data('pid') === 1400) {
                if (response == null) {
                    $(ID_CARD_ADD_ACCOUNT).removeClass('d-none');
                }
            }
            let contracts = [];
            var i = 0;
            if (response && !newContract) {
                $.each(response, function(key, val) {
                    contracts[i] = val;
                    i++;
                });
                var reverse_contacts = contracts;
                var contracts_components = getContractsComponents(reverse_contacts, sys_language_uid);
                handleContracts(reverse_contacts, contracts_components, sys_language_uid);
                if(
                    reverse_contacts[0]['Id'] &&
                    reverse_contacts[0]['PlanVariantId'] !== '5bbf36ebe369ee0ddcb480ef' &&
                    reverse_contacts[0]['PlanVariantId'] !== '5c0e7feeaa67771104b2eab7' &&
                    reverse_contacts[0]['PlanVariantId'] !== '5c41b235aa67771f808568ea' &&
                    reverse_contacts[0]['PlanVariantId'] !== '5cae41b74802021ea0818d7c' &&
                    reverse_contacts[0]['PlanVariantId'] !== '5cae44294802002480139075' &&
                    reverse_contacts[0]['PlanVariantId'] !== '5fff2275584fd2a5425ca99a'
                ) {
                    if(!getUrlParameter('cid')) {
                        $("#contractId").val('' + reverse_contacts[0]['Id'] + '');
                    } else {
                        $("#contractId").val('' + getUrlParameter('cid') + '');
                    }

                    $("#contractDetails").val('' + reverse_contacts[0]['CustomFields']['CSContractDetails'] + '');
                    $('.custom-control-input').prop('checked', false);
                    $(ID_INPUT_PLANVARIANT_ID + reverse_contacts[0]['PlanVariantId'] + '').prop('checked', true);
                    if(typeof reverse_contacts[0]['PaymentBearer'] !== 'undefined') {
                        $('.paymenthint').removeClass('d-none');
                        $('.paymenthint a').prop('href', $('.paymenthint a').prop('href') + '?contractId=' + reverse_contacts[0]['Id']);
                        if (reverse_contacts[0]['PaymentBearer']['Type'] === 'BankAccount') {
                            $('#contractPaymentMethod').html(localLangInt.javaScriptPrefixPaymentProviderTextBankaccount + ' <strong>' + reverse_contacts[0]['PaymentBearer']['IBAN'].substring(reverse_contacts[0]['PaymentBearer']['IBAN'].length - 4, reverse_contacts[0]['PaymentBearer']['IBAN'].length) + '</strong>');
                        }
                        if (reverse_contacts[0]['PaymentBearer']['Type'] === 'CreditCard') {
                            $('#contractPaymentMethod').html(localLangInt.javaScriptPrefixPaymentProviderTextCreditcard + ' <strong>' + reverse_contacts[0]['PaymentBearer']['Last4'] + '</strong>');
                        }
                        if (reverse_contacts[0]['PaymentBearer']['Type'] === 'iDEAL') {
                            $('#contractPaymentMethod').html(localLangInt.javaScriptPrefixPaymentProviderTextIdeal + ' <strong>' + reverse_contacts[0]['PaymentBearer']['BankName'] + '</strong>');
                        }
                    }
                } else {
                    $(ID_PLAN_VARIANT).removeClass('d-none');
                }
                if(
                    typeof reverse_contacts[0]['PaymentBearer'] &&
                    reverse_contacts[0]['PlanVariantId'] !== '5bbf36ebe369ee0ddcb480ef' &&
                    reverse_contacts[0]['PlanVariantId'] !== '5c0e7feeaa67771104b2eab7' &&
                    reverse_contacts[0]['PlanVariantId'] !== '5c41b235aa67771f808568ea' &&
                    reverse_contacts[0]['PlanVariantId'] !== '5cae41b74802021ea0818d7c' &&
                    reverse_contacts[0]['PlanVariantId'] !== '5cae44294802002480139075' &&
                    reverse_contacts[0]['PlanVariantId'] !== '5fff2275584fd2a5425ca99a'
                ) {
                    $("#selector-payment,.payment-method.smart-text").addClass('d-none');
                }
                if( $(ID_ORDERED_EMAILS).length > 0 ) {
                    $(ID_ORDERED_EMAILS).val('' + reverse_contacts.length + '');
                }
            } else {
                $('.loader').remove();
                $(ID_CARD_ADD_ACCOUNT).show();
                $('#hint-used-email-users').text(0);
                $(ID_PLAN_VARIANT).removeClass('d-none');
                $('.paymenthint').addClass('d-none');
                if( $(ID_ORDERED_EMAILS).length > 0 ) {
                    $(ID_ORDERED_EMAILS).val('0');
                }
                if(is_partner) {
                    $('#cs_country option[value=' + $('body').attr('data-country') + ']').attr('selected','selected');
                    $('#cs_country option[value=0]').attr('disabled','disabled');
                    $('#cs_country').val($('body').attr('data-country')).change();
                    $("#user-data-card").addClass("d-none");
                    $(".plan-variant").addClass("partner-d-none");
                    $("#payment-row").addClass("d-none");
                    $("#user-contract-card").removeClass("d-none");
                    $("#user-overview-sort-search").addClass("d-none");
                    $("#user-overview-upsell-btn").addClass("d-none");
                }
                var userlimit = 25;
                var individual_userlimit = $('body').data('individualuserlimit');
                var user_country = $('body').data('country');
                switch (user_country) {
                    case 'IRL':
                        userlimit = 50;
                        break;
                    case 'NLD':
                        userlimit = 50;
                        break;
                    case 'GBR':
                        userlimit = 50;
                        break;
                }
                if(is_trial && is_trial != 2) {
                    userlimit = 1;
                    $('h1.subtitle').append('<span id="order-trial-subtitle">' + localLangInt.javaScriptPrefixOrderTrialSubtitle + '</span>');
                    $('#addbtn').find('a.plusIcon').html('<i class="fa fa-plus" aria-hidden="true"></i> ' + localLangInt.javaScriptPrefixOrderTrialButton);
                    $('.trial-text').removeClass('d-none');
                    $(ID_ADDITIONAL_USER_HINT).text(localLangInt.javaScriptPrefixOrderTrialFreeHint);
                }else{
                    $(ID_ADDITIONAL_USER_HINT).text(localLangInt.javaScriptPrefixOrderAdditional);
                }
                $('#hint-available-email-users').text(userlimit);
                if (individual_userlimit !== '' && individual_userlimit !== 0) {
                    userlimit = individual_userlimit;
                }
                $(ID_AVAILABLE_EMAILS).val(userlimit);
                $(ID_LEFT_EMAILS).text(userlimit);
            }
        },
        complete: function () {
            var loaders = $('#loaders').val();
            loaders--;
            if(is_partner) {
                if (loaders == '0') {
                    $('#loader').addClass('hidden');
                    $('#loaders').val('0');
                    $(".user-contract").css("min-height", "0");
                } else {
                    $('#loaders').val(loaders);
                }
            } else {
                $('#loader').addClass('hidden');
            }
            $("#UserCards .card-body").hide();
            $('*[data-index="1"]').find(".card-body").slideDown(600);
            $('*[data-index="1"]').addClass("card-open");
            $('*[data-index="1"]').find(".fa-chevron-left").addClass("fa-chevron-down").removeClass("fa-chevron-left");
            $(".card-toggle").on("click", function () {
                var cardIndex = $(this).data("index");
                $(".card-open").find(".fa-chevron-down").addClass("fa-chevron-left").removeClass("fa-chevron-down");
                $(".card-open").find(".card-body").slideUp(600);
                $(".card-open").removeClass("card-open");
                $('*[data-index="' + cardIndex + '"]').find(".card-body").slideDown(600);
                $('*[data-index="' + cardIndex + '"]').addClass("card-open");
                $('*[data-index="' + cardIndex + '"]').find(".fa-chevron-left").addClass("fa-chevron-down").removeClass("fa-chevron-left");
            });
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_contracts', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

/**
 * round
 *
 * does exactly what you think it does :D
 *
 * @param {*} x
 * @param {*} n
 * @returns float
 */
function round(x, n) {
    var a = Math.pow(10, n);
    return (Math.round(x * a) / a);
}

/**
 * handleContracts
 *
 * Builds User-Management view and shows the add-account card or upsell-card on page-1400 if needed.
 *
 * Ajax-Chain: getContracts
 *
 * @param {*} contracts
 * @param {+} contractsComponents
 * @param {*} sys_language_uid
 * @returns void
 */
function handleContracts(contracts, contracts_components, sys_language_uid) {
    var number = 0;
    var is_trial = $('body').data('istrial');
    var is_partner = $('body').attr('data-ispartner');
    $.each(contracts, function(key, val) {
        number++;
    });
    $.each(contracts_components, function(key, val) {
        $.each(val, function(key2, val2) {
            number++;
        });
    });
    $('.loader').hide();
    var userlimit = 25;
    var individual_userlimit = $('body').data('individualuserlimit');
    var user_country = $('body').data('country');
    switch (user_country) {
        case 'IRL':
            userlimit = 50;
            break;
        case 'NLD':
            userlimit = 50;
            break;
        case 'GBR':
            userlimit = 50;
            break;
    }
    if (individual_userlimit !== '' && individual_userlimit !== 0) {
        userlimit = individual_userlimit;
    }
    if(is_trial && is_trial != 2) {
        userlimit = 1;
        $(ID_ADDITIONAL_USER_HINT).text(localLangInt.javaScriptPrefixOrderTrialFreeHint);
    }
    $(ID_LEFT_EMAILS).text(userlimit);
    if (number > 0) {
        var availableEmailUsers = userlimit - number;
        $(ID_LEFT_EMAILS).text(availableEmailUsers);
        $(ID_AVAILABLE_EMAILS).val(availableEmailUsers);
        if(is_partner == '0') {
            $('#hint-used-email-users').text(number);
            $('#hint-available-email-users').text(availableEmailUsers);
        } else {
            $('#dashboard-email-user').addClass('d-none');
        }
    }

    if ($('body').hasClass('page-1400') || $('body').hasClass('page-1991')) {
        if ((number < userlimit || is_trial) && !contracts[0]['EndDate']) {
            $(ID_CARD_ADD_ACCOUNT).removeClass('d-none');
        }
        var listnumber = 1;
        var i = 0;
        let contract = {};
        $.each(contracts_components, function(key, val) {
            contract = {
                Memo: contracts[i]['CustomFields']['CSEmailUser']
                    + " (" + contracts[i]['CustomFields']['CSFirstName'] + " "
                    + contracts[i]['CustomFields']['CSLastName'] + ")",
                BilledUntil: contracts[i]['CustomFields']['BilledUntil'],
                ComponentId: 0,
                ContractId: contracts[i]['CustomFields']['Id'],
                CustomerId: contracts[i]['CustomFields']['CustomerId'],
                Id: contracts[i]['CustomFields']['PlanVariantId'],
                Quantity: 1,
                StartDate: contracts[i]['CustomFields']['StartDate'],
                cs_email: contracts[i]['CustomFields']['CSEmailUser'],
                cs_first_name: contracts[i]['CustomFields']['CSFirstName'],
                cs_last_name: contracts[i]['CustomFields']['CSLastName'],
                cs_address: contracts[i]['CustomFields']['CSAddress'],
                cs_city: contracts[i]['CustomFields']['CSCity'],
                cs_company: contracts[i]['CustomFields']['CSCompany'],
                cs_country: contracts[i]['CustomFields']['CSCountry'],
                cs_phone: contracts[i]['CustomFields']['CSPhone'],
                cs_vat: contracts[i]['CustomFields']['CSVat'],
                cs_zip: contracts[i]['CustomFields']['CSZip']
            }
            if(is_partner) {
                var partnerLink = $('#addpartnerurl').val() + '/?cid=' + contracts[i]['CustomerId'];
                $('#partnerlink').attr("href", partnerLink);
                $('#partnerlink').removeClass('d-none');
            }
            createContractCard(contracts[i], contract, listnumber, val, sys_language_uid);
            createUserRow(contracts[i], contract, listnumber, sys_language_uid);
            $.each(val.reverse(), function (key2, val2) {
                ++listnumber;
                createUserRow(contracts[i], val2, listnumber, sys_language_uid);
            });
            ++listnumber;
            i++;
        });
        $('#UserCard').removeClass('d-none');
    }
    if ($('body').hasClass('page-1427')) {
        if (number >= userlimit && !is_partner) {
            redirectTo($('#targeturlifusersexceed').val());
        }
    }
}

/**
 * getPricingPlanVariant
 *
 * Fetches Pirce for the Planvariant via Ajax
 *
 * Ajax-Chain: self, updateSummaryValues
 *
 * @param {*} bw_plan_variant_id
 * @returns void
 */
function getPricingPlanVariant(bw_plan_variant_id) {
    var action = 'get_planvariant';
    var pid = parseInt($('body').data('pid'));
    $.ajax({
        url: '/typo3conf/ext/cryptsharesaas/Classes/planvariants.php',
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            bw_PlanVariantId: bw_plan_variant_id,
        },
        dataType: 'json',
        success: function(response) {
            if(pid == 1415) {
                getPlan(response['PlanId']);
                $("#subscriptionPackageVariant").text(response['InternalName']);
            }
            if (typeof response !== 'object') {
                console.info(VALUE_AJAX_NO_ARRAY + ' => for getPricingPlanVariant');
            }
            if ($(ID_DATA_PLAN_VARIANT_ID + bw_plan_variant_id + '"] .custom-control-input').prop('checked')) {
                updateSummaryValues(response, 'planvariant');
            }
            $(ID_DATA_PLAN_VARIANT_ID + bw_plan_variant_id + '"] .PlanVariantTitle').text(response['InternalName']);
            if (response['FeePeriod']['Unit'] === 'Year') {
                $(ID_DATA_PLAN_VARIANT_ID + bw_plan_variant_id + '"] .PlanVariantAnnualPrice').text(response['RecurringFee']);
                response['FeePeriod']['Unit'] = 'Month';
                response['RecurringFee'] = response['RecurringFee'] / response['FeePeriod']['Quantity'] / 12;
                $(ID_DATA_PLAN_VARIANT_ID + bw_plan_variant_id + '"] .PlanVariantAnnualDescription').text(localLangInt.javaScriptPrefixCheckoutPricingPlanAnnualDescription);
            } else {
                $(ID_DATA_PLAN_VARIANT_ID + bw_plan_variant_id + '"] .PlanVariantAnnualPrice').text(response['RecurringFee'] * 12);
                $(ID_DATA_PLAN_VARIANT_ID + bw_plan_variant_id + '"] .PlanVariantAnnualDescription').text(localLangInt.javaScriptPrefixCheckoutPricingPlanMonthlyDescription);
            }
            $(ID_DATA_PLAN_VARIANT_ID + bw_plan_variant_id + '"] .PlanVariantIntervall').text(localLangInt['javaScriptPrefix' + response['FeePeriod']['Unit'].toLowerCase()]);
            $(ID_DATA_PLAN_VARIANT_ID + bw_plan_variant_id + '"] .PlanVariantPrice').text(response['RecurringFee']);
            $('li.loading').remove();
            $(ID_DATA_PLAN_VARIANT_ID + bw_plan_variant_id + '"] .PlanVariantDescription').text(response['Description']['_c']);
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_contracts', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function getPlan(bw_plan_id) {
    var action = 'get_plan';
    var pid = parseInt($('body').data('pid'));
    $.ajax({
        url: '/typo3conf/ext/cryptsharesaas/Classes/plans.php',
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            plan_id: bw_plan_id,
        },
        dataType: 'json',
        success: function(response) {
            if(pid == 1415) {
                $("#subscriptionPackage").text(response['Name']['_c']);
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_plan', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

/**
 * updateSummaryValues
 *
 * Updates the Values in the Summary table on the order-page
 *
 * Ajax-Chain: getPricingPlanVariant
 *
 *
 * @param {*} response
 * @param {*} mode
 * @returns void
 */
function updateSummaryValues(response, mode, quantity) {
    let price = 0,
        singleprice = 0,
        totalprice = 0,
        totalvatprice = 0,
        totalgross = 0;
    let is_trial = $('body').data('istrial');
    let newContract = getUrlParameter('new');
    let is_partner = $('body').attr('data-ispartner');
    if (mode === 'order-preview') {
        if(response !== undefined) {
            const date = new Date(response['NextTotalGrossDate']);
            var trialdate = date.toLocaleString(document.documentElement.lang, {day: 'numeric', year: 'numeric', month: 'long'});

            if ($.isArray(response['RecurringFee']['LineItems']) && response['RecurringFee']['LineItems'].length > 0) {
                $.each(response['RecurringFee']['LineItems'], function(index, value) {
                    if (value['PricePerUnit'] < 0) {
                        $('tr#discount, tr#subtotal').removeClass('d-none');
                        $("span[data-summary='discount']").text(value['TotalNet'].toFixed(2).replace('.', ','));
                    } else {
                        $('tr#discount, tr#subtotal').addClass('d-none');
                        var SummaryDiscount = 0;
                        $("span[data-summary='discount']").text(SummaryDiscount.toFixed(2).replace('.', ','));
                        if (index === 0) {
                            price = parseFloat(value['PricePerUnit']) * quantity;
                            singleprice = parseFloat(value['PricePerUnit']);
                            $("span[data-summary='price']").text(price.toFixed(2).replace('.', ','));
                            $("span[data-summary='singleprice']").text(singleprice.toFixed(2).replace('.', ','));
                        }
                    }
                });
            } else {
                price = parseFloat(response['RecurringFee']['PricePerUnit']) * quantity;
                singleprice = parseFloat(response['RecurringFee']['PricePerUnit']);
                $("span[data-summary='price']").text(price.toFixed(2).replace('.', ','));
                $("span[data-summary='singleprice']").text(singleprice.toFixed(2).replace('.', ','));
            }

            totalprice = parseFloat(response['Total']) * quantity;
            totalvatprice = parseFloat(response['TotalVat']) * quantity;
            $("span[data-summary='totalnetto']").text(totalprice.toFixed(2).replace('.', ','));
            $("span[data-summary='totalvat']").text(totalvatprice.toFixed(2).replace('.', ','));
            totalgross = parseFloat(response['TotalGross']) * quantity;
            $("span[data-summary='totalbrutto']").text(totalgross.toFixed(2).replace('.', ','));
            $("span[data-summary='vatpercentage']").text(response['RecurringFee']['VatPercentage']);
            $("span[data-summary='currency']").text(response['Currency']);
            $("span[data-summary='quantity']").text(quantity);
            $("span[data-summary='variantname']").text(response['RecurringFee']['VariantName']);
            $("#no-trial").addClass('d-none');
            $("#trial-firstline").addClass('d-none');
            $("#trial-secondline").addClass('d-none');
            if((is_trial && is_trial != 2) || (is_partner && newContract)) {
                $("#trial-firstline").removeClass('d-none');
                $("#trial-secondline").removeClass('d-none');
                $("#trial-hint").removeClass('d-none');
                $("html")
                $("#trial-until").text(trialdate);
                $("#abo-start").text(trialdate);
                $("#trial-cancel-date").text(trialdate);
            } else {
                $("#no-trial").removeClass('d-none');
            }
        }
    }
}

/**
 * logAjaxError
 *
 * triggers the AjaxErrorLog.php via Ajax
 *
 * @param {*} error
 * @param {*} rootAction
 * @param {*} declaration
 * @param {*} errorHeader
 * @returns void
 */
function logAjaxError(error, rootAction, declaration, errorHeader) {
    if (typeof errorHeader === "undefined" || errorHeader === null) {
        errorHeader = "noErrorHeader";
    }
    errorHeader = "[not jet] report Header need descision what 2 track ";
    $.ajax({
        url: '/typo3conf/ext/cryptsharesaas/Classes/AjaxErrorLog.php',
        type: 'get',
        data: {
            error: error,
            rootAction: rootAction,
            declaration: declaration,
            action: 'ajaxError',
            errorHeader: (errorHeader.responseText) ? errorHeader.responseText : ''
        },
        dataType: 'json'
    });
}

/**
 * getAccessToken
 *
 * fetches AccessToken for the given customerID
 *
 * @param {*} bw_customer_id
 * @returns void
 */
function getAccessToken(bw_customer_id) {
    var action = 'get_access_token';
    $.ajax({
        url: '/typo3conf/ext/cryptsharesaas/Classes/authorization.php',
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action
        },
        dataType: 'json',
        success: function(response) {
            if (response['Result'] === 1) {
                if ($('body').data('pid') === 1414) {
                    window.setTimeout(createCustomerOnBwAndGetCustomerId(), 2500);
                } else {

					setTimeout(function() { redirectTo($(ID_TARGET_URL).val()); }, 2500);

                }
            } else {
                logAjaxError('AJAX SUCCESS Message: ' + response['Message'], 'get_access_token', 'get json');
                handleFlashMessage('danger', response['Message'], false);
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_access_token', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

/**
 * getSelfServiceToken
 *
 * fetches SelfServiceToken for the given customer and contract IDs
 *
 * @param {*} bw_customer_id
 * @param {*} bw_contract_id
 * @returns void
 */
function getSelfServiceToken(bw_customer_id, bw_contract_id) {
    var action = 'get_selfservice_token';
    $.ajax({
        url: VALUE_PHP_SCRIPT_CONTACTS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
        },
        dataType: 'json',
        success: function(response) {
            createSelfServiceIframe(response['Token']);
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_selfservice_token', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function setContractCustomer(customer) {
    var pid = parseInt($('body').data('pid'));
    var bw_customer_id = $('body').data('bwcustomerid');
    var bw_contract_id = getUrlParameter('contractId');
    var action = 'set_contract_customer';
    $.ajax({
        url: VALUE_PHP_SCRIPT_CONTACTS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            $('#loader').removeClass('hidden');
        },
        type: 'get',
        data: {
            action: action,
            Id: customer.Id,
            Firstname: customer.Firstname,
            Lastname: customer.Lastname,
            Company: customer.Company,
            Street: customer.Street,
            Housenumber: customer.Housenumber,
            Zip: customer.Zip,
            City: customer.City,
            Country: customer.Country,
            Phone: customer.Phone,
            Email: customer.Email,
            Vat: customer.Vat,
            ChangedName: customer.ChangedName,
            ChangedEmail: customer.ChangedEmail
        },
        dataType: 'json',
        success: function(response) {
            $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                $("#success-alert").slideUp(500);
            });
            bwSubscriptionJS(bw_contract_id);
            getContract(bw_customer_id, bw_contract_id, pid, true, true);

        },
        complete: function () {
            $('#loader').addClass('hidden');
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'set_contract_customer', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function setCsUserData(bw_contract_id, orders = []) {
    var action = 'set_contracts_csuserdata';
    $('.card.saving-userdata').removeClass('d-none');
    $(ID_HTML_BODY).animate({
        scrollTop: $('.card.final-order-steps').offset().top
    }, 800);
    $.ajax({
        url: VALUE_PHP_SCRIPT_CONTACTS,
        type: 'get',
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
        },
        dataType: 'json',
        success: function(response) {
            $('.card.final-order-steps .set_contracts_csuserdata').removeClass('d-none');
            addEmailOnCryptshareServer(bw_contract_id, orders);
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'set_contracts_csuserdata', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function getCsUserData(bw_contract_id) {
    var action = 'get_contracts_csuserdata';
    $.ajax({
        url: VALUE_PHP_SCRIPT_CONTACTS,
        type: 'get',
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
        },
        dataType: 'json',
        success: function(response) {
            if (response[0]['bw_ContractId'] && response[0]['bw_ContractId'].length === 24) {
                if (response[0]['cs_first_name'].length > 1 && response[0]['cs_last_name'].length > 1 && response[0]['cs_email'].length > 1) {
                    $(KEY_CS_FIRSTNAME).val(response[0]['cs_first_name']);
                    $(KEY_CS_LASTNAME).val(response[0]['cs_last_name']);
                    $('#cs_email').val(response[0]['cs_email']);
                    setCsUserData(response[0]['bw_ContractId'], response);
                } else {
                    handleFlashMessage('danger', localLangInt.javaScriptPrefixLabelUserDataErrorFetchingCsuserdata, false);
                }
            } else {
                logAjaxError('AJAX SUCCESS but wrong data(bw_ContractId)', 'set_contracts_csuserdata', 'get json');
                handleFlashMessage('danger', localLangInt.javaScriptPrefixLabelUserDataErrorFetchingCsuserdata, false);
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'set_contracts_csuserdata', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

/**
 * addEmailOnCryptshareServer
 *
 * Ajax-Chain:
 *
 * @param {*} bw_contract_id
 * @param {*} cs_email
 */
function addEmailOnCryptshareServer(bw_contract_id, orders) {
    var action = 'add_email_on_csserver';
    var is_trial = $('body').data('istrial');
    if(bw_contract_id) {
        $.ajax({
            url: VALUE_PHP_SCRIPT_CRYPTSHAREAPI,
            beforeSend: function(xhr) {
                xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            },
            type: 'get',
            data: {
                action: action,
                bw_ContractId: bw_contract_id,
                orders: JSON.stringify(orders),
                is_trial: is_trial,
            },
            dataType: 'json',
            success: function(response) {
                if (typeof response !== 'object') {
                    console.info(VALUE_AJAX_NO_ARRAY + ' => for addEmailOnCryptshareServer');
                }
                if (response['Message'] === 'Success') {
                    $('.card.final-order-steps .add_email_on_csserver').removeClass('d-none');
                    setTimeout(function() { redirectTo($(ID_TARGET_URL).val() + STRING_URL_PARAM_CONTRACT_ID + bw_contract_id); }, 2500);
                } else {
                    logAjaxError('AJAX SUCCESS but Message :' + response['Message'], 'add_email_on_csserver', 'get json');
                    handleFlashMessage('danger', response['Message'], false);
                }
            },
            error: function(xhr) {
                logAjaxError(VALUE_AJAX_ERROR, 'add_email_on_csserver', 'get json', xhr);
                handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
            }
        });
    } else {
        logAjaxError('No Contract ID', 'add_email_on_csserver', 'get json');
        handleFlashMessage('danger', 'No Contract ID', false);
    }
}

/**
 * addEmailOnCryptshareServerSimple
 *
 * Ajax-Chain:
 *
 * @param {*} bw_contract_id
 * @param {*} cs_email
 */
function addEmailOnCryptshareServerSimple(bw_contract_id, new_email) {
    var action = 'add_email_on_csserver_simple';
    var is_trial = $('body').data('istrial');
    $.ajax({
        url: VALUE_PHP_SCRIPT_CRYPTSHAREAPI,
        beforeSend: function(xhr) {
            $('#componentCard').addClass('d-none');
            $('#loading').removeClass('d-none');
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
            email: new_email,
            is_trial: is_trial,
        },
        dataType: 'json',
        success: function(response) {
            if (typeof response !== 'object') {
                console.info(VALUE_AJAX_NO_ARRAY + ' => for addEmailOnCryptshareServerSimple');
            }
            if (response['Message'] === 'Success') {
                $('#loading').addClass('d-none');
                $('#componentCard').removeClass('d-none');
                $('#editComponentSuccess').removeClass('d-none');
                $('#editModal').modal('hide');
            } else {
                logAjaxError('AJAX SUCCESS but Message :' + response['Message'], 'add_email_on_csserver', 'get json');
                handleFlashMessage('danger', response['Message'], false);
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'add_email_on_csserver', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function removeEmailOnCryptshareServer(bw_contract_id, email) {
    var action = 'remove_email_on_csserver';
    $.ajax({
        url: VALUE_PHP_SCRIPT_CRYPTSHAREAPI,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
            email: email,
        },
        dataType: 'json',
        success: function(response) {
            if (typeof response !== 'object') {
                console.info(VALUE_AJAX_NO_ARRAY + ' => for removeEmailOnCryptshareServer');
            }
            if (response['Message'] !== 'Success') {
                logAjaxError('AJAX SUCCESS but Message :' + response['Message'], 'add_email_on_csserver', 'get json');
                handleFlashMessage('danger', response['Message'], false);
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'add_email_on_csserver', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function sendWelcomeMailToCSEmailUser(bw_contract_id, cs_email) {
    $('#SendWelcomeMail').unbind().click(function(e) {
        e.preventDefault();
        var action = 'send_welcome_mail';
        $.ajax({
            url: VALUE_PHP_SCRIPT_CRYPTSHAREAPI,
            beforeSend: function(xhr) {
                xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            },
            type: 'get',
            data: {
                action: action,
                bw_ContractId: bw_contract_id,
                cs_email: cs_email
            },
            dataType: 'json',
            success: function(response) {
                if (typeof response !== 'object') {
                    console.info(VALUE_AJAX_NO_ARRAY + ' => for sendWelcomeMailToCSEmailUser');
                }
                handleFlashMessage('success', 'Welcome e-mail successfully sent to ' + cs_email + '');
            },
            error: function(xhr) {
                logAjaxError(VALUE_AJAX_ERROR, 'send_welcome_mail', 'get json', xhr);
                handleFlashMessage('error', localLangInt.javaScriptPrefixFatalError, xhr);
            }
        });
    });
    $('#PreviewWelcomeMail').unbind().click(function(e) {
        e.preventDefault();
        previewWelcomeMail();
    });
}

function getContract(bw_customer_id, bw_contract_id, pid, needselfservice, refresh) {
    var action = 'get_contract';
    $.ajax({
        url: VALUE_PHP_SCRIPT_CONTACTS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
            $('#loader').removeClass('hidden');
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
        },
        dataType: 'json',
        success: function(response) {
            if (response['Message']) {
                logAjaxError('AJAX SUCCESS but Message: ' + response['Message'], 'get_contract', 'get json');
                handleFlashMessage('danger', response['Message'], false);
            } else {
                if (response['CustomFields']['CSEmailUser'] && response['CustomFields']['CSEmailUser'].length) {
                    if(pid === 1415) {
                        $("#customerContract").text((response['ReferenceCode']) ? response['ReferenceCode'] : '');
                        getPricingPlanVariant(response['PlanVariantId']);
                        var startDate = new Date(response['StartDate']);
                        $("#subscriptionPackageStart").text(startDate.toLocaleString(document.documentElement.lang, {day: 'numeric', year: 'numeric', month: 'long'}));
                        var nextBillingDate = new Date(response['NextBillingDate']);
                        $("#subscriptionPackageNextBill").text(nextBillingDate.toLocaleString(document.documentElement.lang, {day: 'numeric', year: 'numeric', month: 'long'}));
                        $("#inputSubscriptionPackageStart").val(response['NextBillingDate']);
                        if(!response['EndDate']) {
                            $("#tableSubscriptionPackageEnd").addClass("d-none");
                            $("#tableSubscriptionPackageNextBill").removeClass("d-none");
                        } else {
                            var endDate = new Date(response['EndDate']);
                            $("#subscriptionPackageEnd").text(endDate.toLocaleString(document.documentElement.lang, {day: 'numeric', year: 'numeric', month: 'long'}));
                            $("#tableSubscriptionPackageEnd").removeClass("d-none");
                            $("#tableSubscriptionPackageNextBill").addClass("d-none");
                            $("#cancel-Subscription").prop('disabled', true);
                        }
                        if(refresh) {
                            getInvoices(response['CustomerId']);
                        }
                    } else {
                        $(KEY_CS_FIRSTNAME).val(response['CustomFields']['CSFirstName']);
                        $('.cs_first_name').text(response['CustomFields']['CSFirstName']);
                        $(KEY_CS_LASTNAME).val(response['CustomFields']['CSLastName']);
                        $('.cs_last_name').text(response['CustomFields']['CSLastName']);
                        $('#cs_email').val(response['CustomFields']['CSEmailUser']);
                        $('.cs_email').text(response['CustomFields']['CSEmailUser']);
                        $(ID_INPUT_PLANVARIANT_ID + response['PlanVariantId'] + '').prop('checked', true);
                        $(ID_INPUT_PLANVARIANT_ID + response['PlanVariantId'] + '').closest('.card').addClass('active');
                    }
                } else {
                    $('body.page-1415 .progress, body.page-1415 form#enter-user-data').show();
                }
                if (needselfservice) {
                    getSelfServiceToken(bw_customer_id, bw_contract_id);
                }
            }
        },
        complete: function () {
            $('#loader').addClass('hidden');
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_contract', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function getSingleContract(bw_contract_id) {
    var action = 'get_contract';
    $.ajax({
        url: VALUE_PHP_SCRIPT_CONTACTS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
        },
        dataType: 'json',
        success: function(response) {
            if ($('body').data('pid') === 1954) {
                $('#nextBillingDate').val(response['NextBillingDate']);
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_contract', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

/**
 * Commits Order via AJAX calling Billwerk REST API thru VALUE_PHP_SCRIPT_ORDERS
 * Payment Process via signupService.paySignupInteractive()
 * Success calls setCsUserData()
 *
 * @param sys_language_uid
 * @param bw_order_id
 * @param bw_contract_id
 * @param bw_customer_id
 * @constructor
 * @return string? success_callback
 * @return string? error_callback
 *
 *
 */
function commitOrder(sys_language_uid, bw_order_id, bw_contract_id, bw_customer_id, orders) {
    var action = 'commit_order_nopayment';
    function success_commit_callback(data) {
        if (!data.Url) {
            $('.set_contracts_csuserdata').removeClass('d-none');
            setCsUserData(bw_contract_id, orders);
        } else {
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, false);
            logAjaxError('AJAX SUCCESS but no matching response', 'success_commit_callback', 'get json');
        }
    }
    function error_commit_callback(data) {
        handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, false);
        logAjaxError(VALUE_AJAX_ERROR, 'success_commit_callback', 'get json');
    }
    $.ajax({
        url: VALUE_PHP_SCRIPT_ORDERS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            bw_order_id: bw_order_id,
            action: action,
            id: bw_customer_id
        },
        dataType: 'json',
        success: success_commit_callback,
        error: error_commit_callback
    });
}

function createSelfServiceIframe(bw_selfservice_token) {
    var sys_language_uid = $('body').data('syslanguageuid');
    let languageParameters = LanguagesIframeAndSuccess(sys_language_uid);
    var iframeLang = languageParameters.iframeLang;
    if (bw_selfservice_token) {
        $('#preloader').remove();
        $('.selfserviceIframeContainer').append(
            '<iframe src="https://'
            + $('body').attr(ATTR_DATA_BW_ENVIRONMENT)
            + '.billwerk.com/portal/account.html#/'
            + bw_selfservice_token + iframeLang + '" class="selfserviceIframe"></iframe>'
        );
    } else {
        changeLocalizationLabel('label-selfservice-iframe-loading', 'label-selfservice-iframe-contractid-missing');
    }
}

function redirectTo(targetURL, target = '_self') {
    if (targetURL && targetURL.length > 0) {
        if(target !== '') {
            window.open(targetURL, target);
        } else {
            window.top.location.href = targetURL;
        }
    } else {
        handleFlashMessage('danger', 'Process was successfully, but the target URL for the redirect it missing.<br>Please cick on any link to go on.', false);
    }
}

function reloadWindow() {
    window.location.reload(true);
}

function varMissing(missingVar) {
    handleFlashMessage('danger', 'Variable ' + missingVar + ' missing', false);
}

function handleOnePageOrderProcess(sys_language_uid, bw_customer_id, bw_planvariant_id) {
    var bw_customer_country = $('body').data('country');
    var paymentMethods = {};
    switch (bw_customer_country) {
        case 'GBR':
            paymentMethods = {
                sandbox: {
                    credit: STRING_CREDITCARD_FAKE_PSP
                },
                app: {
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'GBP'
            }
            break;
        case 'AUT':
        case 'DEU':
            paymentMethods = {
                sandbox: {
                    debit: STRING_DEBIT_FAKE_PSP,
                    credit: STRING_CREDITCARD_FAKE_PSP
                },
                app: {
                    debit: STRING_DEBIT_PAYONE,
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'EUR'
            }
            break;
        case 'NLD':
            paymentMethods = {
                sandbox: {
                    debit: STRING_DEBIT_FAKE_PSP,
                    credit: STRING_CREDITCARD_FAKE_PSP,
                    iDEAL: STRING_ADYEN_IDEAL
                },
                app: {
                    debit: STRING_DEBIT_PAYONE,
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'EUR'
            }
            break;
        case 'CHE':
            paymentMethods = {
                sandbox: {
                    credit: STRING_CREDITCARD_FAKE_PSP
                },
                app: {
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'CHF'
            }
            break;
        case 'USA':
            paymentMethods = {
                sandbox: {
                    credit: STRING_CREDITCARD_FAKE_PSP
                },
                app: {
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'USD'
            }
            break;
        default:
            paymentMethods = {
                sandbox: {
                    credit: STRING_CREDITCARD_FAKE_PSP
                },
                app: {
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'EUR'
            }
            break;
    }
    if (!(paymentMethods[$('body').data('bwenvironment')]['debit'] !== undefined && paymentMethods[$('body').data('bwenvironment')]['debit'].indexOf('Debit') > -1)) {
        $('#selector-debit').addClass('d-none');
    }
    if (!(paymentMethods[$('body').data('bwenvironment')]['credit'] !== undefined && paymentMethods[$('body').data('bwenvironment')]['credit'].indexOf('Credit') > -1)) {
        $('#selector-credit').addClass('d-none');
    }
    if (!(paymentMethods[$('body').data('bwenvironment')]['iDEAL'] !== undefined && paymentMethods[$('body').data('bwenvironment')]['iDEAL'].indexOf('iDEAL') > -1)) {
        $('#selector-iDEAL').addClass('d-none');
    }
    var payedContract = getUrlParameter('contractId');
    var trigger = getUrlParameter('trigger');
    if (trigger === 'PaymentError') {
        handleFlashMessage('danger', 'Payment error - You did not pay your contract successfully. Please try again with an other payment method', false);
    }
    if (payedContract && trigger === 'Payment') {
        getContract(bw_customer_id, payedContract, $('body').data('pid'), true, true);
        $('.card.staff-member-hint, .card.payment, .card.billing-data, .card-deck.whatyouget, .card-deck.plan-variant, .card-deck.paysecure').addClass('d-none');
        $('.col-lg-6.col-md-12.col-sm-12').removeClass('col-lg-6');
        $('.card.final-order-steps, .card.new-user-account.user-data .card-footer').removeClass('d-none');
        $('.card.final-order-steps .payment_success').removeClass('d-none');
        firstOrder();
        getCsUserData(payedContract);
    } else {
        $(KEY_CS_FIRSTNAME).focus();
    }
    getPricingPlanVariantForEachDiv();
    $('a.EditData').unbind().click(function(e) {
        e.preventDefault();
        $('.card input,.card select').prop('disabled', false);
    });
    $('.custom-control-input[id^=planvariantid]').unbind().click(function() {
        $('.custom-control-input[id^=planvariantid]').prop('disabled', false);
        $(this).prop('disabled', true);
        $('.card.active.mb-6').removeClass('active');
        var clickedItem = $(this).attr('id');
        $('.custom-control-input.pricing:not(#' + clickedItem + ')').prop('checked', false);
        $('.card.active.mb-6').removeClass('active');
        $(this).closest('.card').addClass('active');
        createOrderPreview(sys_language_uid, bw_customer_id);
    });

    $('.btn-payment').unbind().click(function() {
        $('.btn-payment').removeClass('focus');
        $(this).addClass('focus');
        $('.smart-text').addClass('d-none');
        $('.' + $(this).data('payment-method') + '-smart-text').removeClass('d-none');
        $('body').attr(ATTR_DATA_PAYMENT_METHOD, $(this).data('payment-method'));
        if (
            $('body').attr(ATTR_DATA_BW_ORDER_ID) !== undefined &&
            $('body').attr(ATTR_DATA_BW_CONTRACT_ID) !== undefined &&
            $('body').attr(ATTR_DATA_BW_VARIANT_ID) !== undefined &&
            $('body').attr(ATTR_DATA_ORDER_TOTAL_GROSS) !== undefined
        ) {
            var iframes = document.querySelectorAll('iframe');
            for (var i = 0; i < iframes.length; i++) {
                iframes[i].parentNode.removeChild(iframes[i]);
            }
            createPaymentIframe(
                sys_language_uid,
                $('body').attr(ATTR_DATA_BW_ORDER_ID),
                $('body').attr(ATTR_DATA_BW_CONTRACT_ID),
                $('body').attr(ATTR_DATA_BW_VARIANT_ID),
                $('body').attr(ATTR_DATA_ORDER_TOTAL_GROSS),
                paymentMethods
            );
        }
    });
    $(ID_APPLY_VOUCHER).on('click', function(e) {
        createOrderPreview(sys_language_uid, bw_customer_id);
    });
    createOrder(sys_language_uid, bw_customer_id, paymentMethods);
}

function getPricingPlanVariantForEachDiv() {
    $('div.plan-variant').each(function(index, item) {
        var bw_planvariant_id = $(item).data('plan-variant-id');
        if (bw_planvariant_id.length === 24) {
            getPricingPlanVariant(bw_planvariant_id);
        }
    });
}

function checkRequirements(bw_customer_id, bw_access_token) {
    var error = 0;
    if (bw_customer_id.length < 24) {
        handleFlashMessage('danger', 'You dont have a valid bw_customer_id yet.<br>Please get in touch with us to fix that issue.', false);
        ++error;
    }
    if (!bw_access_token || bw_access_token.length < 24) {
        handleFlashMessage('danger', 'You dont have a valid access token.<br>Please make sure to activate Cookies in your browser settings.', false);
        ++error;
    }
    return (error === 0);
}

function setServerHostInLinks(cs_server_host) {
    if (typeof(cs_server_host) != "undefined" && cs_server_host !== null && cs_server_host !== "") {
        $("a:contains('webapp.cryptshare.express')").text(cs_server_host);
        $("a[href*='webapp.cryptshare.express']").attr('href', cs_server_host);
    }
}

function getInvoices(bw_customer_id, sys_language_uid) {
    var action = 'get_invoices';
    $.ajax({
        url: '/typo3conf/ext/cryptsharesaas/Classes/invoices.php',
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action
        },
        dataType: 'json',
        success: function(response) {
            if (typeof response !== 'object') {
                console.info(VALUE_AJAX_NO_ARRAY + ' => for getInvoices');
            }
            if (response) {
                $('.loader').hide();
                $('#InvoicesTable').show();
                $.each(response, function(key, val) {
                    createInvoiceRow(val, sys_language_uid);
                });
                $('.DownloadInvoice').unbind().click(function() {
                    $(this).after('<div class="loader"></div>');
                    createInvoiceDownloadLink($(this).attr('data-bw-invoice-id'));
                });
            } else {
                logAjaxError('AJAX SUCCESS but no response', 'get_invoices', 'get json');
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_invoices', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function createInvoiceDownloadLink(bw_invoice_id) {
    var action = 'download_invoice';
    $.ajax({
        url: '/typo3conf/ext/cryptsharesaas/Classes/invoices.php',
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            bw_InvoiceId: bw_invoice_id
        },
        dataType: 'json',
        success: function(response) {
            if (typeof response !== 'object') {
                console.info(VALUE_AJAX_NO_ARRAY + ' => for createInvoiceDownloadLink');
            }
            if (response) {
                if (response['Url'].length > 10) {
                    var downloadUrl = 'https://' + $('body').attr(ATTR_DATA_BW_ENVIRONMENT) + '.billwerk.com';
                    redirectTo(downloadUrl + response['Url'], '_blank');
                    $('.loader').remove();
                } else {
                    handleFlashMessage('danger', 'Error while trying to create a download link of invoice', false);
                }
            } else {
                logAjaxError('AJAX SUCCESS but no response', 'get_invoices', 'get json');
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_invoices', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

/**
 * Checks i a given Vat is Valid for a given Country,
 * Vallues are taken from DOM
 * Returns are displayed in DOM
 *
 * * Last Change 2019-05-13 (Rewrite form value with Normalisation to prevent BW Error)
 *
 * Using an external class by Sergei Panfilov <https://github.com/se-panfilov/jsvat>
 *
 * @param $( "#tx-srfeuserregister-pi1-vat" ).val
 * @param $( "#tx-srfeuserregister-pi1-static_info_country" ).val
 * @param $( "#tx-srfeuserregister-pi1-vat" ).val
 * @constructor
 *
 */
function vatCheck() {
    let str = "";
    let vat = '';
    var vatInput = $('#tx-srfeuserregister-pi1-vat');
    vat = vat + $('#tx-srfeuserregister-pi1-vat').val();
    if (vat !== 'undefined' && vat.length > 3) {
        vat = vat.toUpperCase()
        vat = vat.replace(/[^A-Z0-9]/g, '');
        $('#tx-srfeuserregister-pi1-vat').val(vat);
        check = jsvat.checkVAT($('#tx-srfeuserregister-pi1-vat').val());
        str = $("#tx-srfeuserregister-pi1-static_info_country").val();
        if (check.isValid) {
            if(check.country.isoCode.long !== str && check.country.isoCode.short !== str) {
                $('#tx-srfeuserregister-pi1-vat').addClass('error');
                handleFlashMessage('danger', localLangInt.javaScriptPrefixVatErrorCountry, false);
            }
        } else {
            $('#tx-srfeuserregister-pi1-vat').addClass('error');
            handleFlashMessage('danger', localLangInt.javaScriptPrefixVatErrorAll, false);
        }
    } else {
        $('#tx-srfeuserregister-pi1-vat').removeClass('error');
    }
}

/**
 * Generates needed Language based Parameters for Billwerk Payment und Commit
 *
 * @param sys_language_uid
 * @constructor
 * @return string iframeLang
 * @return string parameterLang
 *
 *
 *
 */
function LanguagesIframeAndSuccess(sys_language_uid) {
    let languageParameters = {};
    switch (sys_language_uid) {
        case 1:
        case 7:
        case 13:
        case 15:
            languageParameters = {
                iframeLang: '?language=de',
                parameterLang: 'de'
            }
            break;
        case 2:
            languageParameters = {
                iframeLang: '?language=nl',
                parameterLang: 'nl'
            }
            break;
        case 4:
            languageParameters = {
                iframeLang: '?language=fr',
                parameterLang: 'fr'
            }
            break;
        case 6:
            languageParameters = {
                iframeLang: '?language=es',
                parameterLang: 'es'
            }
            break;
        case 8:
            languageParameters = {
                iframeLang: '?language=it',
                parameterLang: 'it'
            }
            break;
        case 0:
        case 3:
        case 5:
        default:
            languageParameters = {
                iframeLang: '?language=en',
                parameterLang: 'en'
            }
            break;
    }
    return languageParameters;
}

var clipboard = new ClipboardJS('.btn-copy');
clipboard.on('success', function(e) {
    e.clearSelection();
    console.info('Action:', e.action);
    console.info('Text:', e.text);
    console.info('Trigger:', e.trigger);
    handleFlashMessage('success', localLangInt.javaScriptPrefixCopySuccess, false);
});
clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
    handleFlashMessage('danger', localLangInt.javaScriptPrefixCopyError, false);
});

function checkValidForm(index) {
    var errors = 0;
    if( index > 0 ) {
        if ($(ID_EMAIL_ITEM + index).find(ID_INPUT_FIRSTNAME).val().length < 2) {
            ++errors;
            $(ID_EMAIL_ITEM + index).find(ID_INPUT_FIRSTNAME).addClass('error');
        }
        if ($(ID_EMAIL_ITEM + index).find(ID_INPUT_LASTNAME).val().length < 2) {
            ++errors;
            $(ID_EMAIL_ITEM + index).find(ID_INPUT_LASTNAME).addClass('error');
        }
        if (!isEmail($(ID_EMAIL_ITEM + index).find("input.cs_email").val())) {
            ++errors;
            $(ID_EMAIL_ITEM + index).find("input.cs_email").addClass('error');
        }
    } else {
        if ($(ID_EMAIL_ITEM).find(ID_INPUT_FIRSTNAME).val().length < 2) {
            ++errors;
            $(ID_EMAIL_ITEM).find(ID_INPUT_FIRSTNAME).addClass('error');
        }
        if ($(ID_EMAIL_ITEM).find(ID_INPUT_LASTNAME).val().length < 2) {
            ++errors;
            $(ID_EMAIL_ITEM).find(ID_INPUT_LASTNAME).addClass('error');
        }
        if (!isEmail($(ID_EMAIL_ITEM).find("input.cs_email").val())) {
            ++errors;
            $(ID_EMAIL_ITEM).find("input.cs_email").addClass('error');
        }
    }
    if(errors == 0) {
        return true;
    }
    return false;
}

function deleteItem(obj) {
    if( obj.rel === '0') {
        $(ID_EMAIL_ITEM).remove();
        $("#listItem" + obj.rel).remove();
        emailList.indexOf(obj.rel) !== -1 && emailList.splice(emailList.indexOf(obj.rel), 1)
        createOrderPreview();
    } else {
        $(ID_EMAIL_ITEM + obj.rel).remove();
        $("#listItem" + obj.rel).remove();
        emailList.indexOf(obj.rel) !== -1 && emailList.splice(emailList.indexOf(obj.rel), 1)
        createOrderPreview();
    }
    var availableEmails = $(ID_AVAILABLE_EMAILS).val();
    var orderedEmails = $(ID_EMAILLIST_LISTITEM).length;
    if(orderedEmails > 0) {
        $(ID_CARD_SUMMARY).removeClass('d-none');
        $(ID_CARD_DECK_WHATYOUGET).addClass('d-none');
        $(ID_ADD_EMAILS).removeClass("d-none");
        checkUserlimit(orderedEmails, availableEmails);
    } else {
        $(ID_CARD_SUMMARY).addClass('d-none');
        $(ID_CARD_PAYMENT_HINT).addClass('d-none');
        $(ID_CARD_DECK_WHATYOUGET).removeClass('d-none');
        $(ID_ADD_EMAILS).addClass("d-none");
        checkUserlimit(orderedEmails, availableEmails);
    }
}

function checkUserlimit(orderedEmails, availableEmails) {
    var leftemails = availableEmails - orderedEmails;
    var is_trial = $('body').data('istrial');
    $(ID_LEFT_EMAILS).text(leftemails);
    availableEmails = parseInt(availableEmails);
    if( orderedEmails === availableEmails ) {
        $("#adduserbtn,#triallimit").addClass('d-none');
        if(is_trial && is_trial != 2) {
            $("#triallimit,#triallimitalert").removeClass('d-none');
        } else {
            $("#orderlimit").removeClass('d-none');
        }
    } else {
        $("#adduserbtn").removeClass('d-none');
        $("#orderlimit").addClass('d-none');
        $("#triallimit,#triallimitalert").addClass('d-none');
    }
}

function getComponent(bw_contract_id, bw_component_id) {
    var action = 'get_components';
    $.ajax({
        url: VALUE_PHP_SCRIPT_COMPONENTS,
        beforeSend: function (xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
            bw_ComponentId: bw_component_id,
        },
        async: false,
        dataType: 'json',
        success: function (response) {
            $.each(response, function(key, val) {
                if(val['Id'] === bw_component_id) {
                    var user = val['Memo'].split(' (');
                    var alreadyChanged = user[2].slice(0,-1);
                    if(alreadyChanged === '1') {
                        $(ID_EDIT_BUTTON).prop('disabled', true);
                        $(ID_EDIT_BUTTON).prop('title', localLangInt.javaScriptPrefixAlreadyChanged);
                        $(ID_ALREADY_CHANGED).val('1');
                    } else {
                        $(ID_ALREADY_CHANGED).val('0');
                    }
                    $('#componentName').text(user[1].slice(0,-1));
                    $(ID_COMPONENT_EMAIL).text(user[0]);
                    $(ID_CURRENT_EMAIL).val(user[0]);
                    var startday = new Date(Date.parse(val['StartDate']));
                    var start_month = startday.getMonth() + 1;
                    $('#componentStart').text(startday.getDate() + '.' + start_month + '.' + startday.getFullYear() + ' ' + startday.getHours() + ':' + startday.getMinutes());
                    $(ID_COMPONENT_ID).val(val['Id']);
                    $('#componentNameInput').attr("placeholder", user[1].slice(0,-1));
                    $(ID_COMPONENT_EMAIL_INPUT).attr("placeholder", user[0]);
                    if(val['EndDate']) {
                        var endday = new Date(Date.parse(val['EndDate']));
                        var end_month = endday.getMonth() + 1;
                        $('#componentEnd').text(endday.getDate() + '.' + end_month + '.' + endday.getFullYear() + ' ' + endday.getHours() + ':' + endday.getMinutes());
                        $("#componentEndLabel").removeClass('d-none');
                        $('#cancelButton').prop('disabled', true);
                        $('#cancelButton').prop('title', localLangInt.javaScriptPrefixAlreadyCanceled);
                        $('#componentEndDate').val(val['EndDate']);
                    }
                }
            });
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_contracts', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function doModal(placementId, windowId, heading, formContent, strSubmitFunc, btnText, closeText) {
    var html =  '<div class="modal fade" id="' + windowId + '" data-backdrop="static" data-keyboard="false" tabIndex="-1" aria-labelledby="' + windowId + 'Label" aria-hidden="true">';
    html += '<div class="modal-dialog">';
    html += '<div class="modal-content">';
    html += '<div class="modal-header">';
    html += '<h5 class="modal-title" id="' + windowId + 'Label">' + heading + '</h5>';
    html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    html += '<span aria-hidden="true">&times;</span>';
    html += '</button>';
    html += '</div>';
    html += '<div class="modal-body">';
    html += formContent;
    html += '</div>';
    html += '<div class="modal-footer">';
    html += '<button type="button" class="btn btn-secondary" data-dismiss="modal">' + closeText + '</button>';
    if (btnText!='') {
        html += '<button type="button" class="btn btn-primary" onClick="' + strSubmitFunc + '">' + btnText + '</button>';
    }
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    $("#" + placementId).html(html);
    $("#" + windowId).modal();
}

function hideModal() {
    $('.modal.in').modal('hide');
    $('.modal.show').modal('hide');
}

function initUserlimit(minuslimit = 0) {
    var userlimit = 25;
    var individual_userlimit = $('body').data('individualuserlimit');
    var user_country = $('body').data('country');
    switch (user_country) {
        case 'IRL':
        case 'GBR':
        case 'NLD':
            userlimit = 50;
            break;
    }
    if (individual_userlimit !== '' && individual_userlimit !== 0) {
        userlimit = individual_userlimit;
    }
    $('#availableEmails').val(userlimit);
}

function endTrialInOrder() {
    endTrialOnFeuser('',true);
    $('body').data('istrial', 0);
    initUserlimit(1);
    $("#addbtn").trigger("click");
    $("#triallimit,#triallimitalert").addClass('d-none');
    $("#trial-hint").addClass('d-none');
    $("#order-trial-subtitle").addClass('d-none');
    var btnText = $('#addbtn').find('a.plusIcon').attr("title");
    $('#addbtn').find('a.plusIcon').html('<i class="fa fa-plus" aria-hidden="true"></i> ' + btnText);
    $(ID_ADDITIONAL_USER_HINT).text(localLangInt.javaScriptPrefixOrderAdditional);
    hideModal();
}

function endTrial(contractId = '') {
    var bw_customer_id = $('body').data('bwcustomerid');
    var action = 'get_contracts';
    $.ajax({
        url: VALUE_PHP_SCRIPT_CONTACTS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
        },
        dataType: 'json',
        success: function(response) {
            let bw_contract_id;
            let bw_planvariant_id;
            $.each(response, function(key, val) {
                if(contractId != '') {
                    if(contractId == val['Id']) {
                        bw_contract_id = response[key]['Id'];
                        bw_planvariant_id = response[key]['PlanVariantId'];
                    }
                } else {
                    bw_contract_id = response[0]['Id'];
                    bw_planvariant_id = response[0]['PlanVariantId'];
                }
            });
            if(bw_contract_id) {
                upgradeOrder('end_trial', bw_customer_id, bw_planvariant_id, bw_contract_id);
            }
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_contracts', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function upgradeOrder(action, bw_customer_id, bw_planvariant_id, bw_contract_id) {
    $.ajax({
        url: VALUE_PHP_SCRIPT_ORDERS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            bw_CustomerId: bw_customer_id,
            bw_PlanVariantId: bw_planvariant_id,
            bw_ContractId: bw_contract_id,
        },
        dataType: 'json',
        success: function(response) {
            commitUpgradeOrder(response['Id'], bw_customer_id, bw_contract_id);
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'checkIfEmailAddressIsCollectiveMailbox', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function commitUpgradeOrder(bw_order_id, bw_customer_id, bw_contract_id) {
    var action = 'commit_order_nopayment';

    function success_commit_callback(data) {
        endTrialOnFeuser(bw_contract_id);
    }
    function error_commit_callback(data) {
        logAjaxError(VALUE_AJAX_ERROR, 'commitUpgradeOrder', 'get json', data);
        handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, data);
    }
    $.ajax({
        url: VALUE_PHP_SCRIPT_ORDERS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            bw_order_id: bw_order_id,
            action: action,
            id: bw_customer_id
        },
        dataType: 'json',
        success: success_commit_callback,
        error: error_commit_callback
    });
}

function endTrialOnFeuser(bw_contract_id, in_order = false) {
    var action = 'end_trial_on_feuser';
    var addurl = $('#addurl').val();
    function success_endtrial_callback(data) {
        if(in_order) {
            return true;
        } else {
            window.location.href = addurl + '?cid=' + bw_contract_id + '&phase=Active';
        }
    }
    function error_endtrial_callback(data) {
        logAjaxError(VALUE_AJAX_ERROR, 'endTrialOnFeuser', 'get json', data);
        handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, data);
    }
    $.ajax({
        url: VALUE_PHP_SCRIPT_CUSTOMERS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
        },
        dataType: 'json',
        success: success_endtrial_callback,
        error: error_endtrial_callback
    });
}

function setCancelComponentModal(contractId, componentId, endDate, memo) {
    var header = localLangInt.javaScriptPrefixOrderTrialModalCancelHeadline;
    var content = localLangInt.javaScriptPrefixOrderTrialModalCancelText;
    var strSubmitFunc = "setCancelComponent('" + contractId + "', '" + componentId + "', '" + endDate + "', '" + memo + "')";
    var btnText = localLangInt.javaScriptPrefixOrderTrialModalCancelButton;
    var closeText = localLangInt.javaScriptPrefixOrderTrialModalCancelClose;
    doModal('idDynModal', 'cancelComponentWindow', header, content, strSubmitFunc, btnText, closeText);
}

function bwSubscriptionJS(bw_contract_id, selectedCurrentPaymentMethod = '') {
    var subscriptionJS = SubscriptionJS;
    let sys_language_uid = $('body').data('syslanguageuid');
    let publicApiKey = $('body').attr('data-bwpublicapikey');
    let languageParameters = LanguagesIframeAndSuccess(sys_language_uid);
    var parameterLang = languageParameters.parameterLang;
    let is_partner = $('body').attr('data-ispartner');
    let today = new Date();
    let current_month = today.getMonth();
    let current_year = today.getFullYear();
    var style = {
        body: {},
        label: {},
        input: {},
        inputRequired: {},
        inputInvalid: {}
    };
    var bw_customer_country = $('body').data('country');
    var paymentMethods = {};
    switch (bw_customer_country) {
        case 'GBR':
            paymentMethods = {
                sandbox: {
                    credit: STRING_CREDITCARD_FAKE_PSP
                },
                app: {
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'GBP'
            }
            break;
        case 'AUT':
        case 'DEU':
            paymentMethods = {
                sandbox: {
                    debit: STRING_DEBIT_FAKE_PSP,
                    credit: STRING_CREDITCARD_FAKE_PSP
                },
                app: {
                    debit: STRING_DEBIT_PAYONE,
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'EUR'
            }
            break;
        case 'NLD':
            paymentMethods = {
                sandbox: {
                    debit: STRING_DEBIT_FAKE_PSP,
                    credit: STRING_CREDITCARD_FAKE_PSP,
                    iDEAL: STRING_ADYEN_IDEAL
                },
                app: {
                    debit: STRING_DEBIT_PAYONE,
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'EUR'
            }
            break;
        case 'CHE':
            paymentMethods = {
                sandbox: {
                    credit: STRING_CREDITCARD_FAKE_PSP
                },
                app: {
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'CHF'
            }
            break;
        case 'USA':
            paymentMethods = {
                sandbox: {
                    credit: STRING_CREDITCARD_FAKE_PSP
                },
                app: {
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'USD'
            }
            break;
        default:
            paymentMethods = {
                sandbox: {
                    credit: STRING_CREDITCARD_FAKE_PSP
                },
                app: {
                    credit: STRING_CREDITCARD_PAYONE
                },
                currency: 'EUR'
            }
            break;
    }
    var selectedPaymentMethod;
    if(selectedCurrentPaymentMethod == '') {
        selectedPaymentMethod = paymentMethods[$('body').attr(ATTR_DATA_BW_ENVIRONMENT)][$('body').attr(ATTR_DATA_PAYMENT_METHOD)];
        if (selectedPaymentMethod === undefined || selectedPaymentMethod.length <= 1) {
            selectedPaymentMethod = paymentMethods[$('body').attr(ATTR_DATA_PAYMENT_METHOD)]['credit'];
        }
    } else {
        selectedPaymentMethod = selectedCurrentPaymentMethod;
    }
    var config = null;
    if ($('body').attr(ATTR_DATA_BW_ENVIRONMENT) !== 'app') {
        config = {
            paymentMethods: [selectedPaymentMethod],
            publicApiKey: publicApiKey,
            locale: parameterLang,
            providerReturnUrl: "https://" + $('body').attr(ATTR_DATA_BW_ENVIRONMENT) + ".billwerk.com/portal/finalize.html",
        };
    } else {
        config = {
            paymentMethods: [selectedPaymentMethod],
            publicApiKey: publicApiKey,
            locale: parameterLang,
            providerReturnUrl: "https://selfservice.billwerk.com/portal/finalize.html",
        };
    }
    var error_callback_iframe = function(data) {
        $('#loader').addClass('hidden');
    }
    var success_callback = function (data) {
        $('#loader').addClass('hidden');
        if (!data.Url) {
            let getUrl = window.location;
            let successUrl = getUrl.origin + getUrl.pathname;
            let params = window.location.search.length > 0 ? window.location.search + "&contractId=" + data .ContractId : "?contractId=" + data.ContractId;
            top.location = successUrl + params;
        } else {
            top.location = data.Url;
        }
        $('#loader').addClass('hidden');
    };
    let paymentForm;
    let currrentData = null;
    function loadContract() {
        portal.contractDetails(function (data) {
            currrentData = data;
            if(selectedCurrentPaymentMethod != '') {
                $("#payment").empty();
                paymentForm = subscriptionJS.createElement(
                    'paymentForm',
                    document.getElementById("payment"),
                    config,
                    style,
                    error_callback_iframe
                );
                paymentForm.payerDataChanged(data.Customer);
            }
            var paymentOptions = paymentMethods[$('body').attr(ATTR_DATA_BW_ENVIRONMENT)]
            var currentPayment;
            if(selectedCurrentPaymentMethod == '') {
                $.each(paymentOptions, function(key, val) {
                    if(key == $('body').attr(ATTR_DATA_PAYMENT_METHOD)) {
                        if($("#inputBillingPaymentMethod option[value='" + val + "']").length == 0) {
                            $('#inputBillingPaymentMethod').append(new Option(localLangInt['javaScriptPrefix' + key], val, true, true));
                            $('#inputBillingPaymentMethod2').append(new Option(localLangInt['javaScriptPrefix' + key], val, true, true));
                        }
                        currentPayment = val;
                    } else {
                        if($("#inputBillingPaymentMethod option[value='" + val + "']").length == 0) {
                            $('#inputBillingPaymentMethod').append(new Option(localLangInt['javaScriptPrefix' + key], val, false, true));
                            $('#inputBillingPaymentMethod2').append(new Option(localLangInt['javaScriptPrefix' + key], val, false, true));
                        }
                    }
                });
                document.getElementById("inputBillingPaymentMethod").options.selectedIndex = 0;
                document.getElementById("inputBillingPaymentMethod2").options.selectedIndex = 0;
                $("#inputBillingPaymentMethod option[value='" + currentPayment + "']").prop('selected', true);
                $("#inputBillingPaymentMethod2 option[value='" + currentPayment + "']").prop('selected', true);
            } else {
                $("#inputBillingPaymentMethod option[value='" + selectedCurrentPaymentMethod + "']").prop('selected', true);
                $("#inputBillingPaymentMethod2 option[value='" + selectedCurrentPaymentMethod + "']").prop('selected', true);
            }
            $("#customerContract").text();
            if(data.ComponentsSubscriptions.length > 0) {
                $("#inputComponentId").val((data.ComponentsSubscriptions[0].Id) ? data.ComponentsSubscriptions[0].Id : '');
            }
            if(is_partner === '0') {
                $(".noPartnerRow").remove();
            }
            $("#inputComponentEndDate").val((data.EndDateIfCancelledNow) ? data.EndDateIfCancelledNow : '');
            $("#inputContractId").val((bw_contract_id) ? bw_contract_id : '');
            $("#customerFirstName").text((data.Contract.CustomFields.CSFirstName) ? data.Contract.CustomFields.CSFirstName : '');
            $("#inputCustomerFirstName").val((data.Contract.CustomFields.CSFirstName) ? data.Contract.CustomFields.CSFirstName : '');
            $("#customerLastName").text((data.Contract.CustomFields.CSLastName) ? data.Contract.CustomFields.CSLastName : '');
            $("#inputCustomerLastName").val((data.Contract.CustomFields.CSLastName) ? data.Contract.CustomFields.CSLastName : '');
            if((data.Contract.CustomFields.CSChangedName != 0 || data.Contract.CustomFields.CSChangedName != '') && data.Contract.CustomFields.CSChangedName != undefined) {
                $("#inputCustomerFirstName").prop( "disabled", true );
                $("#inputCustomerLastName").prop( "disabled", true );
                $("#inputCustomerFirstName").next().filter('.changed-tooltip').removeClass("d-none");
                $("#inputCustomerLastName").next().filter('.changed-tooltip').removeClass("d-none");
            }
            $("#customerCompany").text((data.Contract.CustomFields.CSCompany) ? data.Contract.CustomFields.CSCompany : '');
            $("#inputCustomerCompany").val((data.Contract.CustomFields.CSCompany) ? data.Contract.CustomFields.CSCompany : '');
            $("#customerStreet").text((data.Contract.CustomFields.CSAddress) ? data.Contract.CustomFields.CSAddress : '');
            $("#inputCustomerStreet").val((data.Contract.CustomFields.CSAddress) ? data.Contract.CustomFields.CSAddress : '');
            $("#customerHouseNumber").text((data.Contract.CustomFields.CSHousenumber) ? data.Contract.CustomFields.CSHousenumber : '');
            $("#inputCustomerHouseNumber").val((data.Contract.CustomFields.CSHousenumber) ? data.Contract.CustomFields.CSHousenumber : '');
            $("#customerZip").text((data.Contract.CustomFields.CSZip) ? data.Contract.CustomFields.CSZip : '');
            $("#inputCustomerZip").val((data.Contract.CustomFields.CSZip) ? data.Contract.CustomFields.CSZip : '');
            $("#customerCity").text((data.Contract.CustomFields.CSCity) ? data.Contract.CustomFields.CSCity : '');
            $("#inputCustomerCity").val((data.Contract.CustomFields.CSCity) ? data.Contract.CustomFields.CSCity : '');
            $("#customerCountry").text((data.Contract.CustomFields.CSCountry) ? data.Contract.CustomFields.CSCountry : '');
            $("#inputCustomerCountry").val((data.Contract.CustomFields.CSCountry) ? data.Contract.CustomFields.CSCountry : '');
            $("#customerPhone").text((data.Contract.CustomFields.CSPhone) ? data.Contract.CustomFields.CSPhone : '');
            $("#inputCustomerPhone").val((data.Contract.CustomFields.CSPhone) ? data.Contract.CustomFields.CSPhone : '');
            $("#customerEmail").text((data.Contract.CustomFields.CSEmailUser) ? data.Contract.CustomFields.CSEmailUser : '');
            $("#inputCustomerEmail").val((data.Contract.CustomFields.CSEmailUser) ? data.Contract.CustomFields.CSEmailUser : '');
            if((data.Contract.CustomFields.CSChangedEmail != 0 || data.Contract.CustomFields.CSChangedEmail != '') && data.Contract.CustomFields.CSChangedEmail != undefined) {
                $("#inputCustomerEmail").prop( "disabled", true );
                $("#inputCustomerEmail").next().filter('.changed-tooltip').removeClass("d-none");
            }
            $("#customerVat").text((data.Contract.CustomFields.CSVat && data.Contract.CustomFields.CSVat != 'undefined') ? data.Contract.CustomFields.CSVat : '');
            $("#inputCustomerVat").val((data.Contract.CustomFields.CSVat && data.Contract.CustomFields.CSVat != 'undefined') ? data.Contract.CustomFields.CSVat : '');
            $("#inputChangedName").val((data.Contract.CustomFields.CSChangedName) ? data.Contract.CustomFields.CSChangedName : '');
            $("#inputChangedEmail").val((data.Contract.CustomFields.CSChangedEmail) ? data.Contract.CustomFields.CSChangedEmail : '');
            if(typeof(data.Contract.PaymentBearer) !== 'undefined' && data.Contract.PaymentBearer.Type) {
                $("#billingPaymentMethod").text(localLangInt['javaScriptPrefix' + data.Contract.PaymentBearer.Type]);
            } else {
                $("#billingPaymentMethod").text('');
            }
            $("#inputBillingPaymentMethod").val((typeof(data.Contract.PaymentBearer) !== 'undefined' && data.Contract.PaymentBearer.Type) ? data.Contract.PaymentBearer.Type : '');
            $("#inputBillingPaymentMethod2").val((typeof(data.Contract.PaymentBearer) !== 'undefined' && data.Contract.PaymentBearer.Type) ? data.Contract.PaymentBearer.Type : '');
            $("#tableBillingCardCvc").addClass('d-none');
            if(typeof(data.Contract.PaymentBearer) !== 'undefined' && data.Contract.PaymentBearer.Type == 'CreditCard') {
                $("#tableBillingAccountOwner").addClass('d-none');
                $("#tableBillingIban").addClass('d-none');
                $("#billingCardHolder").text((data.Contract.PaymentBearer.Holder) ? data.Contract.PaymentBearer.Holder : '');
                $("#inputBillingCardHolder").val((data.Contract.PaymentBearer.Holder) ? data.Contract.PaymentBearer.Holder : '');
                $("#billingCardType").text((data.Contract.PaymentBearer.CardType) ? data.Contract.PaymentBearer.CardType : '');
                $("#inputBillingCardType").val((data.Contract.PaymentBearer.CardType) ? data.Contract.PaymentBearer.CardType : '');
                $("#billingCardNumber").text((data.Contract.PaymentBearer.MaskedCardPan) ? data.Contract.PaymentBearer.MaskedCardPan : '');
                $("#inputBillingCardNumber").val('');
                $("#billingCardValidUntil").text(((data.Contract.PaymentBearer.ExpiryMonth) ? data.Contract.PaymentBearer.ExpiryMonth : '') + '/' + ((data.Contract.PaymentBearer.ExpiryYear) ? data.Contract.PaymentBearer.ExpiryYear : ''));
                $("#inputBillingCardValidUntilMonth").val((data.Contract.PaymentBearer.ExpiryMonth) ? data.Contract.PaymentBearer.ExpiryMonth : '');
                $("#inputBillingCardValidUntilYear").val((data.Contract.PaymentBearer.ExpiryYear) ? data.Contract.PaymentBearer.ExpiryYear : '');
                if(data.Contract.PaymentBearer.ExpiryYear === current_year ) {
                    if (data.Contract.PaymentBearer.ExpiryMonth > current_month && data.Contract.PaymentBearer.ExpiryMonth - current_month < 3) {
                        $("#billingCreditCardExpired").removeClass('d-none');
                    }
                }
            } else if(typeof(data.Contract.PaymentBearer) !== 'undefined') {
                $("#billingAccountOwner").text((data.Contract.PaymentBearer.Holder) ? data.Contract.PaymentBearer.Holder : '');
                $("#inputBillingAccountOwner").val((data.Contract.PaymentBearer.Holder) ? data.Contract.PaymentBearer.Holder : '');
                $("#billingIban").text((data.Contract.PaymentBearer.IBAN) ? maskCharacter(data.Contract.PaymentBearer.IBAN, '*', 4) : '');
                $("#inputBillingIban").val((data.Contract.PaymentBearer.IBAN) ? maskCharacter(data.Contract.PaymentBearer.IBAN, '*', 4) : '');
                $("#tableBillingCardHolder").addClass('d-none');
                $("#tableBillingCardType").addClass('d-none');
                $("#tableBillingCardNumber").addClass('d-none');
                $("#tableBillingCardValidUntil").addClass('d-none');
                $("#tableBillingCardCvc").addClass('d-none');
            }
            $("#subscriptionPackage").text((data.CurrentPlan.PlanName) ? data.CurrentPlan.PlanName : '');
            $('#inputBillingPaymentMethod').on('change', function() {
                switch($('#inputBillingPaymentMethod').val()) {
                    case 'Debit:FakePSP':
                    case 'Debit:PayOne':
                        $("#inputBillingAccountOwner").removeClass("d-none");
                        $("#inputBillingIban").removeClass("d-none");
                        $("#inputBillingCardHolder").addClass("d-none");
                        $("#inputBillingCardType").addClass("d-none");
                        $("#inputBillingCardNumber").addClass("d-none");
                        $("#inputBillingCardValidUntilMonth").addClass("d-none");
                        $("#inputBillingCardValidUntilYear").addClass("d-none");
                        $("#tableBillingAccountOwner").removeClass('d-none');
                        $("#tableBillingIban").removeClass('d-none');
                        $("#tableBillingCardHolder").addClass('d-none');
                        $("#tableBillingCardType").addClass('d-none');
                        $("#tableBillingCardNumber").addClass('d-none');
                        $("#tableBillingCardValidUntil").addClass('d-none');
                        $("#tableBillingCardCvc").addClass('d-none');
                        break;
                    case 'CreditCard:FakePSP':
                    case 'CreditCard:PayOne':
                        $("#inputBillingCardHolder").removeClass("d-none");
                        $("#inputBillingCardType").removeClass("d-none");
                        $("#inputBillingCardNumber").removeClass("d-none");
                        $("#inputBillingCardValidUntilMonth").removeClass("d-none");
                        $("#inputBillingCardValidUntilYear").removeClass("d-none");
                        $("#inputBillingAccountOwner").addClass("d-none");
                        $("#inputBillingIban").addClass("d-none");
                        $("#tableBillingAccountOwner").addClass('d-none');
                        $("#tableBillingIban").addClass('d-none');
                        $("#tableBillingCardHolder").removeClass('d-none');
                        $("#tableBillingCardType").addClass('d-none');
                        $("#tableBillingCardNumber").removeClass('d-none');
                        $("#tableBillingCardValidUntil").removeClass('d-none');
                        $("#tableBillingCardCvc").removeClass('d-none');
                        break;
                }
            });

            $('#inputBillingPaymentMethod2').on('change', function() {
                var iframes = document.querySelectorAll('iframe');
                for (var iframe of iframes) {
                    iframe.parentNode.removeChild(iframe);
                }
                bwSubscriptionJS(bw_contract_id, $(this).val());
                $("#payment").removeClass("d-none");
            });

            var userRow = '';
            var user = null;
            if(data.ComponentsSubscriptions.length == 0) {
                $("#component-card").addClass("d-none");
            }
            $("#email-user").empty();
            $.each(data.ComponentsSubscriptions, function(key, val) {
                user = val['Memo'].split(' (');
                var startDate = new Date(val['StartDate']);
                var alreadyChanged = user[2].slice(0,-1);
                var alertAlreadyChanged = '';
                var editUserDisable = '';
                if(alreadyChanged != '0') {
                    editUserDisable = ' disabled';
                    alertAlreadyChanged = '<button class="btn btn-link edit-disabled" type="button" data-toggle="tooltip" data-placement="top" title="" data-original-title="' + localLangInt.javaScriptPrefixTooltipAlreadyChanged + '"><i class="fa fa-exclamation-circle"></i></button>';
                }
                if(val['EndDate']) {
                    var endDate = new Date(val['EndDate']);
                    userRow = '<tr class="email-user-row"><td><strong class="email-user-name-label">' + localLangInt.javaScriptPrefixLabelEmailUserName + '&nbsp;</strong><span class="email-user-name">' + user[1].slice(0,-1) + '</span><input class="form-control input-email-user-name d-none" type="text" value="' + user[1].slice(0,-1) + '"></td><td><strong class="email-user-email-label">' + localLangInt.javaScriptPrefixLabelEmailUserEmail + '&nbsp;</strong><span class="email-user-email">' + user[0] + '</span><input class="form-control input-email-user-email d-none" type="text" value="' + user[0] + '"></td><td><strong>' + localLangInt.javaScriptPrefixLabelEmailUserStartdate + '</strong>&nbsp;<span class="email-user-startdate">' + startDate.toLocaleString(document.documentElement.lang, {day: 'numeric', year: 'numeric', month: 'long'}) + '</span></td><td class="email-user-enddate-row"><strong>' + localLangInt.javaScriptPrefixLabelEmailUserEnddate + '</strong>&nbsp;<span class="email-user-enddate">' + endDate.toLocaleString(document.documentElement.lang, {day: 'numeric', year: 'numeric', month: 'long'}) + '</span></td><td><button type="button" class="btn btn-secondary edit-customeremail"' + editUserDisable + '>' + localLangInt.javaScriptPrefixLabelEmailUserEditemailuser + '</button>' + alertAlreadyChanged + '<button type="button" class="btn btn-danger exit-customeremail d-none">' + localLangInt.javaScriptPrefixButtonCancel + '</button><button type="button" class="btn btn-success save-customeremail d-none">' + localLangInt.javaScriptPrefixButtonSave + '</button></td><td class="email-user-cancel-row"><button type="button" class="btn btn-danger cancel-customeremail" onClick="" data-toggle="modal" data-target="#cancelModal" data-memo="' + val['Memo'] + '" data-email="' + user[0] + '" data-name="' + user[1].slice(0,-1) + '" data-id="' + val['Id'] + '" disabled>' + localLangInt.javaScriptPrefixLabelEmailUserCancelemailuser + '</button> <button class="btn btn-link cancel-disabled" type="button" data-toggle="tooltip" data-placement="top" title="" data-original-title="' + localLangInt.javaScriptPrefixTooltipAlreadyCanceled + '"><i class="fa fa-exclamation-circle"></i></button></td></tr>';
                } else {
                    userRow = '<tr class="email-user-row"><td><strong class="email-user-name-label">' + localLangInt.javaScriptPrefixLabelEmailUserName + '&nbsp;</strong><span class="email-user-name">' + user[1].slice(0,-1) + '</span><input class="form-control input-email-user-name d-none" type="text" value="' + user[1].slice(0,-1) + '"></td><td><strong class="email-user-email-label">' + localLangInt.javaScriptPrefixLabelEmailUserEmail + '&nbsp;</strong><span class="email-user-email">' + user[0] + '</span><input class="form-control input-email-user-email d-none" type="text" value="' + user[0] + '"></td><td><strong>' + localLangInt.javaScriptPrefixLabelEmailUserStartdate + '</strong>&nbsp;<span class="email-user-startdate">' + startDate.toLocaleString(document.documentElement.lang, {day: 'numeric', year: 'numeric', month: 'long'}) + '</span></td><td class="email-user-enddate-row"></td><td><button type="button" class="btn btn-secondary edit-customeremail"' + editUserDisable + '>' + localLangInt.javaScriptPrefixLabelEmailUserEditemailuser + '</button>' + alertAlreadyChanged + '<button type="button" class="btn btn-danger exit-customeremail d-none">' + localLangInt.javaScriptPrefixButtonCancel + '</button><button type="button" class="btn btn-success save-customeremail d-none">' + localLangInt.javaScriptPrefixButtonSave + '</button></td><td class="email-user-cancel-row"><button type="button" class="btn btn-danger cancel-customeremail" onClick="" data-toggle="modal" data-target="#cancelModal" data-memo="' + val['Memo'] + '" data-email="' + user[0] + '" data-name="' + user[1].slice(0,-1) + '" data-id="' + val['Id'] + '">' + localLangInt.javaScriptPrefixLabelEmailUserCancelemailuser + '</button></td></tr>';
                }
                $("#email-user").append(userRow);
            });
            $('.cancel-disabled').tooltip('enable');
            $('.edit-disabled').tooltip('enable');

            var row = '';
            if(data.RecentInvoices.length == 0) {
                $("#invoices-card").addClass("d-none");
            }
            $("#invoices").empty();
            $.each(data.RecentInvoices, function(key, val) {
                let dueDate = new Date(val['DueDate']);
                let totalGross = parseFloat(val['TotalGross']);
                row = '<tr id="invoice-row"><td class="invoice-number">' + val['InvoiceNumber'] + '</td><td class="invoice-date">' + dueDate.toLocaleString(document.documentElement.lang, {day: 'numeric', year: 'numeric', month: 'long'}) + '</td><td class="invoice-amount">' + data.Contract.Currency + ' ' + totalGross.toFixed(2).replace('.', ',') + '</td><td class="invoice-download"><a href="#" onclick="createInvoiceDownloadLink(\'' + val['Id'] + '\');">' + localLangInt.javaScriptPrefixTextDownloadInvoice + '</a></td></tr>';
                $("#invoices").append(row);
            });

            $('.edit-customeremail').on('click', function() {
                $(this).closest('.email-user-row').find('[class*="email-user-name"]').addClass('d-none');
                $(this).closest('.email-user-row').find('[class*="email-user-email"]').addClass('d-none');
                $(this).closest('.email-user-row').find('[class*="email-user-name-label"]').addClass('d-none');
                $(this).closest('.email-user-row').find('[class*="email-user-email-label"]').addClass('d-none');
                $(this).closest('.email-user-row').find('[class*="input-email-user-email"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="input-email-user-name"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="exit-customeremail"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="save-customeremail"]').removeClass('d-none');
                $(this).addClass('d-none');
            });
            $('.exit-customeremail').on('click', function() {
                $(this).closest('.email-user-row').find('[class*="email-user-name"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="email-user-email"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="email-user-name-label"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="email-user-email-label"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="input-email-user-email"]').addClass('d-none');
                $(this).closest('.email-user-row').find('[class*="input-email-user-name"]').addClass('d-none');
                $(this).closest('.email-user-row').find('[class*="edit-customeremail"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="save-customeremail"]').addClass('d-none');
                $(this).addClass('d-none');
            });
            $('.save-customeremail').on('click', function() {
                $(this).closest('.email-user-row').find('[class*="email-user-name"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="email-user-email"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="email-user-name-label"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="email-user-email-label"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="input-email-user-email"]').addClass('d-none');
                $(this).closest('.email-user-row').find('[class*="input-email-user-name"]').addClass('d-none');
                $(this).closest('.email-user-row').find('[class*="edit-customeremail"]').removeClass('d-none');
                $(this).closest('.email-user-row').find('[class*="exit-customeremail"]').addClass('d-none');
                $(this).addClass('d-none');
                var bw_component_id = $(this).closest('.email-user-row').find('[class*="btn btn-danger cancel-customeremail"]').attr('data-id');
                var old_email = $(this).closest('.email-user-row').find('[class*="btn btn-danger cancel-customeremail"]').attr('data-email');
                var new_email = $(this).closest('.email-user-row').find('[class*="input-email-user-email"]').val();
                var new_name = $(this).closest('.email-user-row').find('[class*="input-email-user-name"]').val();
                var memo = new_email + ' (' + new_name + ') (1)';
                var end_date = '';
                setEditComponent(bw_contract_id, bw_component_id, end_date, memo, old_email, new_email, new_name);
            });
        }, error_callback_iframe);
    }

    $('#cancelModal').on('show.bs.modal', function (e) {
        $("#cancelComponent").attr('data-memo', $(e.relatedTarget).data('memo')).attr('data-name', $(e.relatedTarget).data('name')).attr('data-email', $(e.relatedTarget).data('email')).attr('data-id', $(e.relatedTarget).data('id'));
        $("#cancelModal .modal-body #cancel-data").html('<br /><strong>' + localLangInt.javaScriptPrefixLabelEmailUserName + '</strong>&nbsp;' + $(e.relatedTarget).data('name') + '&nbsp;<strong>' + localLangInt.javaScriptPrefixLabelEmailUserEmail + '</strong>&nbsp;' + $(e.relatedTarget).data('email') + '');
    });

    let portal;
    let action = 'get_selfservice_token';

    $.ajax({
        url: VALUE_PHP_SCRIPT_CONTACTS,
        beforeSend: function(xhr) {
            xhr.overrideMimeType(VALUE_MIMETYPE_TEXT);
        },
        type: 'get',
        data: {
            action: action,
            bw_ContractId: bw_contract_id,
        },
        dataType: 'json',
        success: function(response) {
            var token = response['Token'];
            if (token) {
                portal = new subscriptionJS.Portal(token);
                loadContract();
            } else {
                error_callback_iframe('No token');
            }

            $(function () {
                $("#edit-billingdata").unbind().click(function (ev) {
                    $("#paymentModal").modal();
                });
                $("#cancel-billingdata").unbind().click(function (ev) {
                    $(".billing-form select").val('');
                    $(".billing-form input").val('');
                    switch(currrentData.Contract.PaymentBearer.Type) {
                        case 'BankAccount':
                            $("#inputBillingCardHolder").addClass("d-none");
                            $("#inputBillingCardType").addClass("d-none");
                            $("#inputBillingCardNumber").addClass("d-none");
                            $("#inputBillingCardValidUntilMonth").addClass("d-none");
                            $("#inputBillingCardValidUntilYear").addClass("d-none");
                            $("#tableBillingCardHolder").addClass('d-none');
                            $("#tableBillingCardType").addClass('d-none');
                            $("#tableBillingCardNumber").addClass('d-none');
                            $("#tableBillingCardValidUntil").addClass('d-none');
                            $("#tableBillingCardCvc").addClass('d-none');
                            $("#tableBillingIban").removeClass('d-none');
                            $("#inputBillingAccountOwner").removeClass("d-none");
                            $("#inputBillingIban").removeClass("d-none");
                            $("#tableBillingIban").removeClass('d-none');
                            $("#tableBillingPaymentMethod").removeClass('d-none');
                            $("#tableBillingAccountOwner").removeClass("d-none");
                            $("#tableBillingIban .billing-plain").removeClass('d-none');
                            $("#tableBillingIban .billing-form").addClass('d-none');
                            $("#tableBillingPaymentMethod .billing-plain").removeClass('d-none');
                            $("#tableBillingPaymentMethod .billing-form").addClass('d-none');
                            $("#tableBillingAccountOwner .billing-plain").removeClass("d-none");
                            $("#tableBillingAccountOwner .billing-form").addClass("d-none");
                            break;
                        case 'CreditCard':
                            $("#inputBillingCardHolder").removeClass("d-none");
                            $("#inputBillingCardType").removeClass("d-none");
                            $("#inputBillingCardNumber").removeClass("d-none");
                            $("#inputBillingCardValidUntilMonth").removeClass("d-none");
                            $("#inputBillingCardValidUntilYear").removeClass("d-none");
                            $("#inputBillingAccountOwner").addClass("d-none");
                            $("#inputBillingIban").addClass("d-none");
                            $("#tableBillingAccountOwner").addClass('d-none');
                            $("#tableBillingIban").addClass('d-none');
                            $("#tableBillingCardHolder").removeClass('d-none');
                            $("#tableBillingCardType").addClass('d-none');
                            $("#tableBillingCardNumber").removeClass('d-none');
                            $("#tableBillingCardValidUntil").removeClass('d-none');
                            $("#tableBillingCardCvc").addClass('d-none');
                            $("#tableBillingCardType").removeClass("d-none");
                            $("#tableBillingPaymentMethod .billing-plain").removeClass('d-none');
                            $("#tableBillingPaymentMethod .billing-form").addClass('d-none');
                            $("#tableBillingCardHolder .billing-plain").removeClass('d-none');
                            $("#tableBillingCardHolder .billing-form").addClass('d-none');
                            $("#tableBillingCardType .billing-plain").removeClass('d-none');
                            $("#tableBillingCardType .billing-form").addClass('d-none');
                            $("#tableBillingCardNumber .billing-plain").removeClass('d-none');
                            $("#tableBillingCardNumber .billing-form").addClass('d-none');
                            $("#tableBillingCardValidUntil .billing-plain").removeClass('d-none');
                            $("#tableBillingCardValidUntil .billing-form").addClass('d-none');
                            break;
                        case 'iDEAL':
                            break;
                    }
                    $("#edit-billingdata").removeClass("d-none");
                    $("#cancel-billingdata").addClass("d-none");
                    $("#save-billingdata").addClass("d-none");
                });
                $("#save-billingdata").unbind().click(function (ev) {
                    $('#loader').removeClass('hidden');
                    if (paymentForm) {
                        var providerReturnUrl = "";
                        if ($('body').attr(ATTR_DATA_BW_ENVIRONMENT) !== 'app') {
                            providerReturnUrl = "https://" + $('body').attr(ATTR_DATA_BW_ENVIRONMENT) + ".billwerk.com/portal/finalize.html";
                        } else {
                            providerReturnUrl = "https://selfservice.billwerk.com/portal/finalize.html";
                        }
                        var paymentService = new SubscriptionJS.Payment({
                                publicApiKey: publicApiKey,
                                providerReturnUrl: providerReturnUrl
                            },
                            function (data) {
                                portal.paymentChange(null, paymentForm, success_callback, error_callback_iframe);
                            }, function (error){
                                console.log(error);
                            }
                        );
                    } else {
                        error_callback_iframe("Payment form is not loaded correctly!");
                    }
                });
            });
        },
        error: function(xhr) {
            logAjaxError(VALUE_AJAX_ERROR, 'get_selfservice_token', 'get json', xhr);
            handleFlashMessage('danger', localLangInt.javaScriptPrefixFatalError, xhr);
        }
    });
}

function handleBusinessPartnerChange(bw_customer_id,feuseremail){
	console.log('handleBusinessPartnerChange executed');

	if ($('html').attr('lang') == 'de-DE') {
		var SelectedIntegrationsHint = 'Ich interessiere mich für folgende Integrationen: ';
		var formId = 'e494f747-2698-4ec5-b200-9612ce070bd1';
	} else if ($('html').attr('lang') == 'nl-NL') {
		var SelectedIntegrationsHint = 'Ik ben geïnteresseerd in de volgende integraties: ';
		var formId = '72d9c0c2-a64d-4c47-b2cc-6e647997b2d2';
	} else {
		var SelectedIntegrationsHint = 'I am interested in the following integrations: ';
		var formId = '62bb242c-e730-4a12-b431-23ebb236c267';
	}

	hbspt.forms.create({
		region: "na1",
		portalId: "5912427",
		formId: formId,
		target: "#FormContainer",
		onFormReady: function($form){

			$form.find('input[name="email"]').val(feuseremail);
			$form.find('input[name="bw_customer_id"]').val( bw_customer_id);

		},
		onFormSubmit: function($form){
			var decision = $form.find('select[name="cryptshare_express_business_partner_change_decision"]').val();
			saveBusinessPartnerChangeDecision(decision);
		}
	});

}

$(document).ready(function() {
    let pid = parseInt($('body').data('pid'));
	let bw_customer_id = $('body').data('bwcustomerid');
	let feuseremail = $('body').data('feuseremail');
    let sys_language_uid = $('body').data('syslanguageuid');
    let cs_server_host = $('body').data('csserverhost');
    let bw_contract_id = getUrlParameter('contractId');
    let bw_planvariant_id = getUrlParameter('planVariantId');
    let bw_component_id = getUrlParameter('componentId');
    let is_partner = $('body').attr('data-ispartner');
    $('[data-localize]').each(function() {
        $(this).text(localLangInt['javaScriptPrefix' + $(this).attr('data-localize')]);
    });

	$("#GlobalHint .close").unbind().click(function (ev) {
		saveBusinessPartnerChangeDecision(1);
	});

    switch (pid) {
        case 1398:
            $("#tx-srfeuserregister-pi1-vat").change(function () {
                removeFlashMessages();
                vatCheck();
            });
            $("#tx-srfeuserregister-pi1-static_info_country").change(function () {
                removeFlashMessages();
                vatCheck();
            });
            if ($('#result').val() === 'success') {
                redirectTo($('#targeturl').val());
            }
            vatCheck();
            break;
        case 1400:
            if (bw_customer_id) {
                getContracts(bw_customer_id, sys_language_uid);
            } else {
                varMissing('bw_customer_id');
            }
            break;
        case 1403:
            if (bw_customer_id) {
                getContracts(bw_customer_id, sys_language_uid);
            } else {
                varMissing('bw_customer_id');
            }
            break;
        case 1407:
            getPricingPlanVariantForEachDiv();
            break;
        case 1414:
            getAccessToken();
            break;
        case 1415:
            if (bw_customer_id) {
                if (bw_contract_id) {
                    bwSubscriptionJS(bw_contract_id);
                    getContract(bw_customer_id, bw_contract_id, pid, true, true);
                    $('.cmold').prop('href', $('.cmold').prop('href') + '?contractId=' + bw_contract_id);
                } else {
                    varMissing('bw_contract_id');
                }
            } else {
                varMissing('bw_customer_id');
            }
            break;
        case 1416:
        case 2024:
            var xhref = $('a#SendWelcomeEmail').attr('href');
            var email_new_account = getUrlParameter('email');
            var email_account_owner = $('#accountowner').attr('data-email-accountowner');
            if (bw_contract_id) {
                if (email_new_account === email_account_owner) {
                    $('.own-email').removeClass('d-none');
                    $('.foreign-email').addClass('d-none');
                }
                $('a#SendWelcomeEmail').attr('href', xhref + STRING_URL_PARAM_CONTRACT_ID + bw_contract_id);
                getContract(bw_customer_id, bw_contract_id, pid, true, true);
            }
            break;
        case 1418:
            if (bw_customer_id) {
                getAccessToken(bw_customer_id);
            } else {
                console.log('ERROR');
                varMissing('bw_customer_id');
            }
            break;
        case 1420:
            if (bw_customer_id) {
                updateCustomerOnBw();
            } else {
                varMissing('bw_customer_id');
            }
            break;
        case 1427:
            if (bw_customer_id) {
                getContracts(bw_customer_id, sys_language_uid);
                handleOnePageOrderProcess(sys_language_uid, bw_customer_id, bw_planvariant_id);
                $('#cs_email').focusout(function () {
                    if ($('#cs_email').val().length > 2) {
                        createOrderPreview();
                    }
                });
                if ($(KEY_CS_FIRSTNAME).val().length > 2 && $(KEY_CS_LASTNAME).val().length > 2 && $('#cs_email').val().length > 2) {
                    setTimeout(function () {
                        createOrderPreview();
                    }, 1000);
                }
            } else {
                varMissing('bw_customer_id');
            }
            break;
        case 2008:
		case 2040:
			if (bw_customer_id) {
				handleBusinessPartnerChange(bw_customer_id,feuseremail);
			} else {
				varMissing('bw_customer_id');
			}
			break;
        case 1464:
            if (bw_customer_id) {
                if (bw_contract_id) {
                    getContract(bw_customer_id, bw_contract_id, pid, true, true);
                    $('.loader').hide();
                } else {
                    varMissing('bw_contract_id');
                }
            } else {
                varMissing('bw_customer_id');
            }
            break;
        case 1490:
            if (bw_customer_id) {
                getInvoices(bw_customer_id, sys_language_uid);
            } else {
                varMissing('bw_customer_id');
            }
            break;
        case 1954:
            getContracts(bw_customer_id, sys_language_uid);
            getSingleContract(bw_contract_id);
            getComponent(bw_contract_id, bw_component_id);
            break;
        case 1990:
            break;
        case 1991:
            getCustomer(getUrlParameter('cid'));
            getContracts(bw_customer_id, sys_language_uid);
            break;
        default:

    }
    setServerHostInLinks(cs_server_host);

    $('#sort-user').on('change', function() {
        var userCards;
        switch (this.value) {
            case 'date-asc':
                userCards = getSorted('.user-contract', 'timestamp', 'asc');
                break;
            case 'date-desc':
                userCards = getSorted('.user-contract', 'timestamp', 'desc');
                break;
            case 'custom-asc':
                userCards = getSorted('.user-contract', 'customer', 'asc');
                break;
            case 'custom-desc':
                userCards = getSorted('.user-contract', 'customer', 'desc');
                break;
        }
        $('#UserCards').append(userCards);
    });

    $('#edit-invoicedata').on('click', function() {
        $('.invoice-plain').addClass('d-none');
        $('.invoice-form').removeClass('d-none');
        $('#edit-invoicedata').addClass('d-none');
        $('#save-invoicedata').removeClass('d-none');
        $('#cancel-invoicedata').removeClass('d-none');
    });
    $('#cancel-invoicedata').on('click', function() {
        $('.invoice-plain').removeClass('d-none');
        $('.invoice-form').addClass('d-none');
        $('#edit-invoicedata').removeClass('d-none');
        $('#save-invoicedata').addClass('d-none');
        $('#cancel-invoicedata').addClass('d-none');
    });
    $('#save-invoicedata').on('click', function() {
        $('.invoice-plain').removeClass('d-none');
        $('.invoice-form').addClass('d-none');
        $('#edit-invoicedata').removeClass('d-none');
        $('#save-invoicedata').addClass('d-none');
        $('#cancel-invoicedata').addClass('d-none');
        let customer = {
            Id: $('#inputPartnerId').val(),
            Firstname: $('#inputPartnerFirstName').val(),
            Lastname: $('#inputPartnerLastName').val(),
            Company: $('#inputPartnerCompany').val(),
            Street: $('#inputPartnerStreet').val(),
            Housenumber: $('#inputPartnerHouseNumber').val(),
            Zip: $('#inputPartnerZip').val(),
            City: $('#inputPartnerCity').val(),
            Country: $('#inputPartnerCountry').val(),
            Phone: $('#inputPartnerPhone').val(),
            Email: $('#inputPartnerEmail').val(),
            Vat: $('#inputPartnerVat').val()
        }
        setCustomer(customer);
    });
    $('#edit-customerdata').on('click', function() {
        $('.customer-plain').addClass('d-none');
        $('.customer-form').removeClass('d-none');
        $('#edit-customerdata').addClass('d-none');
        $('#save-customerdata').removeClass('d-none');
        $('#cancel-customerdata').removeClass('d-none');
    });
    $('#cancel-customerdata').on('click', function() {
        $('.customer-plain').removeClass('d-none');
        $('.customer-form').addClass('d-none');
        $('#edit-customerdata').removeClass('d-none');
        $('#save-customerdata').addClass('d-none');
        $('#cancel-customerdata').addClass('d-none');
    });
    $('#save-customerdata').on('click', function() {
        $('.customer-plain').removeClass('d-none');
        $('.customer-form').addClass('d-none');
        $('#edit-customerdata').removeClass('d-none');
        $('#save-customerdata').addClass('d-none');
        $('#cancel-customerdata').addClass('d-none');
        var changedEmail = $("#inputChangedEmail").val();
        var changedName = $("#inputChangedName").val();
        const date = new Date();
        var dateToday = date.toLocaleString(document.documentElement.lang, {day: 'numeric', year: 'numeric', month: 'long'})
        if($('#inputCustomerEmail').val() != $('#customerEmail').text()) {
            if(changedEmail === '') {
                changedEmail = dateToday;
                removeEmailOnCryptshareServer(bw_contract_id, $('#customerEmail').text());
                addEmailOnCryptshareServerSimple(bw_contract_id, $('#inputCustomerEmail').val());
            } else {
                $('#inputCustomerEmail').val($('#customerEmail').text());
            }
        }
        if($('#inputCustomerFirstName').val() != $('#customerFirstName').text() || $('#inputCustomerLastName').val() != $('#customerLastName').text()) {
            changedName = dateToday;
        }
        customer = {
            Id: $('#inputContractId').val(),
            Firstname: $('#inputCustomerFirstName').val(),
            Lastname: $('#inputCustomerLastName').val(),
            Company: $('#inputCustomerCompany').val(),
            Street: $('#inputCustomerStreet').val(),
            Housenumber: $('#inputCustomerHouseNumber').val(),
            Zip: $('#inputCustomerZip').val(),
            City: $('#inputCustomerCity').val(),
            Country: $('#inputCustomerCountry').val(),
            Phone: $('#inputCustomerPhone').val(),
            Email: $('#inputCustomerEmail').val(),
            Vat: $('#inputCustomerVat').val(),
            ChangedName: changedName,
            ChangedEmail: changedEmail
        }
        setContractCustomer(customer);
    });
    $('#cancel-Subscription').on('click', function() {
        var header = localLangInt.javaScriptPrefixManageContractModalCancelHeadline;
        var content = localLangInt.javaScriptPrefixManageContractModalCancelText;
        var strSubmitFunc = "getCancellationPreview()";
        var btnText = localLangInt.javaScriptPrefixManageContractModalCancelButton;
        var closeText = localLangInt.javaScriptPrefixManageContractModalCancelClose;
        doModal('idDynModal', 'cancelSubscriptionWindow', header, content, strSubmitFunc, btnText, closeText);
    });
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
    var index = 0;
    var already_changed = $(ID_ALREADY_CHANGED).val();
    $('#cancelComponent').unbind().click(function (e) {
        e.preventDefault();
        let end_date;
        let memo;
        if(is_partner) {
            bw_contract_id = $("#inputContractId").val();
            bw_component_id = $(this).data('id');
            end_date = $("#inputComponentEndDate").val();
            memo = $(this).data('memo');
        } else {
            bw_contract_id = $('#contractId').val();
            bw_component_id = $(ID_COMPONENT_ID).val();
            end_date = $('#nextBillingDate').val();
            memo = $(ID_COMPONENT_EMAIL).text() + ' (' + $('#componentName').text() + ') (' + already_changed + ')';
        }
        setCancelComponent(bw_contract_id, bw_component_id, end_date, memo);
    });
    $('#formEditEmail').submit(function (e) {
        e.preventDefault();
        let new_name = $('#componentNameInput').val();
        let memo = $(ID_COMPONENT_EMAIL_INPUT).val() + ' (' + new_name + ') (1)';
        let old_email = $(ID_CURRENT_EMAIL).val();
        let new_email = $(ID_COMPONENT_EMAIL_INPUT).val();
        let end_date = $('#componentEndDate').val();
        setEditComponent(bw_contract_id, bw_component_id, end_date, memo, old_email, new_email, new_name);
    });
    $("#btnEndTrial").unbind().click(function (e) {
        e.preventDefault();
        if(checkValidForm(1)) {
            let header = localLangInt.javaScriptPrefixOrderTrialModalCancelHeadline;
            let content = '<p>' + localLangInt.javaScriptPrefixOrderTrialModalCancelText + '</p>';
            let strSubmitFunc = "endTrialInOrder()";
            let btnText = localLangInt.javaScriptPrefixOrderTrialModalCancelButton;
            let closeText = localLangInt.javaScriptPrefixOrderTrialModalCancelClose;
            doModal('idDynModal', 'endTrialWindow', header, content, strSubmitFunc, btnText, closeText);
        }
    });

    $('#addcontractbutton').unbind().click(function (e) {
        e.preventDefault();
        let errors = 0;
        $("#cs_company").removeClass('error');
        $("#cs_street").removeClass('error');
        $("#cs_housenumber").removeClass('error');
        $("#cs_zip").removeClass('error');
        $("#cs_city").removeClass('error');
        $("#cs_country").removeClass('error');
        if ($("#cs_company").val().length < 2) {
            ++errors;
            $("#cs_company").addClass('error');
        }
        if ($("#cs_street").val().length < 2) {
            ++errors;
            $("#cs_street").addClass('error');
        }
        if ($("#cs_housenumber").val().length < 1) {
            ++errors;
            $("#cs_housenumber").addClass('error');
        }
        if ($("#cs_zip").val().length < 2) {
            ++errors;
            $("#cs_zip").addClass('error');
        }
        if ($("#cs_city").val().length < 2) {
            ++errors;
            $("#cs_city").addClass('error');
        }
        if ($("#cs_country").val().length < 1) {
            ++errors;
            $("#cs_country").addClass('error');
        }
        if(errors === 0) {
            $("#user-data-card").removeClass("d-none");
            $(".plan-variant").removeClass("partner-d-none");
            $("#payment-row").removeClass("d-none");
            $("#user-contract-card").addClass("d-none");
        }
    });
    $('#addbtn').unbind().click(function () {
        var lastIndex = index;
        var lastElement = emailList[emailList.length - 1];
        if (checkValidForm(lastIndex)) {
            index++;
            emailList.push(index);
            if (lastIndex > 0) {
                $(ID_EMAIL_ITEM + lastIndex).clone().attr("id", "emailItem" + index).appendTo("#user-data-fields");
                $(ID_EMAIL_ITEM + lastIndex).addClass("added");
            } else {
                $(ID_EMAIL_ITEM).clone().attr("id", "emailItem" + index).appendTo("#user-data-fields");
                $(ID_EMAIL_ITEM).addClass("added")
            }
            $(ID_EMAIL_ITEM + index).find("a").attr("rel", index);
            $(ID_EMAIL_ITEM + index).find("input").val('');
            $(ID_EMAIL_ITEM + index).find(ID_INPUT_FIRSTNAME).attr("id", "cs_first_name" + index);
            $(ID_EMAIL_ITEM + index).find(ID_INPUT_LASTNAME).attr("id", "cs_last_name" + index);
            $(ID_EMAIL_ITEM + index).find("input.cs_email").attr("id", "cs_email" + index);
            $(ID_EMAIL_ITEM + index).show();
            if (lastIndex > 0) {
                $(ID_EMAIL_ITEM + lastIndex).hide();
            } else {
                $(ID_EMAIL_ITEM).hide();
            }

            if (lastElement > 0) {
                $("#currentEmail").val($("#cs_email" + lastElement).val());
                $("#emailList").append('<li id="listItem' + lastElement + '" class="list-group-item"><strong>'
                    + $("#cs_first_name" + lastElement).val() + ' '
                    + $("#cs_last_name" + lastElement).val()
                    + '</strong> <a class="deleteIcon pull-right text-muted" href="javascript:void(0)" rel="'
                    + lastIndex + '" onclick="deleteItem(this)" title="X">' +
                    '<i class="fa fa-trash" aria-hidden="true"></i></a>' + '<br>'
                    + $("#cs_email" + lastElement).val() + '</li>').hide().fadeIn(300);
                createOrderPreview();
            } else {
                $("#currentEmail").val($("#cs_email").val());
                $("#emailList").append('<li id="listItem' + lastElement + '" class="list-group-item"><strong>'
                    + $("#cs_first_name").val() + ' ' + $("#cs_last_name").val()
                    + '</strong> <a class="deleteIcon pull-right text-muted" href="javascript:void(0)" rel="'
                    + lastIndex + '" onclick="deleteItem(this)" title="X">' +
                    '<i class="fa fa-trash" aria-hidden="true"></i></a> ' + '<br>'
                    + $("#cs_email").val() + '</li>').hide().fadeIn(300);
                createOrderPreview();
            }
            var orderedEmails = $(ID_EMAILLIST_LISTITEM).length;
            var availableEmails = $(ID_AVAILABLE_EMAILS).val();
            checkUserlimit(orderedEmails, availableEmails);
            if (orderedEmails > 0) {
                $(ID_CARD_SUMMARY).removeClass('d-none');
                $(ID_CARD_DECK_WHATYOUGET).addClass('d-none');
                $(ID_ADD_EMAILS).removeClass("d-none");
            } else {
                $(ID_CARD_SUMMARY).addClass('d-none');
                $(ID_CARD_DECK_WHATYOUGET).removeClass('d-none');
                $(ID_ADD_EMAILS).addClass("d-none");
            }
        }
    });
    $(ID_COLLECTIVE_MAILBOX_ACKNOWLEDGED).unbind().click(function () {
        var state = jQuery(ID_COLLECTIVE_MAILBOX_ACKNOWLEDGED).prop('checked');
        if (state) {
            $(ID_COLLECTIVE_MAILBOX).addClass('d-none');
            $(ID_USER_DATA_FIELDS).removeClass('d-none');
            $('#addbtn').removeClass("disabled");
            $('#buy').prop("disabled", false);
        }
    });
    $('[data-toggle="tooltip"]').tooltip()
});
