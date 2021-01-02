<template>
  <v-card>
    <v-card-title>
      Discussion
      <v-spacer />
      <v-dialog v-model="dialog" persistent max-width="600px">
        <template v-slot:activator="{ on, attrs }">
          <v-btn color="primary" dark v-bind="attrs" v-on="on">
            Create Discussion
          </v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">Create Discussion</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-textarea
                    label="Text"
                    required
                    v-model="text"
                    :error-messages="errors.text"
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialog = false">
              Close
            </v-btn>
            <v-btn color="blue darken-1" text @click="post"> Save </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card-title>
    <v-card-text>
      <v-row class="justify-center">
        <v-col cols="12" v-for="(item, index) in discussions" :key="index">
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
      text: "",
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
      this.text = "";
      this.dialog = false;

      ApiService.get("discussion", this.filter).then((result) => {
        this.discussions = result.data.data.data;
        if (this.length != result.data.data.last_page) {
          this.filter.page = 1;
        }
        this.length = result.data.data.last_page;
        this.loading = false;
      });
    },
    post() {
      ApiService.post("discussion", {
        text: this.text,
      }).then((result) => {
        if (result.status == 200) {
          this.init();
        } else {
          this.errors = result.data.errors;
        }
      });
    },
  },
};
</script>