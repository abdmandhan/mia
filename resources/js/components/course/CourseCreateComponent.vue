<template>
  <v-card>
    <v-card-title
      >Course Create
      <v-spacer />
      <v-btn small @click="back()">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="6">
          <v-text-field
            v-model="course.name"
            label="Name"
            :error-messages="errors.name"
          />

          <v-text-field
            v-model="course.price"
            label="Price"
            type="number"
            :error-messages="errors.price"
            v-bind:disabled="!course.is_premium"
          />

          <v-select
            item-text="name"
            item-value="id"
            v-model="course.grade_id"
            :items="getOptions.grades"
            label="Grade"
            :error-messages="errors.grade_id"
          />
        </v-col>
        <v-col cols="6">
          <v-select
            item-text="name"
            item-value="id"
            v-model="course.course_type_id"
            :items="getOptions.course_types"
            label="Course Type"
            :error-messages="errors.course_type_id"
          />

          <v-checkbox
            v-model="course.is_premium"
            label="Premium"
            :error-messages="errors.is_premium"
          />

          <v-textarea
            v-model="course.desc"
            label="Description"
            :error-messages="errors.desc"
          />
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions>
      <v-btn color="primary" block @click="create()">Create</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapGetters } from "vuex";
import ApiService from "../../services/api.service";

export default {
  data() {
    return {
      course: {},
      errors: {},
    };
  },
  methods: {
    back() {
      this.$router.back();
    },
    create() {
      this.errors = [];
      ApiService.post("course", this.course).then((result) => {
        if (result.status == 200) {
          this.$router.push({
            name: "course-management.edit",
            params: { course_id: result.data.data.id },
          });
        } else {
          this.errors = result.data.errors;
        }
      });
    },
  },
  computed: {
    ...mapGetters(["getOptions"]),
  },
};
</script>