<template>
  <v-card>
    <v-card-title>
      Tryout Question Create
      <v-spacer />
      <v-btn small @click="back()">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <v-textarea
            v-model="tryoutQuestion.question"
            label="Question"
            :error-messages="errors.question"
          />
        </v-col>
        <v-col cols="12">
          <v-row v-for="i in 4" :key="i">
            <v-col cols="10">
              <v-text-field
                v-model="tryoutAnswer[i - 1]"
                :label="'Answer ' + i"
                :error-messages="errors[`answer.${i - 1}`]"
              />
            </v-col>
            <v-col cols="2">
              <v-radio-group v-model="is_true" :error-messages="errors.is_true">
                <v-radio label="IS TRUE" :value="i"></v-radio>
              </v-radio-group>
            </v-col>
          </v-row>
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
      is_true: null,
      errors: {
        answer: {},
      },
      tryoutQuestion: {},
      tryoutAnswer: {},
    };
  },
  methods: {
    back() {
      this.$router.back();
    },
    create() {
      this.errors = {};
      ApiService.post("tryout-question", {
        tryout_id: this.$route.params.tryout_id,
        question: this.tryoutQuestion.question,
        answer: this.tryoutAnswer,
        is_true: this.is_true,
      }).then((result) => {
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