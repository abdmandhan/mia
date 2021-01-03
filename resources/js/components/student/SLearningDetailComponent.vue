<template>
  <v-card v-if="learning.course">
    <v-card-title
      >Learning Course: {{ learning.course.name }}
      <v-spacer />
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <div>
        Bahan Materi
        <v-simple-table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Desc</th>
              <th>File</th>
              <th>Video</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, i) in learning.course.course_content" :key="i">
              <td>{{ item.name }}</td>
              <td>{{ item.desc }}</td>
              <td>
                <v-btn icon :href="generateUrl(item.file)" target="_blank">
                  <v-icon color="red">mdi-file-pdf</v-icon>
                </v-btn>
              </td>
              <td>
                <v-btn icon :href="item.url_youtube" target="_blank">
                  <v-icon color="red">mdi-youtube</v-icon>
                </v-btn>
              </td>
            </tr>
          </tbody>
        </v-simple-table>
      </div>
      <div>
        Tugas Belajar
        <v-simple-table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Difficulty</th>
              <th>Score</th>
              <th>Start Date</th>
              <th>Finish Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(item, i) in learning.course.course_task_student"
              :key="i"
            >
              <td>{{ item.course_task.name }}</td>
              <td>{{ item.course_task.difficulty.name }}</td>
              <td>
                <span v-if="item.score">
                  <v-chip small>{{ item.score }}</v-chip>
                </span>
                <span v-else-if="item.finish_date">
                  <v-chip small>Menunggu Feedback dari Guru</v-chip>
                </span>
              </td>
              <td>{{ item.start_date }}</td>
              <td>{{ item.finish_date }}</td>
              <td>
                <v-tooltip bottom v-if="!item.finish_date">
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      color="green"
                      icon
                      v-bind="attrs"
                      v-on="on"
                      @click="openDialog(item)"
                      ><v-icon>mdi-play-box</v-icon></v-btn
                    >
                    <v-dialog v-model="dialog" persistent max-width="290">
                      <v-card>
                        <v-card-title class="headline">
                          {{ dialogTitle }}
                        </v-card-title>
                        <v-card-text> </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn
                            color="red darken-1"
                            text
                            @click="dialog = false"
                          >
                            Cancel
                          </v-btn>
                          <v-btn
                            color="green darken-1"
                            text
                            @click="startLearning(item)"
                            :loading="btnLoading"
                          >
                            Mulai Kerjakan
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                  </template>
                  <span>Kerjakan</span>
                </v-tooltip>
                <v-tooltip bottom v-else>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      color="green"
                      icon
                      v-bind="attrs"
                      v-on="on"
                      @click="openDialogReview(item)"
                      ><v-icon>mdi-book-check-outline</v-icon></v-btn
                    >
                    <v-dialog v-model="dialogReview" persistent>
                      <v-card>
                        <v-card-title class="headline"> Review </v-card-title>
                        <v-card-text>
                          <v-simple-table>
                            <template v-slot:default>
                              <thead>
                                <tr>
                                  <th class="text-left">No</th>
                                  <th class="text-left">Question</th>
                                  <th class="text-left">Your Answer</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr
                                  v-for="(a, b) in item.course_task
                                    .course_task_student_answer"
                                  :key="b"
                                >
                                  <td>{{ b + 1 }}</td>
                                  <td>{{ a.question.question }}</td>
                                  <td v-if="a.question.question_type_id == 1">
                                    {{ a.answer.answer }}
                                  </td>
                                  <td v-else>{{ a.answer_essay }}</td>
                                </tr>
                              </tbody>
                            </template>
                          </v-simple-table>
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn
                            color="red darken-1"
                            text
                            @click="dialogReview = false"
                          >
                            Cancel
                          </v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                  </template>
                  <span>Review</span>
                </v-tooltip>
              </td>
            </tr>
          </tbody>
        </v-simple-table>
      </div>
    </v-card-text>
  </v-card>
</template>
<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      learning: {},
      dialog: false,
      dialogTitle: "",
      dialogTime: "",
      dialogReview: false,
      btnLoading: false,
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      ApiService.get(`s-learning/${this.$route.params.learning_id}`).then(
        (result) => {
          this.learning = result.data.data;
        }
      );
    },
    back() {
      this.$router.back();
    },
    generateUrl(item) {
      return window.location.origin + "/" + item;
    },
    openDialog(item) {
      this.dialogTitle = item.course_task.name;
      this.dialog = true;
    },
    openDialogReview(item) {
      this.dialogReview = true;
    },
    startLearning(item) {
      ApiService.post(`s-learning`, item).then((result) => {
        console.log("item", item);
        this.btnLoading = false;
        this.$router.push({
          name: "s-learning.task",
          params: { task_id: item.course_task_id },
        });
      });
    },
  },
};
</script>