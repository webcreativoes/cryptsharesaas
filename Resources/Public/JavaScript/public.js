const STRING_FLASH_MESSAGE_BUTTON = '<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="">';
const ID_FLASH_MESSAGE = '.flash-messages';
const ID_HELLO_TEXT = '#HelloText';
const ID_SRFEUSERREGISTER_FE_USERS_FORM = 'form#tx-srfeuserregister-pi1-fe_users_form';
const ID_FORM_USER = 'form.form-user';
const ID_SRFEUSERREGISTER_VAT_PUB = '#tx-srfeuserregister-pi1-vat';
const ID_SRFEUSERREGISTER_COUNTRY = "#tx-srfeuserregister-pi1-static_info_country";
const ID_SRFEUSERREGISTER_ZONE = "#tx-srfeuserregister-pi1-zone";
const ID_ROBO_BLOCK = '#RoboBlock';
const ID_SRFEUSERREGISTER_USERNAME = '#tx-srfeuserregister-pi1-username';
const ID_LINK_HREFLANG_LT = 'link[hreflang=lt]';
const FUNCTION_HANDLE_ROBO_BLOCK = "handleRoboBlock(timeStart);";
const ATTR_DATA_ACTION = 'data-action';
const ATTR_DATA_METHOD = 'data-method';

let timeStart = new Date().getTime();
let localLang = TYPO3.lang;

function handleFlashMessage(mode, message, xhr) {
    let icon = '';
    if (xhr) {
        if (message) {
            message = xhr.status + ' - ' + xhr.statusText + '<br>' + message;
        } else {
            message = xhr.status + ' - ' + xhr.statusText;
        }
    }
    if (mode === 'success') {
        icon = 'check';
    } else if (mode === 'danger') {
        icon = 'warning';
    }
    $('#FlashMessages').append(
        '<div id="FlashMessageSuccess" class="alert alert-'
        + mode + ' flash-messages" data-alert="alert" role="alert">' +
        STRING_FLASH_MESSAGE_BUTTON +
        '<span aria-hidden="true">&times;</span>' +
        '</button><span class="text"><i class="fa fa-' + icon + '"></i> ' + message + '</span></div>'
    );
    $(ID_FLASH_MESSAGE).fadeIn();
}

function handleLocationMessage(alternateLink, location_key, lang, website_country) {
    let hint = localLang.javaScriptPrefixLocationidentBrowserlanguageP1 + ' <strong>'
        + localLang['javaScriptPrefix' + location_key] + '</strong> '
        + localLang.javaScriptPrefixLocationidentBrowserlanguageP2 + '.<br>'
        + localLang.javaScriptPrefixLocationidentBrowserlanguageP3 + ' <strong>'
        + website_country + '</strong>' + '.<br><strong><a href=\"'
        + alternateLink + '\">' + localLang.javaScriptPrefixLocationidentBrowserlanguageP4 + '</a></strong> '
        + localLang.javaScriptPrefixLocationidentBrowserlanguageP5 + '.';
    $('body').prepend(
        '<div id="LocationHint" class="alert alert-info" data-alert="alert" role="alert">' +
        '<i class="fa fa-4x pull-left fa-globe"></i>' +
        STRING_FLASH_MESSAGE_BUTTON +
        '<span aria-hidden="true">&times;</span></button> <span class="text">' + hint + '</span></div>'
    );
    $(ID_FLASH_MESSAGE).fadeIn();
}

function removeFlashMessages() {
    $(ID_FLASH_MESSAGE).addClass('d-none');
}

function handleSandBoxMessage(env) {
    $('body').prepend(
        '<div id="Environment" class="alert alert-warning" data-alert="alert" role="alert">' +
        '<i class="fa fa-warning"></i>' +
        STRING_FLASH_MESSAGE_BUTTON +
        '<span aria-hidden="true">&times;</span></button> <span class="text">' + env + '</span></div>'
    );
    $(ID_FLASH_MESSAGE).show();
}

function handleGlobalHint(hint) {
    $('body').prepend(
        '<div id="GlobalHint" class="alert alert-warning" data-alert="alert" role="alert">' +
        '<i class="fa fa-4x pull-left fa-wrench"></i>' +
        STRING_FLASH_MESSAGE_BUTTON +
        '<span aria-hidden="true">&times;</span></button> <span class="text">' + hint + '</span></div>'
    );
    $(ID_FLASH_MESSAGE).show();
}

