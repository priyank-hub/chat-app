require('./bootstrap');

// import { createApp, h } from "vue";
// import { createInertiaApp } from "@inertiajs/inertia-vue3";
// import { InertiaProgress } from "@inertiajs/progress";
// import { Link } from "@inertiajs/inertia-vue3";
 
// InertiaProgress.init();

// createInertiaApp({
//     resolve: (name) => require(`./Pages/${name}`),
//     setup({ el, App, props, plugin }) {
//         const app = createApp({ render: () => h(App, props) })
//             .use(plugin);
//             // .mount(el);

//         app.component(Link);

//         app.mount(el);
//     },
// });

// import Vue from 'vue'
// import { InertiaApp } from '@inertiajs/inertia-vue'
// import { InertiaProgress } from '@inertiajs/progress'
// import { BootstrapVue } from 'bootstrap-vue'

// // Make BootstrapVue available throughout your project
// Vue.use(BootstrapVue)

// Vue.config.productionTip = false
// InertiaProgress.init()
// Vue.use(InertiaApp)

// Vue.prototype.$route = (...args) => Route(...args).url()

// const app = document.getElementById('app')
// const pages = require.context('./', true, /\.vue$/i)
// console.log(app);
// new Vue({
//   render: (h) =>
//     h(InertiaApp, {
//       props: {
//         // initialPage: JSON.parse(app.dataset && app.dataset.page),
//         resolveComponent: (page) => pages(`./Pages/${page}.vue`).default,
//         transformProps: (props) => {
//           return {
//             ...props,
//           }
//         },
//       },
//     }),
// }).$mount(app)


import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import { BootstrapVue } from 'bootstrap-vue'

Vue.mixin({
    methods: {
        route: route
    }
});

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)

Vue.config.productionTip = false
InertiaProgress.init()

const pages = require.context('./', true, /\.vue$/i)

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        Vue.use(plugin)

        new Vue({
            render: h => h(App, props),
        }).$mount(el)
    },
})
