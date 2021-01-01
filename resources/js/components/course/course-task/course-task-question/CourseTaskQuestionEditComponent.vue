<template>
  <v-card>
    <v-card-title>
      Course Task Question Edit: {{ courseTaskQuestion.id }}
      <v-spacer />
      <v-btn small @click="back()">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <v-textarea
            v-model="courseTaskQuestion.question"
            label="Question"
            :error-messages="errors.question"
          />
        </v-col>
        <v-col cols="6">
          <v-select
            item-text="name"
            item-value="id"
            v-model="courseTaskQuestion.question_type_id"
            :items="getOptions.question_types"
            label="Question Type"
            :error-messages="errors.question_type_id"
          />
        </v-col>
        <v-col cols="12" v-if="courseTaskQuestion.question_type_id == 1">
          <v-row v-for="(i, k) in courseTaskAnswer" :key="k">
            <v-col cols="10">
              <v-text-field
                v-model="courseTaskAnswer[k].answer"
                :label="'Answer ' + (k + 1)"
                :error-messages="errors[`answer.${k}`]"
              />
            </v-col>
            <v-col cols="2">
              <v-radio-group v-model="is_true" :error-messages="errors.is_true">
                <v-radio label="IS TRUE" :value="k"></v-radio>
              </v-radio-group>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions>
      <v-btn color="primary" block @click="save()">Save</v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import { mapGetters } from "vuex";
import ApiService from "../../../../services/api.service";

export default {
  data() {
    return {
      is_true: null,
      errors: {
        answer: {},
      },
      courseTaskQuestion: {},
      courseTaskAnswer: {},
    };
  },
  mounted() {
    ApiService.get(
      `course-task-question/${this.$route.params.course_task_question_id}/edit`
    ).then((result) => {
      this.courseTaskQuestion = result.data.data;
      this.courseTaskAnswer = result.data.data.answer;

      this.courseTaskAnswer.forEach((element, key) => {
        if (element.is_true) this.is_true = key;
      });
    });
  },
  methods: {
    back() {
      this.$router.back();
    },
    save() {
      console.log("asdf");
      ApiService.put(
        `course-task-question/${this.$route.params.course_task_question_id}`,
        {
          course_task_id: this.courseTaskQuestion.course_task_id,
          question: this.courseTaskQuestion.question,
          question_type_id: this.courseTaskQuestion.question_type_id,
          answer: this.courseTaskAnswer,
          is_true: this.is_true,
        }
      ).then((result) => {
        if (result.status == 200) {
          this.$router.back();
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