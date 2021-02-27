import Vue from 'vue'
import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/pt-br'

Vue.use(ElementUI, { locale });
vue = new Vue({
    el: '#app',
    data: function() {
        return { 
            visible: false,
            num:0
         }
    }
});