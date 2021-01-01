<template>
  <v-card>
    <v-card-title
      >Course Content Create
      <v-spacer />
      <v-btn @click="back" small>Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="courseContent.course_id"
            label="Course ID"
            :error-messages="errors.course_id"
            disabled
          />
          <v-text-field
            v-model="courseContent.name"
            label="Name"
            :error-messages="errors.name"
          />
        </v-col>
        <v-col cols="6">
          <v-textarea
            v-model="courseContent.desc"
            label="Description"
            :error-messages="errors.desc"
          />
          <v-file-input
            v-model="courseContent.file"
            label="PDF"
            :error-messages="errors.file"
          />
        </v-col>
        <v-col cols="6">
          <v-textarea
            v-model="courseContent.content"
            label="Content"
            :error-messages="errors.content"
          />
          <v-text-field
            v-model="courseContent.url_youtube"
            label="Url Youtube"
            :error-messages="errors.url_youtube"
          />
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions>
      <v-btn block color="primary" @click="save()">Save</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import ApiService from "../../../services/api.service";
export default {
  data() {
    return {
      errors: {},
      courseContent: {},
    };
  },
  created() {
    this.courseContent.course_id = this.$route.params.course_id;
  },
  methods: {
    save() {
      this.errors = {};

      let formData = new FormData();

      for (const key in this.courseContent) {
        formData.append(key, this.courseContent[key]);
      }

      ApiService.post(`course-content`, formData).then((result) => {
        if (result.status == 200) {
          this.back();
        } else {
          this.errors = result.data.errors;
        }
      });
    },
    back() {
      this.$router.back();
    },
  },
};
</script>