function isEmail(email) {
    let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function getUrlParameter(sParam) {
    let sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
    return false;
}

function sayHello() {
    let myDate = new Date();
    let myHour = myDate.getHours();
    let forceHour = getUrlParameter('forceHour');
    if (forceHour) {
        myHour = forceHour;
    }
    let q1 = 6;
    let q2 = 12;
    let q3 = 13;
    let q4 = 17;
    let q5 = 22;
    if (myHour >= q1 && myHour < q2) {
        $(ID_HELLO_TEXT).text(localLang.javaScriptPrefixHelloQ1);
        $('body').addClass('daytime-q1');
    } else if (myHour >= q2 && myHour < q3) {
        $(ID_HELLO_TEXT).text(localLang.javaScriptPrefixHelloQ2);
        $('body').addClass('daytime-q2');
    } else if (myHour >= q3 && myHour < q4) {
        $(ID_HELLO_TEXT).text(localLang.javaScriptPrefixHelloQ3);
        $('body').addClass('daytime-q3');
    } else if (myHour >= q4 && myHour < q5) {
        $(ID_HELLO_TEXT).text(localLang.javaScriptPrefixHelloQ4);
        $('body').addClass('daytime-q4');
    } else {
        $(ID_HELLO_TEXT).text(localLang.javaScriptPrefixHelloQ5);
        $('body').addClass('daytime-q5');
    }
}

function ucwords(input) {
    return input.charAt(0).toUpperCase() + input.substr(1).toLowerCase();
}

/**
 * Evaluation of the values entered in the Signupform
 *
 * * Last Change 2019-05-13 (Check if Unsupported States in the US are selected) & Vat Formvalue Fix
 *
 * return : changes Classes
 *
 */
function evalSignupForm() {
    if ($('body').attr('data-pid') === '1398') {
        $(ID_SRFEUSERREGISTER_FE_USERS_FORM).prop('action', '');
        $(ID_FORM_USER).prop('method', '');
    }
    //console.log('evalSignupForm executed');
    $('form#tx-srfeuserregister-pi1-fe_users_form input').removeClass('error');
    let error = 0;
    var vat = $('#tx-srfeuserregister-pi1-vat').val();
    var isRobot = $('#tx-srfeuserregister-pi1-isrobot').val();
    var businessConfirmed = $('#tx-srfeuserregister-pi1-business_confirmed').prop('checked');
    var termsAccepted = $('#tx-srfeuserregister-pi1-terms_acknowledged').prop('checked');
    if (!businessConfirmed || !termsAccepted || isRobot === 'true') {
        ++error;
    }
    var country = $(ID_SRFEUSERREGISTER_COUNTRY).val();
    var zone = $(ID_SRFEUSERREGISTER_ZONE).val();
    if (country === 'USA' && (zone === 'WA' || zone === 'PA')) {
        handleFlashMessage('danger', 'Sorry our Product is not available in the states Washington and Pennsylvania', false);
        ++error;
    }
    if (vat.length > 0) {
        vat = vat.toUpperCase()
        vat = vat.replace(/[^A-Z0-9]/g, '');
        $('#tx-srfeuserregister-pi1-vat').val(vat);
        check = jsvat.checkVAT(vat);
        var str = $("#country").val();
        if(str === 'undefined' || str === undefined) {
            str = $("#tx-srfeuserregister-pi1-static_info_country").val();
        }
        if ($(str).length <= 1) { str = $(ID_SRFEUSERREGISTER_COUNTRY).val(); }
        if (check.isValid) {
            if (check.country.isoCode.short == str || check.country.isoCode.long == str) {
            } else {
                handleFlashMessage('danger', localLang.javaScriptPrefixVatErrorCountry, false);
            }
        } else {
            $('#vat').addClass('error');
            handleFlashMessage('danger', localLang.javaScriptPrefixVatErrorAll, false);
        }
    } else {
        $('#vat').removeClass('error');
    }
    //console.log('evalErrors: ' + error);
    if (error === 0) {
        $(ID_SRFEUSERREGISTER_FE_USERS_FORM).prop('action', $(ID_SRFEUSERREGISTER_FE_USERS_FORM).attr(ATTR_DATA_ACTION));
        $(ID_SRFEUSERREGISTER_FE_USERS_FORM).prop('method', $(ID_SRFEUSERREGISTER_FE_USERS_FORM).attr(ATTR_DATA_METHOD));
    }
}

function handleCustomerSignup() {
    $(ID_SRFEUSERREGISTER_FE_USERS_FORM).submit(function(e) {
        if (!$(ID_SRFEUSERREGISTER_FE_USERS_FORM).hasClass('preview')) {
            evalSignupForm();
        }
    });
}

/**
 * Checks if User seems to be human
 *
 * * Last Change 2019-05-13 (Rewrite form value with Normalisation to prevent BW Error)
 *
 */
function handleRoboBlock() {
    let data_pid = parseInt($('body').attr('data-pid'));
    if ((data_pid === 1115 || data_pid === 1425) && $('#tx_felogin_pi1-forgot-email').length > 0) {
        $(ID_ROBO_BLOCK).fadeOut();
        $(ID_ROBO_BLOCK).after('<button class="btn btn-lg btn-block" type="submit">' + localLang.javaScriptPrefixResetPasswordButton + '</button>');
        $(ID_ROBO_BLOCK).remove();
        $(ID_FORM_USER).prop('action', $(ID_FORM_USER).attr(ATTR_DATA_ACTION));
        $(ID_FORM_USER).prop('method', $(ID_FORM_USER).attr(ATTR_DATA_METHOD));
    } else if (data_pid === 1115 || data_pid === 1425) {
        $(ID_ROBO_BLOCK).fadeOut();
        $(ID_ROBO_BLOCK).after('<button class="btn btn-lg btn-block" type="submit">' + localLang.javaScriptPrefixLoginButton + '</button>');
        $(ID_ROBO_BLOCK).remove();
        $(ID_FORM_USER).prop('action', $(ID_FORM_USER).attr(ATTR_DATA_ACTION));
        $(ID_FORM_USER).prop('method', $(ID_FORM_USER).attr(ATTR_DATA_METHOD));
    } else {
        $(ID_ROBO_BLOCK).html(
            '<div class="captcha"><img src="/typo3conf/ext/cryptsharesaas/Resources/Public/Images/404-robot.png">' +
            '<div class="btn btn-lg btn-block">' +
            '<input type="checkbox" required="1" class="form-check-input" id="notarobot" name="notarobot">' +
            '<label for="notarobot">' + localLang.javaScriptPrefixRegistrationNotARobot + '</label></div></div>'
        );
        $('#tx-srfeuserregister-pi1-fe_users_form input').focus(function() {
            ++top.atLeastOneFocus;
            $('#RoboBlock button').prop('disabled', false);
        });
        $('#notarobot').click(function() {
            notARobotClick(top);
        });
    }
}

function notARobotClick(top) {
    let error = 0;
    let username = $(ID_SRFEUSERREGISTER_USERNAME).val();
    let timediff = Math.round((new Date().getTime() - timeStart) / 1000);
    $('.invalid-feedback, #tx-srfeuserregister-pi1-isrobot').remove();
    let country = $(ID_SRFEUSERREGISTER_COUNTRY).val();
    let zone = $(ID_SRFEUSERREGISTER_ZONE).val();
    if (country === 'USA' && (zone === 'WA' || zone === 'PA')) {
        handleFlashMessage('danger', 'Sorry our Product is not available in the States Washington and Pennsylvania', false);
        ++error;
    }
    //console.log(timediff);
    //console.log(username.length);
    //console.log(top.atLeastOneFocus);
    if (timediff < 3 || username.length > 0 || top.atLeastOneFocus < 2) {
        ++error;
    }
    if (error === 0) {
        $(ID_ROBO_BLOCK).fadeOut();
        $(ID_ROBO_BLOCK).after(
            '<button class="btn btn-lg btn-primary btn-block" id="tx_srfeuserregister_pi1[submit]" ' +
            'name="tx_srfeuserregister_pi1[submit]" type="submit">'
            + localLang.javaScriptPrefixRegistrationSignupButton + '</button>'
        );
        $(ID_ROBO_BLOCK).remove();
        $(ID_SRFEUSERREGISTER_USERNAME).after('<input type="hidden" id="tx-srfeuserregister-pi1-isrobot" name="tx_srfeuserregister_pi1[isrobot]" value="false">');
    } else {
        handleFlashMessage('danger', localLang.javaScriptPrefixRegistrationRoboDetected, false);
        $('#RoboBlock img').attr('src', '/typo3conf/ext/cryptsharesaas/Resources/Public/Images/robot-detected.gif');
        $('#RoboBlock .btn magick').text(localLang.javaScriptPrefixRegistrationNotARobotReally);
        $('#RoboBlock .btn input[type=checkbox]').prop('checked', false);
        $(ID_SRFEUSERREGISTER_USERNAME).after('<input type="hidden" id="tx-srfeuserregister-pi1-isrobot" name="tx_srfeuserregister_pi1[isrobot]" value="true">');
    }
}

/**
 * Checks if selected Formvalues show unsuported States in the US (WA - Washington & PA - Pensilvanya)
 *
 * * Last Change 2019-05-13 Create
 *
 */
function countryCheckSignIn() {
    //console.log('country?');
    let country = $(ID_SRFEUSERREGISTER_COUNTRY).val();
    if (country === 'USA') {
        let zone = $(ID_SRFEUSERREGISTER_ZONE).val();
        if (zone === 'WA' || zone === 'PA') {
            handleFlashMessage('danger', 'Sorry our Product is not available in the States Washington and Pennsylvania', false);
        }
    }
}

/**
 * Checks if selected Formvalues show unsuported States in the US (WA - Washington & PA - Pensilvanya)
 *
 * * Last Change 2019-05-13 (Rewrite form value with Normalisation to prevent BW Error)
 *
 */
function vatChecksignIn() {
    let vat = '';
    vat = vat + $('#tx-srfeuserregister-pi1-vat').val();
    if (vat.length > 0) {
        vat = vat.toUpperCase()
        vat = vat.replace(/[^A-Z0-9]/g, '');
        $('#tx-srfeuserregister-pi1-vat').val(vat);
        check = jsvat.checkVAT(vat);
        let str = $(ID_SRFEUSERREGISTER_COUNTRY).val();
        $('#tx-srfeuserregister-pi1-vat').removeClass('error');
        if (check.isValid) {
            if (check.country.isoCode.long !== str) {
                $('#tx-srfeuserregister-pi1-vat').addClass('error');
                handleFlashMessage('danger', localLang.javaScriptPrefixVatErrorCountry, false);
            }
        } else {
            $('#tx-srfeuserregister-pi1-vat').addClass('error');
            handleFlashMessage('danger', localLang.javaScriptPrefixVatErrorAll, false);
        }
    } else {
        $('#tx-srfeuserregister-pi1-vat').removeClass('error');
    }
}

function scrollSmooth() {
    $('.container-fluid a[target!="_blank"]').on('click', function(e) {
        if (this.hash !== "") {
            e.preventDefault();
            let hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function() {
                window.location.hash = hash;
            });
        }
    });
}

