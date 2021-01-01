<template>
  <v-card>
    <v-card-title>
      Discussion
      <v-spacer />
      <v-btn color="primary">Create Discussion</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row class="justify-center">
        <v-col cols="8" v-for="(item, index) in discussions" :key="index">
          <discussion-card-component :item="item" v-on:success="init" />
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions class="justify-center">
      <v-pagination v-model="filter.page" :length="length" />
    </v-card-actions>
  </v-card>
</template>
<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      discussions: [],
      dialog: false,
      filter: {
        order: "desc",
        page: 1,
      },
      loading: true,
      length: 0,
      errors: [],
    };
  },
  created() {
    this.init();
  },
  watch: {
    filter: {
      handler() {
        this.loading = true;
        this.discuss = [];
        this.init();
      },
      deep: true,
    },
  },

  methods: {
    generateUrl(item) {
      return window.location.origin + "/" + item;
    },
    open(item) {
      this.is_open[item.id] = false;
      console.log("isopen", this.is_open);
    },
    close(item) {
      this.is_open[item.id] = true;
      console.log("isclone", this.is_open);
    },
    init() {
      ApiService.get("discussion", this.filter).then((result) => {
        this.discussions = result.data.data.data;
        if (this.length != result.data.data.last_page) {
          this.filter.page = 1;
        }
        this.length = result.data.data.last_page;
        this.loading = false;
      });
    },
  },
};
</script>