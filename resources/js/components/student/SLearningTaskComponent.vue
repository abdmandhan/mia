<template>
  <v-card>
    <v-card-title
      >Learning Task: {{ task.name }}
      <v-spacer />
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-card
          v-for="(item, i) in task.course_task_question"
          :key="i"
          class="mb-5"
        >
          <v-card-title>{{ i + 1 }}. {{ item.question }}</v-card-title>
          <v-card-text>
            <v-radio-group
              v-model="answer[item.id]"
              v-if="item.question_type_id == 1"
            >
              <v-radio
                v-for="(ans, j) in item.answer"
                :key="j"
                :label="ans.answer"
                :value="ans.id"
                color="success"
              ></v-radio>
            </v-radio-group>
            <v-textarea v-else v-model="answer[item.id]"> </v-textarea>
          </v-card-text>
        </v-card>
      </v-row>
      <v-row v-if="!loading">
        <v-col cols="12" class="text-right">
          <v-dialog v-model="dialog" persistent max-width="500">
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                block
                color="primary"
                v-bind="attrs"
                v-on="on"
                @click="openDialog()"
              >
                Kumpulkan Tugas
              </v-btn>
            </template>
            <v-card>
              <v-card-title class="headline"> Review </v-card-title>
              <v-card-text>
                <div v-for="(a, b) in answer" :key="b">
                  <span v-if="b != 0">
                    {{ b }}.
                    <span v-if="!a">
                      <v-chip color="red" small>Not Answered</v-chip>
                    </span>
                    <span v-else>
                      <v-chip small>{{ a }}</v-chip>
                    </span>
                  </span>
                </div>
                <div class="mt-5" v-if="message">
                  <v-alert border="bottom" color="red darken-1" dark>
                    Harap menjawab semua soal.
                  </v-alert>
                </div>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red darken-1" text @click="dialog = false">
                  Cancel
                </v-btn>
                <v-btn
                  color="green darken-1"
                  text
                  @click="postTask()"
                  :loading="btnLoading"
                >
                  Kumpulkan
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>
<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      task: {},
      answer: {},
      page: 1,
      dialog: false,
      btnLoading: false,
      message: false,
      loading: true,
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      ApiService.get(`s-learning/${this.$route.params.task_id}/task`).then(
        (result) => {
          this.loading = false;
          this.task = result.data.data;
          this.task.course_task_question.forEach((element) => {
            this.answer[element.id] = null;
          });
        }
      );
    },
    back() {
      this.$router.back();
    },
    openDialog() {
      this.dialog = true;
      this.message = false;
    },
    postTask() {
      //validasi answer harus dijawab semua
      this.message = false;
      for (const key in this.answer) {
        if (!this.answer[key]) {
          this.message = true;
          return;
        }
      }

      this.btnLoading = true;

      ApiService.post(`s-learning/task`, {
        task: this.task,
        answer: this.answer,
      }).then((result) => {
        this.btnLoading = false;
        this.$router.back();
      });
    },
  },
};
</script>