<template>
  <div class="container form d-flex justify-content-center gap-2 my-5">
    <form class="input-button" v-on:submit="search($event)">
      <input id="destination" type="text" class="form-control shadow-none" placeholder="Hotelaren izena" autocomplete="off" v-model="destination"/>
      <button type="button" id="search" href="/hoteles" class="btn btn-primary" v-on:click="search($event)">
        <i class="fa fa-search"></i>
        <span>Buscar</span>
      </button>
    </form>
  </div>
</template>

<script>
export default {

  mounted() {},

  data: () => ({
    destination: ""
  }),

  methods: {
    search(event) {
      event.preventDefault();
      window.location.replace("/hoteles?izena=" + this.destination)
    }
  },

};
</script>