function sizeHomeGradient() {
    if ($(window).width() < 768) {
        let windowHeight = $(window).innerHeight();
        let navbarHeight = $('.navbar-light').height();
        let GradientHeight = windowHeight - navbarHeight;
        $('.layout-col-bg-gradient').css('height', GradientHeight);
    } else {
        $('.layout-col-bg-gradient').css('height', 'auto');
    }
}

function getLocallangID(browser_language) {
    switch (browser_language) {
        case 'de':
            return 1;
        case 'nl':
            return 2;
        case 'en-us':
            return 3;
        case 'fr':
            return 4;
        case 'en-gb':
            return 5;
        case 'es':
            return 6;
        case 'de-ch':
            return 7;
        case 'it':
            return 8;
        case 'fi':
            return 9;
        default:
            return 0;
    }
}

function getWebsiteCountry(website_language, localLang) {
    switch (website_language) {
        case 'de':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageGermany;
        case 'de-de':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageGermany;
        case 'nl':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageNetherland;
        case 'nl-nl':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageNetherland;
        case 'en-us':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageUsa;
        case 'en-gb':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageGreatbritain;
        case 'fr-fr':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageFrance;
        case 'es':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageSpain;
        case 'es-es':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageSpain;
        case 'de-ch':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageSwitzerland;
        case 'it-it':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageItaly;
        case 'fi':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageFinland;
        case 'fi-fi':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageFinland;
        case 'pt-pt':
            return localLang.javaScriptPrefixLocationidentBrowserlanguagePortugal;
        case 'lb':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageLuxembourg;
        case 'lt-lt':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageLithuania;
        case 'ga':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageIreland;
        case 'ga-ga':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageIreland;
        case 'el':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageGreek;
        case 'el-el':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageGreek;
        case 'nl-be':
            return localLang.javaScriptPrefixLocationidentBrowserlanguageBelgium;
        default:
            return localLang.javaScriptPrefixLocationidentBrowserlanguageOthereuropean;
    }

}

