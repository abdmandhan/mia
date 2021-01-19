<template>
  <v-card>
    <v-card-title>
      Tryout Create <v-spacer></v-spacer>
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="6">
          <v-text-field
            v-model="tryout.name"
            label="Name"
            :error-messages="errors.name"
          />
          <v-text-field
            v-model="tryout.date_start"
            label="Start Date"
            type="date"
            :error-messages="errors.date_start"
          />
          <v-text-field
            v-model="tryout.time"
            label="Time"
            type="time"
            :error-messages="errors.time"
          />
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
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions>
      <v-btn block color="primary" @click="create">Create</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapGetters } from "vuex";
import ApiService from "../../services/api.service";

export default {
  data() {
    return {
      errors: {},
      tryout: {},
    };
  },
  methods: {
    back() {
      this.$router.push({ name: "tryout-management" });
    },
    create() {
      ApiService.post("tryout", this.tryout).then((result) => {
        if (result.status == 200) {
          this.back();
        } else {
          this.errors = result.data.errors;
        }
      });
      console.log("create");
    },
  },
  computed: {
    ...mapGetters(["getOptions"]),
  },
};
</script>