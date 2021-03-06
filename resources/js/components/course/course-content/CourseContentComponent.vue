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
        <v-toolbar-title>Course Content Management</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-text-field v-model="search" label="Search" class="mt-5" />
        <v-btn small color="primary" class="ml-4" @click="createItem()"
          >Create Course Content</v-btn
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
    <template v-slot:item.file="{ item }">
      <v-btn icon :href="generateUrl(item.file)" target="_blank">
        <v-icon color="red">mdi-file-pdf</v-icon>
      </v-btn>
    </template>
    <template v-slot:item.url_youtube="{ item }">
      <v-btn icon :href="item.url_youtube" target="_blank">
        <v-icon color="red">mdi-youtube</v-icon>
      </v-btn>
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
import ApiService from "../../../services/api.service";

export default {
  data: () => ({
    loading: true,
    search: "",
    dialogDelete: false,
    headers: [
      { text: "ID", value: "id" },
      { text: "Name", value: "name" },
      { text: "Description", value: "desc" },
      { text: "File", value: "file" },
      { text: "Youtube", value: "url_youtube" },
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
      ApiService.get(`course-content/${this.$route.params.course_id}`).then(
        (result) => {
          this.items = result.data.data;
          this.loading = false;
        }
      );
    },

    createItem() {
      this.$router.push({
        name: "course-content-management.create",
        params: { course_id: this.$route.params.course_id },
      });
    },

    editItem(item) {
      this.$router.push({
        name: "course-content-management.edit",
        params: { course_content_id: item.id },
      });
    },

    deleteItem(item) {
      this.currentItem = item;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      ApiService.delete(`course-content/${this.currentItem.id}`).then(
        (result) => {
          if (result.status == 200) {
            this.initialize();
          }
        }
      );
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