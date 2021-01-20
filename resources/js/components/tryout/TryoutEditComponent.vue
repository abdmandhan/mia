<template>
  <v-card>
    <v-card-title>
      Tryout Edit: {{ tryout.name }}

      <v-spacer></v-spacer>
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="6">
          <v-text-field v-model="tryout.name" label="Name" />
          <v-text-field
            v-model="tryout.date_start"
            label="Start Date"
            type="date"
          />
          <v-text-field v-model="tryout.time" label="Time" type="time" />
        </v-col>
        <v-col cols="6">
          <v-select
            item-text="name"
            item-value="id"
            v-model="tryout.difficulty_id"
            :items="getOptions.difficulties"
            label="Difficulty"
            :error-messages="errors.difficulty_id"
          />
          <v-text-field
            v-model="tryout.date_finish"
            label="Finish Date"
            type="date"
            :error-messages="errors.date_finish"
          />

          <v-checkbox
            v-model="tryout.is_show_review"
            label="Show Review ?"
            :error-messages="errors.is_show_review"
          />
        </v-col>
      </v-row>

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
            <v-toolbar-title>Tryout Question </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-text-field v-model="search" label="Search" class="mt-5" />
            <v-btn small color="primary" class="ml-4" @click="createItem()"
              >Create Tryout Question</v-btn
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
          <v-icon small @click="deleteItem(item)" color="red">
            mdi-delete
          </v-icon>
        </template>
        <template v-slot:no-data>
          <v-btn color="primary" @click="initialize"> Reset </v-btn>
        </template>
      </v-data-table>
    </v-card-text>
    <v-card-actions>
      <v-btn block color="primary" @click="save()">Save</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapGetters } from "vuex";

import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      tryout: {},
      errors: {},
      loading: true,
      search: "",
      dialogDelete: false,
      headers: [
        { text: "ID", value: "id" },
        { text: "Question", value: "question" },
        { text: "Actions", value: "actions" },
      ],
      items: [],
      currentItem: {},
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.loading = true;

      ApiService.get(`tryout/${this.$route.params.tryout_id}`).then(
        (result) => {
          this.tryout = result.data.data;
          this.items = result.data.data.tryout_question;
          this.loading = false;
        }
      );
    },
    back() {
      this.$router.push({ name: "tryout-management" });
    },
    createItem() {
      this.$router.push({ name: "tryout-question-management.create" });
    },

    editItem(item) {
      this.$router.push({
        name: "tryout-question-management.edit",
        params: { tryout_question_id: item.id },
      });
    },

    deleteItem(item) {
      this.currentItem = item;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      ApiService.delete(`tryout-question/${this.currentItem.id}`).then(
        (result) => {
          if (result.status == 200) {
            this.init();
          }
        }
      );
      this.closeDelete();
    },

    closeDelete() {
      this.currentItem = {};
      this.dialogDelete = false;
    },
    save() {
      ApiService.post(`tryout/${this.$route.params.tryout_id}`, {
        ...this.tryout,
        _method: "PUT",
      }).then((result) => {
        if (result.status == 200) {
          this.back();
        } else {
          this.errors = result.data.errors;
        }
      });
      console.log("save");
    },
  },
  computed: {
    ...mapGetters(["getOptions"]),
  },
};
</script>