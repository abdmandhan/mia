<template>
  <v-card>
    <v-card-title
      >Tryout Question Edit: {{ tryout_question.id }}
      <v-spacer></v-spacer>
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-textarea
        v-model="tryout_question.question"
        label="Question"
        :error-messages="errors.question"
      ></v-textarea>
      <v-row v-for="(i, k) in tryout_question_answer" :key="k">
        <v-col cols="10">
          <v-text-field
            v-model="tryout_question_answer[k].answer"
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
    </v-card-text>
    <v-card-actions>
      <v-btn @click="save" color="primary" block>Save</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import ApiService from "../../../services/api.service";
export default {
  data() {
    return {
      radioGroup: 1,
      tryout_question: {},
      tryout_question_answer: {},
      errors: {},
      is_true: null,
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      ApiService.get(
        `tryout-question/${this.$route.params.tryout_question_id}`
      ).then((result) => {
        this.tryout_question = result.data.data;
        this.tryout_question_answer = result.data.data.tryout_answer;

        this.tryout_question_answer.forEach((element, key) => {
          if (element.is_true) this.is_true = key;
        });
      });
    },
    back() {
      this.$router.back();
    },
    save() {
      this.errors = {};
      ApiService.post(
        `tryout-question/${this.$route.params.tryout_question_id}`,
        {
          ...this.tryout_question,
          answer: this.tryout_question_answer,
          is_true: this.is_true,
          _method: "PUT",
        }
      ).then((result) => {
        if (result.status == 200) {
        } else {
          this.errors = result.data.errors;
        }
      });
      console.log("save");
    },
  },
};
</script>