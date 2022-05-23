<template>
  <div class="container">

    <div v-if="hotel == null" class="d-flex gap-3 justify-content-center align-items-center">
      <div class="spinner-border text-secondary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <span class="text-muted">Cargando datos del hotel</span>
    </div>

    <div v-else class="hotel d-lg-flex gap-5">
      <div class="d-flex flex-column gap-3 align-items-center">
         <div>
          <span v-if="hotel.lodgingType==='Hoteles'">  
          <img :src="'/img/hotel.jpg'" style="max-width: 25rem !important;">
          </span>
          <span v-if="hotel.lodgingType==='Pensiones'">
            <img :src="'/img/pennsion.jpg'" style="max-width: 25rem !important;">
          </span>
          <span v-if="hotel.lodgingType==='Apartamentos'">
            <img :src="'/img/APARTAMENTO.jpg'" style="max-width: 25rem !important;">
          </span>
          <span v-if="hotel.lodgingType==='Hotel-Apartamento'">
            <img :src="'/img/apartahotel.jpg'" style="max-width: 25rem !important;">
          </span>
        </div>
        <iframe v-bind:src="'https://maps.google.com/?q='+hotel.latwgs84+','+hotel.lonwgs84+'&output=embed'" style="width: 25rem; border:0;" allowfullscreen="" loading="lazy" class="m-0 p-0"></iframe>
      </div>
      <div>
        <div class="d-flex justify-content-between mt-lg-4 mt-md-4 mt-4">
          <span class="title">{{ hotel.documentName }}</span>
          <i v-if="fav" v-on:click="like($event, hotel.id, user_id)" class="fa fa-heart fs-4 text-danger"></i>
          <i v-else v-on:click="like($event, hotel.id, user_id)" class="fa fa-heart fs-4 text-secondary"></i>
        </div>

        <!-- Calendar -->
        <div class=" col-lg-8 control-section daterangeformat">
          <div class="content-wrapper">
            <div class="content">
                <!-- <div id="control_wrapper" class="control_wrapper datarangepicker_format">
                  <input type="text" name="daterange" value="" v-if="!isHidden"/>
                </div> -->
            </div>
          </div>
        </div>
        <!--  -->
        <span class="text-muted d-block mb-2">
          {{ hotel.municipality }}, {{ hotel.territory }}
        </span>
        <span v-if="hotel.address.length" class="text-muted d-block mb-2">
          {{ hotel.address }}
        </span>
        
        <span class="text-muted d-block mb-2">
          <div id="map_canvas"></div>
        </span>
        
        <p>{{ removeHTML(hotel.turismDescription) }}</p>
        <div v-if="hotel.web" class="d-flex align-items-center gap-2 mb-2">
          <i class="fa fa-globe text-muted fs-5"></i>
          <a v-bind:href="hotel.web">Pagina web</a>
        </div>
        <div v-if="hotel.tourismEmail" class="d-flex align-items-center gap-2">
          <i class="fa fa-envelope text-muted fs-5"></i>
          <a v-bind:href="'mailto:' + hotel.tourismEmail">Correo electronico</a>
        </div>  
      </div>
    </div>

  </div>

</template>

<script>
import Vue from "vue";
import { DateRangePickerPlugin } from "@syncfusion/ej2-vue-calendars";
// import $ from "./node_modules/jquery/jquery.js";

Vue.use(DateRangePickerPlugin);
// Vue.use(RadioButtonPlugin);

// $(function calendar() {
//     isHidden = !isHidden;
//     $('input[name="daterange"]').daterangepicker({
//       opens: 'left'
//     }, function(start, end, label) {
//       console.log ("Fecha inicio: " + start.format('YYYY-MM-DD'));
//       console.log ("Fecha fin: " + end.format('YYYY-MM-DD'));
//       // console.log (end);
//       // alert ("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
//     });
// });

  export default {

    mounted() {
      this.getHotel();
    },

    props: ["id", "user_id", "fav"],

    data:function() {
      return {
        waterMarkText: "Select a Range",
        dateFormat: "dd/MMM/yy",
        startValue: new Date(new Date().setDate(3)),
        endValue: new Date(new Date().setDate(28)),
        separate: "-"
      }
    },

    data: () => ({
      hotel: null,
      likes: [],
      destination: "",
      isHidden: false,

    }),

    computed: {

      filteredHoteles() {
        if (this.destination.length > 0) {
          return this.hoteles.filter(hotel => {
            return hotel.municipality.toLowerCase().includes(this.destination)
              || hotel.locality.toLowerCase().includes(this.destination)
              || hotel.territory.toLowerCase().includes(this.destination);
          });
        } else {
          return this.hoteles;
        }
      }
      
    },

    methods: {

      getHotel() {
        const URL = "https://opendata.euskadi.eus/contenidos/ds_recursos_turisticos/hoteles_de_euskadi/opendata/alojamientos.json";
        axios.get(URL).then((response) => {
          let data = new String(response.data).replace("jsonCallback(", "").replace(");", "");
          this.hotel = JSON.parse(data)[this.id];
          this.hotel.id = this.id;
        });
      },

      

    }

  };

</script>
