<template>
  <v-card>
    <v-card-title
      >Course Task Edit: {{ courseTask.name }}
      <v-spacer />
      <v-btn small @click="back()">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="courseTask.course_id"
            label="Course ID"
            disabled
          />
        </v-col>
        <v-col cols="6">
          <v-text-field
            v-model="courseTask.name"
            label="Name"
            :error-messages="errors.name"
          />
        </v-col>
        <v-col cols="6">
          <v-select
            item-text="name"
            item-value="id"
            v-model="courseTask.difficulty_id"
            :items="getOptions.difficulties"
            label="Difficulty"
            :error-messages="errors.difficulty_id"
          />
        </v-col>
      </v-row>
      <course-task-question-component />
    </v-card-text>
  </v-card>
</template>

<script>
import { mapGetters } from "vuex";
import ApiService from "../../../services/api.service";

export default {
  data() {
    return {
      tab: null,
      errors: {},
      courseTask: {},
    };
  },
  mounted() {
    ApiService.get(
      `course-task/${this.$route.params.course_task_id}/edit`
    ).then((result) => {
      this.courseTask = result.data.data;
    });
  },
  methods: {
    back() {
      this.$router.back();
    },
  },
  computed: {
    ...mapGetters(["getOptions"]),
  },
};
</script>