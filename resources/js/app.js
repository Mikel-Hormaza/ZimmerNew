/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

window.axios.defaults.headers.common = {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
};

window.$ = window.jQuery = require('jquery')

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('hotel-list', require('./components/hotel/ListComponent.vue').default);
Vue.component('fovoritos-list', require('./components/hotel/FavoritosComponent.vue').default);
Vue.component('hotel-details', require('./components/hotel/DetailsComponent.vue').default);
Vue.component('hotel-reserva', require('./components/hotel/ReservaComponent.vue').default);
// Vue.component('home-search', require('./components/SearchComponent.vue').default);

Vue.component('comentario', require('./components/ComentarioComponent.vue').default);
Vue.component('busqueda', require('./components/BusquedaComponent.vue').default);

var csrf_token = $('meta[name="csrf-token"]').attr('content');

/** 
 * Vue Mixings
 */

Vue.mixin({

    data: () => ({
        hoteles: [],
        ostatzeMotak: [],
        csrf: csrf_token
    }),

    methods: {
        getHoteles: function () {
            const URL = "https://opendata.euskadi.eus/contenidos/ds_recursos_turisticos/hoteles_de_euskadi/opendata/alojamientos.json";
            axios.get(URL).then((response) => {
                let data = new String(response.data).replace("jsonCallback(", "").replace(");", "");
                this.hoteles = JSON.parse(data); 
                for (let i = 0; i < this.hoteles.length; i++) {
                    this.hoteles[i].id = i;
                }
                this.ostatzeMotak = this.getOstatzeMotak();
            });
        },
        getOstatzeMotak: function () {
            return this.hoteles.map((hotel) => hotel.lodgingType).sort().reduce(function (a, b) {
                if (a.slice(-1)[0] !== b) a.push(b);
                    return a;
                }, []
            );
        },
        like(event, hotel_id, user_id) {
          $(event.target).css('transform','scale(1.5)');
          setTimeout(function() {
            $(event.target).css('transform','scale(1)');
          }, 100);
          if (event.target.classList.contains("text-secondary")) {
            event.target.classList.remove("text-secondary");
            event.target.classList.add("text-danger");
            $.ajax({
              type: "POST",
              url: "/gogokoa",
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data: { hotel_id: hotel_id, user_id, user_id }
            });
          } else if (event.target.classList.contains("text-danger")) {
            event.target.classList.remove("text-danger");
            event.target.classList.add("text-secondary");
            $.ajax({
              type: "DELETE",
              url: "/gogokoa",
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data: { hotel_id: hotel_id, user_id, user_id },
            });
          }
        },
        removeHTML(str) {
          str = str.replace(/<[^>]*>?/gm, '');
          str = str.replaceAll('&aacute ', 'á');
          str = str.replaceAll('&eacute ', 'é');
          str = str.replaceAll('&iacute ', 'í');
          str = str.replaceAll('&oacute ', 'ó');
          str = str.replaceAll('&uacute ', 'ú');
          str = str.replaceAll('&ntilde ', 'ñ');
          str = str.replaceAll('&nbsp ', ' ');
          return str;
        },
    },
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
