var startci = {};
startci.loading = false;
startci.update = function () {
    if (startci.loading) {
        return false;
    }
    startci.loading = true;
    $('form,input,select,textarea').not('[startci=true]').each(function (i, e) {
        e = $(e);
        startci.ajaxels(e);
        e.attr('startci', 'true');
    });
    startci.loading = false;
};
startci.ajaxels = function (e) {
    if (e.prop('tagName') == 'FORM')
        return false;
    var events = ['ready', 'click', 'dbclick', 'change', 'keyup', 'keydown', 'keypress', 'blur', 'focus', 'focusin', 'focusout', 'hover', 'mousedown', 'mouseup', 'mouseenter', 'mouseleave', 'mouseover', 'scroll', 'select', 'toggle'];
    for (var ev of events) {
        if (e.attr(ev) == undefined)
            continue;
        var f = function (event, call) {
            if (event)
                event.preventDefault();
            var url = $(this).attr('url');
            if (!url)
                url = '';
            if (!url.startsWith('http'))
                url = location.href + url;
            var event_name = 'ready';
            if (event)
                event_name = event.type;
            var fnc = $(call).attr(event_name);
            if (fnc)
                url += '/../' + fnc;
            $(call).parents('form').ajaxSubmit({
                url,
                method: 'POST',
                dataType: 'script'
            });
        };
        e.on(ev, function (event) {
            f(event, this);
        });
        if (ev == 'ready')
            f(null, e);
    }
};
startci.init = function () {
    setInterval(() => {
        startci.update();
    }, 100);
};
$(function () {
    startci.init();
});