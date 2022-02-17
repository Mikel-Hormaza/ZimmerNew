<template>
    <div>

      <div v-if="hoteles.length == 0" class="d-flex gap-3 justify-content-center align-items-center" >
        <div class="spinner-border text-secondary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span class="text-muted">Buscando hoteles</span>
      </div>

    <div v-if="hoteles.length > 0" class="mb-4">
        <h4>Zure hotel gogokoenak</h4>
    </div>

    <div v-if="irazkiHotelak == 0">
      <p class="text-muted"></p>
    </div>

     <div class="hoteles" id="hoteles">
      <div v-for="(hotel, index) in irazkiHotelak" v-bind:key="index" >
        <div v-if="favsContains(hotel.id)" class="hotel shadow-sm d-flex gap-4 align-items-center">
           <div class="mb-lg-0 mb-3">
            <span v-if="hotel.lodgingType==='Hoteles'">  
            <img :src="'/img/hotel.jpg'" style="max-width: 10rem !important;">
            </span>
            <span v-if="hotel.lodgingType==='Pensiones'">
              <img :src="'/img/pennsion.jpg'" style="max-width: 10rem !important;">
            </span>
            <span v-if="hotel.lodgingType==='Apartamentos'">
              <img :src="'/img/APARTAMENTO.jpg'" style="max-width: 10rem !important;">
            </span>
            <span v-if="hotel.lodgingType==='Hotel-Apartamento'">
              <img :src="'/img/apartahotel.jpg'" style="max-width: 10rem !important;">
            </span>
          </div>
          <div class="w-100">
            <div class="d-flex justify-content-between">
              <span class="title">
                <a v-bind:href="'/hoteles/' + hotel.id">{{ hotel.documentName }}</a>
              </span>
              <!-- <i v-if="favsContains(hotel.id)" v-on:click="like($event, hotel.id, user_id)" class="fa fa-heart fs-4 text-danger"></i> -->
              <!-- <i v-else v-on:click="like($event, hotel.id, user_id)" class="fa fa-heart fs-4 text-secondary"></i> -->
            </div>
            <span class="text-muted fw-normal">{{ hotel.lodgingType }}</span>
            <span class="text-muted d-block mb-2">
              {{ hotel.municipality }}, {{ hotel.territory }}, {{ hotel.country }}
            </span>
            <p v-html="truncate(removeHTML(hotel.turismDescription))"></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get("probintzia"))
      this.probintzia = urlParams.get("probintzia").toLowerCase();
    

          const urlParamsII = new URLSearchParams(window.location.search);
    if (urlParamsII.get("favHoteles"))
      this.favHoteles = urlParamsII.get("favHoteles");

    var favs_json = JSON.parse(this.favs);
    for(let i = 0; i < favs_json.length; i++) {
      this.favHoteles.push(favs_json[i]["hotel_id"]);
    }
    
    this.getHoteles();
  },

  data: () => ({
    title: "Hoteles de euskadi",
    hoteles: [],
    likes: [],
    probintzia: "",
    sartutakoIzena: "",
    sartutakoOstatzeMota: "",
    hoteles: [],
    ostatzeMotak: [],
    favHoteles: []
  }),

    props: ["favs", "user_id"],

  computed: {
        /* hotelak filtratzen ditu izena, probintzia eta ostatze motaren arabera
    return bilaketa betetzen duten hotelak */
    irazkiHotelak() {
      let bilaketarenEmaitza = this.bilatuIzenarenArabera();
      if (this.probintzia.length > 0) {
        bilaketarenEmaitza =
          this.bilatuProbintziarenArabera(bilaketarenEmaitza);
      }
      if (this.sartutakoOstatzeMota.length > 0) {
        bilaketarenEmaitza =
          this.bilatuOstatzeMotarenArabera(bilaketarenEmaitza);
      }
      return bilaketarenEmaitza;
    },
    ostatzeak() {
      return this.ostatzeMotak;
    },
  },

  methods: {
    truncate(descripcion) {
      if (descripcion.length > 100) {
        return descripcion.substring(0, 100) + "...";
      } else {
        return descripcion;
      }
    },
        /* inputean sartutako izena hartu, 
    hotelen array-a filtratu eta return izena duten hotelen array-a */
    bilatuIzenarenArabera() {
      return this.hoteles.filter((hotel) =>
        hotel.documentName
          .toLowerCase()
          .includes(this.sartutakoIzena.toLowerCase())
      );
    },
    /* aukeratutako probintzia hartu, 
    array-a jaso parametro bezala eta filtratu probintziaren arabera.
    Return probintzia duten hotelen array-a */
    bilatuProbintziarenArabera(arrayDeResultadosRecibidos) {
      return arrayDeResultadosRecibidos.filter((hotel) =>
        hotel.territory.toLowerCase().includes(this.probintzia.toLowerCase())
      );
    },
    /* aukeratutako ostatze mota hartu, 
    array-a jaso parametro bezala eta filtratu motaren arabera.
    Return ostatze mota duten hotelen array-a */
    bilatuOstatzeMotarenArabera(arrayDeResultadosRecibidos) {
      return arrayDeResultadosRecibidos.filter((hotel) =>
        hotel.lodgingType.includes(this.sartutakoOstatzeMota)
      );
    },
    
     favsContains(hotel_id) {
      let result = this.favHoteles.includes(hotel_id);
      // console.log(result, hotel_id);
      return result;
    },
    favsContains(hotel_id) {
      let result = this.favHoteles.includes(hotel_id);
      return result;
    }
  },
};
</script>