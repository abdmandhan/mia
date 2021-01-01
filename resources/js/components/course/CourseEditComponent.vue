<template>
  <v-card>
    <v-card-title>
      Course Edit: {{ course.name }}
      <v-spacer />
      <v-btn @click="back()" small>Back</v-btn>
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
      <v-tabs v-model="tab" background-color="secondary" fixed-tabs dark>
        <v-tabs-slider></v-tabs-slider>
        <v-tab href="#tab-task"> Course Task </v-tab>
        <v-tab href="#tab-content"> Course Content </v-tab>
        <v-tab href="#tab-teacher"> Course Teacher </v-tab>
      </v-tabs>

      <v-tabs-items v-model="tab">
        <v-tab-item value="tab-task">
          <course-task-component></course-task-component>
        </v-tab-item>
        <v-tab-item value="tab-content">
          <course-content-component></course-content-component>
        </v-tab-item>
        <v-tab-item value="tab-teacher">
          <course-teacher-component></course-teacher-component>
        </v-tab-item>
      </v-tabs-items>
    </v-card-text>
    <v-card-actions>
      <v-btn color="primary" block @click="save()">Save</v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import { mapGetters } from "vuex";
import ApiService from "../../services/api.service";

export default {
  data() {
    return {
      tab: null,
      errors: {},
      course: {},
    };
  },
  mounted() {
    ApiService.get(`course/${this.$route.params.course_id}`).then((result) => {
      this.course = result.data.data;
    });
  },
  methods: {
    back() {
      this.$router.back();
    },
    save() {
      console.log("save");
    },
  },
  computed: {
    ...mapGetters(["getOptions"]),
  },
};
</script>