<template>
  <v-card>
    <v-card-title
      >Course Task Create
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
    </v-card-text>
    <v-card-actions>
      <v-btn color="primary" block @click="create()">Create</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapGetters } from "vuex";
import ApiService from "../../../services/api.service";

export default {
  data() {
    return {
      errors: {},
      courseTask: {},
    };
  },
  mounted() {
    this.courseTask.course_id = this.$route.params.course_id;
  },
  methods: {
    back() {
      this.$router.back();
    },
    create() {
      this.errors = [];
      ApiService.post("course-task", this.courseTask).then((result) => {
        if (result.status == 200) {
          this.$router.push({
            name: "course-task-management.edit",
            params: { course_task_id: result.data.data.id },
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