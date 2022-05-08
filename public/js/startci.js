var startci = {};
startci.prefix = 'ev';
startci.data = {};
startci.loading = false;
startci.force_update = function () {
    startci.loading = true;
    $('form,input,select,textarea,a,button').removeAttr('startci');
    startci.loading = false;
};
startci.update = function () {
    if (startci.loading) {
        return false;
    }
    startci.loading = true;
    $('form,input,select,textarea,a,button').not('[startci=true]').each(function (i, e) {
        e = $(e);
        startci.ajaxels(e);
        startci.shortcuts(e);
        e.attr('startci', 'true');
    });
    startci.loading = false;
};
startci.shortcuts = function (e) {
    var shortcut = null;
    if (shortcut = e.attr('shortcut')) {
        shortcut = shortcut.split(',');
        if (shortcut.length < 2)
            shortcut[1] = 'click';
        hotkeys.filter = function (event) {
            return true;
        };
        hotkeys(shortcut[0].replace(/[|]{1,}/g, ','), (ev) => {
            ev.preventDefault();
            e.trigger(shortcut[1]);
        });

    }
};
startci.ajaxels = function (e) {
    if (e.prop('tagName') == 'FORM')
        return false;
    var events = ['ready', 'click', 'dbclick', 'change', 'keyup', 'keydown', 'keypress', 'blur', 'focus', 'focusin', 'focusout', 'hover', 'mousedown', 'mouseup', 'mouseenter', 'mouseleave', 'mouseover', 'scroll', 'select', 'toggle'];
    for (var ev of events) {
        if (e.attr(startci.prefix + ev) == undefined)
            continue;
        var f = function (event, call) {
            if (event)
                event.preventDefault();
            if ($(call).attr(startci.prefix + 'lock') != undefined)
                $(call).prop('disabled', true);
            var html = $(call).html();
            if ($(call).attr(startci.prefix + 'lock-text'))
                $(call).html($(call).attr(startci.prefix + 'lock-text'));
            var event_name = 'ready';
            if (event)
                event_name = event.type;
            var fnc = $(call).attr(startci.prefix + event_name);
            var url = fnc;

            startci.data.vue = {};
            for (var i in window) {
                if (window[i] !== null) {
                    try {
                        if (window[i].$data !== undefined) {
                            startci.data.vue[i] = JSON.parse(JSON.stringify(window[i].$data));
                        }
                    } catch (e) {

                    } finally {

                    }
                }
            }
            $(call).parents('form').ajaxSubmit({
                url,
                data: startci.data,
                method: 'POST',
                headers: {
                    startci: true
                },
                dataType: 'script',
                success: function (response) {
                    if ($(call).attr(startci.prefix + 'lock') != undefined) {
                        $(call).prop('disabled', false);
                        $(call).html(html);
                    }
                },
                error: function (response) {
                    console.error(JSON.parse(response.responseText));
                    if ($(call).attr(startci.prefix + 'lock') != undefined) {
                        $(call).prop('disabled', false);
                        $(call).html(html);
                    }
                }
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