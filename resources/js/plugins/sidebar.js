import Vue from 'vue'

const AppPlugin = {
    install(Vue, options) {
        Vue.prototype.sidebarHelper = () => {
            $(".sidebar, .collapse-btn, .main-content").toggleClass("open");
        }
    },
}
Vue.use(AppPlugin)