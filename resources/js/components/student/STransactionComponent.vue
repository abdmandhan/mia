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
        <v-toolbar-title>Transaction</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-text-field v-model="search" label="Search" class="mt-5" />
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-2" @click="editItem(item)" color="primary">
        mdi-eye
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
    search: "",
    headers: [
      { text: "ID", value: "id" },
      { text: "Course", value: "course.name" },
      { text: "Transaction Status", value: "transaction_status.name" },
      { text: "Transaction Date", value: "transaction_date" },
      { text: "Actions", value: "actions" },
    ],
    items: [],
    currentItem: {},
  }),

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      this.loading = true;
      ApiService.get("s-transaction").then((result) => {
        this.items = result.data.data;
        this.loading = false;
      });
    },

    editItem(item) {
      this.$router.push({
        name: "s-transaction.detail",
        params: { transaction_id: item.id },
      });
    },
  },
};
</script>