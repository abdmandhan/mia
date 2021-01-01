<template>
  <v-data-table
    :headers="headers"
    :items="items"
    sort-by="calories"
    class="elevation-1"
    dense
    :search="search"
    :loading="loading"
  >
    <template v-slot:top>
      <v-text-field v-model="search" label="Search" class="ma-5"></v-text-field>
      <v-toolbar flat>
        <v-toolbar-title>{{ cardTitle }} Management</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
              New {{ cardTitle }}
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" v-for="(header, i) in headers" :key="i">
                    <component
                      :is="header.component"
                      v-if="header.value != 'actions'"
                      v-model="form[header.value]"
                      :label="header.text"
                      v-bind:disabled="header.disabled"
                      :error-messages="errors[header.value]"
                    />
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
              <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="headline"
              >Are you sure you want to delete this item?</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete"
                >Cancel</v-btn
              >
              <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                >OK</v-btn
              >
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-2" @click="editItem(item)" color="primary">
        mdi-pencil
      </v-icon>
      <v-icon small @click="deleteItem(item)" v-if="can_delete" color="red">
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize"> Reset </v-btn>
    </template>
  </v-data-table>
</template>
<script>
import ApiService from "../../services/api.service";
export default {
  data: () => ({
    loading: true,
    form: {},
    errors: {},
    search: "",
    dialog: false,
    dialogDelete: false,
    headers: [],
    items: [],
    backEndModel: "",
    can_delete: false,
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
    cardTitle() {
      return this.upfirst(this.$route.params.model);
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
    "$route.params.model": {
      handler: function (model) {
        this.backEndModel = model;
        this.initialize();
      },
      deep: true,
      immediate: true,
    },
  },

  created() {
    this.backEndModel = this.$route.params.model;
    this.initialize();
  },

  methods: {
    upfirst(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    initialize() {
      this.loading = true;

      ApiService.get(this.backEndModel).then((result) => {
        if (result.status == 200) {
          this.headers = result.data.data.header;
          this.items = result.data.data.data;
          this.can_delete = result.data.data.config.can_delete;
          this.loading = false;
        } else {
          this.$router.push({ name: "404" });
        }
      });
    },

    editItem(item) {
      this.form = item;
      this.dialog = true;
    },

    deleteItem(item) {
      this.form = item;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      ApiService.delete(`${this.backEndModel}/${this.form.id}`).then(
        (result) => {
          this.initialize();
          this.closeDelete();
        }
      );
    },

    close() {
      this.dialog = false;
      this.form = {};
    },

    closeDelete() {
      this.dialogDelete = false;
      this.form = {};
    },

    save() {
      this.errors = {};
      ApiService.post(`${this.backEndModel}`, this.form).then((result) => {
        if (result.status == 200) {
          this.initialize();
          this.close();
        } else {
          this.errors = result.data.errors;
        }
      });
    },
  },
};
</script>