function setLocationMessage(response, localLang, website_country) {
    let alternateLink;
    let message = {
        'de': function () {
            alternateLink = $('link[hreflang=de-DE]').prop('href');
            if (response['website_language'] !== 'de-de') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-germany', localLang, website_country);
            }
        },
        'nl':  function () {
            alternateLink = $('link[hreflang=nl-NL]').prop('href');
            if (response['website_language'] !== 'nl-nl') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-netherland', localLang, website_country);
            }
        },
        'us':  function () {
            alternateLink = $('link[hreflang=en-US]').prop('href');
            if (response['website_language'] !== 'en-us') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-usa', localLang, website_country);
            }
        },
        'gb':  function () {
            alternateLink = $('link[hreflang=en-GB]').prop('href');
            if (response['website_language'] !== 'en-gb') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-greatbritain', localLang, website_country);
            }
        },
        'fr':  function () {
            alternateLink = $('link[hreflang=fr-FR]').prop('href');
            if (response['website_language'] !== 'fr-fr') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-france', localLang, website_country);
            }
        },
        'es':  function () {
            alternateLink = $('link[hreflang=es-ES]').prop('href');
            if (response['website_language'] !== 'es-es') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-spain', localLang, website_country);
            }
        },
        'ch':  function () {
            alternateLink = $('link[hreflang=de-CH]').prop('href');
            if (response['website_language'] !== 'de-ch') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-switzerland', localLang, website_country);
            }
        },
        'it':  function () {
            alternateLink = $('link[hreflang=it-IT]').prop('href');
            if (response['website_language'] !== 'it-it') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-italy', localLang, website_country);
            }
        },
        'fi':  function () {
            alternateLink = $('link[hreflang=fi-FI]').prop('href');
            if (response['website_language'] !== 'fi-fi') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-finland', localLang, website_country);
            }
        },
        'be':  function () {
            alternateLink = $('link[hreflang=nl-BE]').prop('href');
            if (response['website_language'] !== 'be-be') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-belgium', localLang, website_country);
            }
        },
        'ie':  function () {
            alternateLink = $('link[hreflang=ga-GA]').prop('href');
            if (response['website_language'] !== 'ga-ga') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-ireland', localLang, website_country);
            }
        },
        'pt':  function () {
            alternateLink = $('link[hreflang=pt-PT]').prop('href');
            if (response['website_language'] !== 'pt-pt') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-portugal', localLang, website_country);
            }
        },
        'gr':  function () {
            alternateLink = $('link[hreflang=el-EL]').prop('href');
            if (response['website_language'] !== 'el-el') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-greek', localLang, website_country);
            }
        },
        'lu':  function () {
            alternateLink = $('link[hreflang=lb]').prop('href');
            if (response['website_language'] !== 'lb') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-luxembourg', localLang, website_country);
            }
        },
        'at':  function () {
            alternateLink = $('link[hreflang=de-AT]').prop('href');
            if (response['website_language'] !== 'de-at') {
                handleLocationMessage(alternateLink, 'locationident-browserlanguage-austria', localLang, website_country);
            }
        },
        'lv':  function () {
            setLTMessage(localLang);
        },
        'lt': function () {
            setLTMessage(localLang);
        },
        'et': function () {
            setLTMessage(localLang);
        }
    };
    message[response['user_country']]();
}

