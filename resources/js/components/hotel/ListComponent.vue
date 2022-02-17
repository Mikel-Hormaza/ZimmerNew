<template>
  <div>

    <div v-if="hoteles.length == 0" class="d-flex gap-3 justify-content-center align-items-center">
      <div class="spinner-border text-secondary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <span class="text-muted">Buscando hoteles</span>
    </div>

    <div>
      <div v-if="hoteles.length > 0">
        <div v-if="probintzia.length > 0">
          <h4>'{{ probintzia }}'-ko hotelak</h4>
          <p class="text-muted">{{ irazkiHotelak.length }} hotel aurkituta</p>
        </div>
        <div v-else>
          <h4>Euskadiko hotelak</h4>
          <p class="text-muted">{{ irazkiHotelak.length }} hotel aurkituta</p>
        </div>
      </div>
    </div>

    <div v-if="hoteles.length > 0" class="mb-5">
      <div class="d-flex gap-3 mt-3">
        <!-- probintzia aldagaia - bilatuProbintziarenArabera funtzioak erabiltzen du -->
          <div class="mb-3">
            <label id="Probintzia" class="d-block text-muted mb-1">Probintziak</label>
            <select v-model="probintzia" id="filtro-probintzia" class="form-select">
              <option default selected hidden value="">Aukeratu probintzia</option>
               <option value="" onClick="location.reload();">Guztiak</option>
              <option value="bizkaia">Bizkaia</option>
              <option value="gipuzkoa">Gipuzkoa</option>
              <option value="araba">Araba</option>
            </select>
          </div>
          <div class="mb-3">
            <label id="Ostatze mota" class="d-block text-muted mb-1">Motak</label>
            <select v-model="sartutakoOstatzeMota" id="filtro-tipo" class="form-select">
              <option default selected hidden value="">
                Aukeratu ostatze mota
              </option>
              <option value="" onClick="location.reload();">Guztiak</option>
              <option v-bind:value="mota" v-for="(mota, index) in ostatzeak" v-bind:key="index">
                {{ mota }}
              </option>
              
            </select>
          </div>
        </div>
        <input v-model="sartutakoIzena" id="filtro-nombre" type="text" class="form-control" placeholder="Bilatu hotelak" />
      </div>

    <div class="hoteles" id="hoteles">
      <div v-for="(hotel, index) in irazkiHotelak" v-bind:key="index" >
        <div v-if="index < limite" class="hotel shadow-sm d-lg-flex d-md-flex gap-4 align-items-center">
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

    <div v-if="hoteles.length > 0" class="container d-flex justify-content-center mt-5">
      <button v-if="this.limite != this.hotelak_count" v-on:click="pagination(limite_defecto, hotelak_count)" class="btn btn-outline-primary">
        Ikusi gehiago
      </button>
    </div>

  </div>
</template>


<script>
export default {
  mounted() {

    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get("probintzia"))
      this.probintzia = urlParams.get("probintzia").toLowerCase();
    
    if (urlParams.get("mota"))
      this.sartutakoOstatzeMota = urlParams.get("mota");

    if (urlParams.get("izena"))
      this.sartutakoIzena = urlParams.get("izena");

    var favs_json = JSON.parse(this.favs);
    for(let i = 0; i < favs_json.length; i++) {
      this.favHoteles.push(favs_json[i]["hotel_id"]);
    }

    this.getHoteles();

  },

  data: () => ({
    probintzia: "",
    sartutakoIzena: "",
    sartutakoOstatzeMota: "",
    ostatzeMotak: [],
    favHoteles: [],
    limite: 5,
    limite_defecto: 5,
    hotelak_count: 0,
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
      this.hotelak_count = bilaketarenEmaitza.length;
      return bilaketarenEmaitza;
    },
    ostatzeak() {
      return this.ostatzeMotak;
    },
    
  },

  methods: {
    pagination(limite_defecto, filters_length) {
      let next_limite = this.limite += 5;
      if (next_limite < filters_length) {
        this.limite = next_limite;
      } else {
        this.limite = filters_length;
      }
      // if (this.limite === this.limite_defecto) {
      //   if (this.limite + 5 < filters_length) {
      //     this.limite += 5;
      //   } else {
      //     this.limite = filters_length;
      //   }
      // } else {
      //   this.limite = this.limite_defecto;
      // }
      // this.limite = (this.limite === this.limite_defecto) ? filters_length : this.limite_defecto;
    },
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
    }
  },
};
</script>
