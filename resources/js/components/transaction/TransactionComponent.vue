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
        <v-toolbar-title>Transaction Management</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-text-field v-model="search" label="Search" class="mt-5" />
        <v-btn small color="primary" class="ml-4" @click="createItem()"
          >Create Transaction</v-btn
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
    <template v-slot:[`item.image`]="{ item }">
      <v-dialog v-model="dialogPreview[item.id]">
        <template v-slot:activator="{ on, attrs }">
          <v-img
            max-height="150"
            max-width="250"
            dark
            @click.stop="$set(dialogPreview, item.id, true)"
            :src="generateUrl(item.image)"
            :lazy-src="generateUrl('/storage/other/blur.jpg')"
          >
          </v-img>
        </template>

        <v-card>
          <v-card-title class="headline grey lighten-2">
            Bukti Transfer
          </v-card-title>

          <v-card-text>
            <v-img
              dark
              :src="generateUrl(item.image)"
              :lazy-src="generateUrl('/storage/other/blur.jpg')"
            ></v-img>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="primary"
              text
              @click.stop="$set(dialogPreview, item.id, false)"
            >
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
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
      { text: "Course", value: "course.name" },
      { text: "User", value: "user.name" },
      { text: "Status", value: "transaction_status.name" },
      { text: "Image", value: "image" },
      { text: "Amount", value: "amount" },
      { text: "Account Number", value: "account_no" },
      { text: "Account Name", value: "account_name" },
      { text: "Actions", value: "actions" },
    ],
    items: [],
    currentItem: {},
    dialogPreview: {},
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
      ApiService.get("transaction").then((result) => {
        this.items = result.data.data;
        this.loading = false;
      });
    },

    createItem() {
      this.$router.push({ name: "transaction-management.create" });
    },

    editItem(item) {
      this.$router.push({
        name: "transaction-management.edit",
        params: { transaction_id: item.id },
      });
    },

    deleteItem(item) {
      this.currentItem = item;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      ApiService.delete(`transaction/${this.currentItem.id}`).then((result) => {
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
    generateUrl(item) {
      return window.location.origin + "/" + item;
    },
  },
};
</script>