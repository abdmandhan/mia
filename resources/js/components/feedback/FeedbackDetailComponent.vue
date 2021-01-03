<template>
  <v-card v-if="feedback.course">
    <v-card-title>
      Feedback User: {{ feedback.user.name }} <v-spacer />
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-simple-table class="mb-5">
        <tbody>
          <tr>
            <td>Course</td>
            <td>:</td>
            <td>{{ feedback.course.name }}</td>
          </tr>
          <tr>
            <td>Course Task</td>
            <td>:</td>
            <td>{{ feedback.course_task.name }}</td>
          </tr>
        </tbody>
      </v-simple-table>
      <v-simple-table class="elevation-1">
        <thead>
          <tr>
            <th>No</th>
            <th>Question</th>
            <th>Answer</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(a, b) in feedback.course_task.student_answer" :key="b">
            <td>{{ b + 1 }}</td>
            <td>{{ a.question.question }}</td>
            <td v-if="a.question.question_type_id == 1">
              {{ a.answer.answer }}
            </td>
            <td v-else>{{ a.answer_essay }}</td>
          </tr>
        </tbody>
      </v-simple-table>
      <v-text-field
        v-model="feedback.score"
        label="Score"
        :error-messages="errors.score"
        type="number"
      />
    </v-card-text>
    <v-card-actions>
      <v-btn color="primary" block @click="save">Save</v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      errors: {},
      feedback: {},
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      ApiService.get(`feedback/${this.$route.params.feedback_id}`).then(
        (result) => {
          this.feedback = result.data.data;
        }
      );
    },
    back() {
      this.$router.back();
    },
    save() {
      this.errors = {};
      ApiService.post("feedback", this.feedback).then((result) => {
        if (result.status == 200) {
          this.back();
        } else {
          this.errors = result.data.errors;
        }
      });
    },
  },
};
</script>