function setLTMessage(localLang) {
    let alternateLink = $(ID_LINK_HREFLANG_LT).prop('href');
    if (response['website_language'] !== 'lt-lt') {
        handleLocationMessage(alternateLink, 'locationident-browserlanguage-lithuania', localLang);
    }
}

function handleLocationHelper(sys_language_uid, currentLang) {
    let action = 'get_location';
    let localLang = '';
    let website_country = '';
    $.ajax({
        url: '/typo3conf/ext/cryptsharesaas/Classes/locationhelper.php',
        beforeSend: function(xhr) {
            xhr.overrideMimeType("text/plain; charset=UTF-8");
        },
        type: 'get',
        data: {
            action: action,
            website_lang: currentLang
        },
        dataType: 'json',
        success: function(response) {
            if (response['browser_language'] && response['browser_language'].length > 0) {
                localLang = getLocallangID(response['browser_language']);
            }
            if (response['website_language'] && response['website_language'].length > 0) {
                website_country = getWebsiteCountry(response['website_language'], localLang);
            }
            if (response['user_country'] && response['user_country'].length > 0) {
                setLocationMessage(response, localLang, website_country);
            }
        },
        error: function(xhr) {
            console.info(xhr);
        }
    });
}

/**
 * Initial Function
 *
 * * Last Change 2019-05-13 (Added CountrycheckSignin)
 *
 * * Last Change 2019-05-20 (Added CountrycheckSignin) deactivated CountrycheckSignin via Comment
 */
