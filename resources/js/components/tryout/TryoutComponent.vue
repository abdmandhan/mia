<template>
  <v-data-table
    :headers="headers"
    :items="items"
    class="elevation-1"
    dense
    :search="search"
    :loading="loading"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Tryout Management</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-text-field v-model="search" label="Search" class="mt-5" />
        <v-btn small color="primary" class="ml-4" @click="createItem()"
          >Create Tryout</v-btn
        >

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
    <template v-slot:item.is_premium="{ item }">
      <v-chip v-if="item.is_premium" small>PREMIUM</v-chip>
      <v-chip v-else small>FREE</v-chip>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-2" @click="editItem(item)" color="primary">
        mdi-pencil
      </v-icon>
      <v-icon small @click="deleteItem(item)" color="red"> mdi-delete </v-icon>
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
    search: "",
    dialogDelete: false,
    headers: [
      { text: "ID", value: "id" },
      { text: "Name", value: "name" },
      { text: "Difficulty", value: "difficulty.name" },
      { text: "Time", value: "time" },
      { text: "Date Start", value: "date_start" },
      { text: "Date Finish", value: "date_finish" },
      { text: "Actions", value: "actions" },
    ],
    items: [],
    currentItem: {},
  }),

  watch: {
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      this.loading = true;
      ApiService.get("tryout").then((result) => {
        this.items = result.data.data;
        this.loading = false;
      });
    },

    createItem() {
      this.$router.push({ name: "tryout-management.create" });
    },

    editItem(item) {
      this.$router.push({
        name: "tryout-management.edit",
        params: { tryout_id: item.id },
      });
    },

    deleteItem(item) {
      this.currentItem = item;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      ApiService.delete(`tryout/${this.currentItem.id}`).then((result) => {
        if (result.status == 200) {
          this.initialize();
        }
      });
      this.closeDelete();
    },

    closeDelete() {
      this.currentItem = {};
      this.dialogDelete = false;
    },
  },
};
</script>