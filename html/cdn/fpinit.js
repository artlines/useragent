function loadScript(url, callback)
{
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

function myPrettyCode (code) {
	setTimeout(function () {
	var source = getParameterByName('utm_source');
    var term = getParameterByName('utm_term');
    var campaign = getParameterByName('utm_campaign');
    if (window.requestIdleCallback) {
        requestIdleCallback(function () {
            Fingerprint2.get(function (components) {
                var murmur = Fingerprint2.x64hash128(components.map(function (pair) { return pair.value }).join(), 31)
                console.log(murmur) // an array of components: {key: ..., value: ...}
                agent = document.createElement('input')
                agent.type = "hidden";
                agent.id = "fingerprint";
                agent.value = murmur;
                var body = document.getElementsByTagName('body')[0];
                body.appendChild(agent);
                var request = new XMLHttpRequest();
                request.open('POST', 'https://user-agent.cc//getdata', true);
                request.setRequestHeader('accept', 'application/json');
                var data = JSON.stringify({"fingerprint": murmur, 'code': code, 'action': 'Visit', 'referer': document.referrer, 'data': '', 'source': source, 'term': term, 'campaign': campaign});
                request.send(data);
            })
        })
    } else {
        setTimeout(function () {
            Fingerprint2.get(function (components) {
                var murmur = Fingerprint2.x64hash128(components.map(function (pair) { return pair.value }).join(), 31)
                console.log(murmur) // an array of components: {key: ..., value: ...}
                agent = document.createElement('input')
                agent.type = "hidden";
                agent.id = "fingerprint";
                agent.value = murmur;
                var body = document.getElementsByTagName('body')[0];
                body.appendChild(agent);
                var request = new XMLHttpRequest();
                request.open('POST', 'https://user-agent.cc/getdata', true);
                request.setRequestHeader('accept', 'application/json');
                var data = JSON.stringify({"fingerprint": murmur, 'code': code, 'action': 'Visit', 'referer': document.referrer, 'data': '', 'source': source, 'term': term, 'campaign': campaign});
                request.send(data);
            })
        }, 500)
    }
	}, 500)
};

function FpInit(code)
{
    loadScript("https://user-agent.cc/cdn/fingerprint2.js", myPrettyCode(code));
    agent = document.createElement('input')
    agent.type = "hidden";
    agent.id = "fingercode";
    agent.value = code;
    var body = document.getElementsByTagName('body')[0];
    body.appendChild(agent);
}

$(document).ready(function () {
    $("button").on('click', function(){
		var cookie = get_cookie("user_agent");
        var source = getParameterByName('utm_source');
        var term = getParameterByName('utm_term');
        var campaign = getParameterByName('utm_campaign');
		if ($(this).attr('name') == 'submit' ) {
			var form = $(this).closest('form');
			var form_data = $(form[0]).serialize();
			console.log('submit');
			console.log(form_data);
			var code = $("#fingercode").val();
			var murmur = $("#fingerprint").val();
			var request = new XMLHttpRequest();
			request.open('POST', 'https://user-agent.cc/getdata', true);
			request.setRequestHeader('accept', 'application/json');
			var data = JSON.stringify({"fingerprint": murmur, 'code': code, 'action': 'Submit', 'referer': document.referrer, 'data': form_data, 'source': source, 'term': term, 'campaign': campaign});
			request.send(data);
		}
    })
	$("input").on('click', function(){
		var cookie = get_cookie("user_agent");
        var source = getParameterByName('utm_source');
        var term = getParameterByName('utm_term');
        var campaign = getParameterByName('utm_campaign');
		if ($(this).attr('type') == 'submit' ) {
			var form = $(this).closest('form');
			var form_data = $(form[0]).serialize();
			console.log('submit');
			console.log(form_data);
			var code = $("#fingercode").val();
			var murmur = $("#fingerprint").val();
			var request = new XMLHttpRequest();
			request.open('POST', 'https://user-agent.cc/getdata', true);
			request.setRequestHeader('accept', 'application/json');
			var data = JSON.stringify({"fingerprint": murmur, 'code': code, 'action': 'Submit', 'referer': document.referrer, 'data': form_data, 'source': source, 'term': term, 'campaign': campaign});
			request.send(data);
		}
    })
});

function get_cookie ( cookie_name )
{
    var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );

    if ( results )
        return ( unescape ( results[2] ) );
    else
        return null;
}

function set_cookie ( name, value )
{
    var cookie_string = name + "=" + escape ( value );


        var expires = new Date ( date.getTime() + minutes*60000 );
        cookie_string += "; expires=" + expires.toGMTString();


    document.cookie = cookie_string;
}

function getParameterByName(name) {
    var name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
    var results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}