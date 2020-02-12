import Fingerprint2 from 'fingerprintjs2';

window.FpInit = function (site_key) {

    var url      = window.location.href;
    var allWhatsAppLinks = [];
    var whatsAppLink = '';
    var apiData = {
        fingerprint:    '',
        code:           site_key,
        action:         '',
        referer:        document.referrer,
        data:           {},
        phone:          '',
        wa:             '',
        source:         getParameterByName('utm_source'),
        medium:         getParameterByName('utm_medium'),
        campaign:       getParameterByName('utm_campaign'),
        content:        getParameterByName('utm_content'),
        term:           getParameterByName('utm_term'),
        block:          getParameterByName('block'),
        pos:            getParameterByName('pos'),
        yclid:          getParameterByName('yclid'),
        gclid:          getParameterByName('gclid'),
        fbclid:         getParameterByName('fbclid'),
        url:            url
    };

    /**
     *
     * @param action - Действие
     * @param fingerprint - Fingerprint
     * @param formData - Данные формы
     * @param phone - Телефон
     * @param wa - WhatsApp ссылка
     */
    function sendRequestGetData(action, fingerprint, formData, phone, wa) {
        apiData.action = action;
        apiData.fingerprint = fingerprint;
        apiData.data = (formData ? formData : {});
        apiData.phone = (phone ? phone : '');
        apiData.wa = (wa ? wa : '');
        jQuery.ajax('https://8997e6d8.ngrok.io/api/getdata', { /* https://user-agent.cc/api/getdata */
            type: 'POST',
            data: apiData,
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        }).done(function (data) {
            if (apiData.action === 'Visit' && data.hasOwnProperty('status') && data.status === 'ok' && data.hasOwnProperty('id') &&
                allWhatsAppLinks.length > 0 && data.hasOwnProperty('wid') && data.wid > 0)
            {
                for (var i = 0; i < allWhatsAppLinks.length; i++)
                {
                    var linkEl = allWhatsAppLinks[i],
                        textPos = linkEl.href.toLowerCase().indexOf('text=');
                    if (textPos > -1)
                    {
                        var text = linkEl.href.substr(textPos + 5),
                            posAmpersand = text.indexOf('&');
                        if (posAmpersand > -1)
                            text = text.substr(0, posAmpersand);
                        var newText = text + '%20%23' + data.id;
                        linkEl.setAttribute('href', linkEl.href.replace(text, newText));
                    }
                }
            }
        });
    }

    // внедрение сторонних скриптов
    function loadScript(url, callback) {
        // Добавляем тег сценария в head – как и предлагалось выше
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = url;
        // Затем связываем событие и функцию обратного вызова.
        // Для поддержки большинства обозревателей используется несколько событий.
        script.onreadystatechange = callback;
        script.onload = callback;

        // Начинаем загрузку
        head.appendChild(script);
    }

    // парсим гет запросы
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
        var results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    // получаем принт(получает только один раз, через коллбэк, дальше только возвращает)
    function getFingerprint(callback) {
        function _getFingerprint()
        {
            Fingerprint2.get(
                {
                    excludes: {
                        'enumerateDevices': true,
                        'pixelRatio':       true,
                        'doNotTrack':       true,
                        'fontsFlash':       true,
                        'deviceMemory':     true
                    }
                },
                function (components)
                {
                    var murmur = Fingerprint2.x64hash128(components.map(function (pair) { return pair.value }).join(), 31);
                    //console.log(components, murmur);
                    getFingerprint = () => murmur;
                    callback(murmur);
                });
        }
        if (window.requestIdleCallback)
            requestIdleCallback(_getFingerprint);
        else
            setTimeout(_getFingerprint, 500);
    }

    // отправляется один раз
    function requestInit(fingerprint) {
        sendRequestGetData('Visit', fingerprint);
    }

    function requestSubmit(formData) {
        sendRequestGetData('Submit', getFingerprint(), formData);
    }

    function requestFormFirstChange (formData) {
        sendRequestGetData('FormFirstChange', getFingerprint(), formData);
    }

    function requestClickPhoneLink(phone) {
        sendRequestGetData('ClickPhoneLink', getFingerprint(), {}, phone);
    }

    function requestClickWhatsAppLink(wa) {
        sendRequestGetData('ClickWhatsAppLink', getFingerprint(), {}, '', wa);
    }

    // обработчик формы
    function submitHandler(e) {
        var $el  = jQuery(this);
        var type = $el.attr('type');
        if ((typeof type === 'string' && type.toLowerCase() === 'submit')) {
            var form = $el.closest('form');
            if (form.length === 0)
                return;
            if (form.find('[type=password]').length)
                return;
            var form_data = form.serialize();
            requestSubmit(form_data);
        }
    }

    // ставим обработчики на формы
    function initForm() {
        jQuery('button, input').click(submitHandler);// поменять на тайп сабмит?????????
        jQuery('form').each(function (i, el) {
            // действие при первом изменении формы, стреляет один раз
            var inputCB = function(){
                inputCB = function(){};
                requestFormFirstChange($.param(data, true));
            };
            var $el    = jQuery(el);
            var action = $el.attr('action');
            var name   = $el.attr('name');
            
            var data = {};

            if (typeof action === 'string')
                if (action.length === 0)
                    action = './';
            else
                action = './';
            data.action = action;
            if (typeof name === 'string')
                data.name = name;

            $el.find('input, textarea').each(function (i, input) {
                var $input = jQuery(input);
                var focus  = false;
                $input.focusin(function () { focus = true; });
                $input.on('input', function () {
                    if (focus)
                        inputCB();
                });
            });
        });
        var allLinks = jQuery('a');
        allLinks.each(function (i, el) {
            if (el && el.href)
            {
                var href = el.href.toLowerCase();
                if (href.indexOf('tel:') > -1)
                    jQuery(el).on('click', onClickPhoneLink);
                else if ((href.indexOf('//wa.me/') > -1) || (href.indexOf('//api.whatsapp.com/') > -1))
                {
                    allWhatsAppLinks.push(el);
                    jQuery(el).on('click', onClickWhatsAppLink);
                }
            }
        })
    }

    function onClickPhoneLink(e) {
        var href = e.target.href;
        if ((typeof href === 'string') && href.length > 0)
        {
            try
            {
                var phone = href.substr(4).trim().replace(/\s?/, '');
                if (phone.length > 0)
                    requestClickPhoneLink(phone);
            }
            catch (err)
            {
                console.error('Parse phone error: ', err);
            }
        }
    }

    function onClickWhatsAppLink(e) {
        var href = e.target.href;
        if ((typeof href === 'string') && href.length > 0)
        {
            try
            {
                requestClickWhatsAppLink(href);
            }
            catch (err)
            {
                console.error('Send WA link: ', err);
            }
        }
    }

    getFingerprint(function (fingerprint) {
        function ifJQuery() {
            requestInit(fingerprint);
            initForm();
        }
        // проверяем наличие jquery
        if(typeof jQuery === 'undefined')
            loadScript('https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', ifJQuery);
        else
            ifJQuery();
    });
};