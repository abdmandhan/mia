<template>
  <v-card>
    <v-card-title
      >Course Teacher Create
      <v-spacer />
      <v-btn small @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="courseTeacher.course_id"
            label="Course ID"
            :error-messages="errors.course_id"
            disabled
          />
        </v-col>
        <v-col cols="12">
          <v-select
            item-text="name"
            item-value="id"
            v-model="courseTeacher.teacher_id"
            :items="getOptions.teachers"
            label="Teacher"
            :error-messages="errors.teacher_id"
          />
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions>
      <v-btn color="primary" block @click="save">Create</v-btn>
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
      courseTeacher: {},
    };
  },
  created() {
    this.courseTeacher.course_id = this.$route.params.course_id;
  },
  methods: {
    back() {
      this.$router.back();
    },
    save() {
      this.errors = {};
      ApiService.post(`course-teacher`, this.courseTeacher).then((result) => {
        if (result.status == 200) {
          this.back();
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