$(document).ready(function() {
    let pid = $('body').attr('data-pid');
    let currentLang = $('html').attr('lang');
    let sys_language_uid = $('body').attr('data-syslanguageuid');
    let env = $('body').attr('data-bwenvironment');
    let globalhint = '';
    cLang = $('body').attr('data-syslanguageuid');
    globalhint = $('#hint').attr('data-hint');
    //handleLocationHelper(sys_language_uid, currentLang);

    $('#registration-business-confirmation').html(localLang.javaScriptPrefixBusinessConfirmation);

    if ($('#SuccessMessage').length > 0) {
        handleFlashMessage('success', $('#SuccessMessage').text(), false);
    }
    if (env === 'sandbox') {
        handleSandBoxMessage(env);
    }
    if (globalhint && globalhint.length > 1) {
        handleGlobalHint(globalhint);
    }
    switch (pid) {
        case '1':
            sayHello();
            sizeHomeGradient();
            $('.navbar-toggler').click(function(e) {
                $('.navbar.fixed-top').toggleClass('bg-dark');
            });
            break;
        case '1396':
            if (navigator.userAgent.indexOf('Safari') !== -1 && navigator.userAgent.indexOf('Chrome') === -1) { $('body').addClass('safari'); }
            $("#tx-srfeuserregister-pi1-vat").blur(function() {
                removeFlashMessages();
                vatChecksignIn();
            });
            $(ID_SRFEUSERREGISTER_COUNTRY).change(function() {
                removeFlashMessages();
                vatChecksignIn();
            });
            $(ID_SRFEUSERREGISTER_ZONE).change(function() {
                removeFlashMessages();
            });
            handleCustomerSignup();
            let pathArray = window.location.pathname.split('/');
            let newPathname = "";
            for (i = 0; i < pathArray.length; i++) {
                if(i > 1) {
                    if(i > 2) {
                        newPathname += "/";
                    }
                    newPathname += pathArray[i];
                }
            }
            if(newPathname === 'sign-up/trial/1') {
                $("#tx-srfeuserregister-pi1-trial").val('1');
                $("#trail-headline").text(localLang.javaScriptPrefixTrialFromHeadline);
                $("#trail-headline").removeClass('d-none');
            }
            window.setTimeout(FUNCTION_HANDLE_ROBO_BLOCK, 5000);
            break;
        case '1398':
            if (navigator.userAgent.indexOf('Safari') !== -1 && navigator.userAgent.indexOf('Chrome') === -1) { $('body').addClass('safari'); }
            handleCustomerSignup();
            break;
        case '1115':
            window.setTimeout(FUNCTION_HANDLE_ROBO_BLOCK, 2500);
            break;
        case '1425':
            window.setTimeout(FUNCTION_HANDLE_ROBO_BLOCK, 2500);
            break;
    }
    if ($('#ErrorMessage').length > 0) {
        handleFlashMessage('danger', $('#ErrorMessage').text(), false);
    }
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
    });
    scrollSmooth();
    $('body').lightGallery({
        selector: '.galleryitem'
    });
});

$(window).resize(function() {
    sizeHomeGradient();
});

$(window).scroll(function() {
    let MyOffset = window.pageYOffset;
    if (MyOffset > 25) {
        if (!$('body').hasClass('scrolled')) {
            $('body').addClass('scrolled');
        }
    } else {
        if ($('body').hasClass('scrolled')) {
            $('body').removeClass('scrolled');
        }
    }
});
