<template>
  <v-card>
    <v-card-title>Tryout</v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="6" v-for="(item, index) in tryouts" :key="index">
          <v-card v-if="item.question_count > 0">
            <v-card-title>{{ item.name }}</v-card-title>
            <v-card-subtitle>
              <v-chip :color="item.difficulty.color" small>
                {{ item.difficulty.name }}
              </v-chip>
            </v-card-subtitle>
            <v-card-text v-if="item.student_assign">
              <v-simple-table dense>
                <template v-slot:default>
                  <tbody>
                    <tr>
                      <td>Start Date</td>
                      <td>{{ item.student_assign.start_date }}</td>
                    </tr>
                    <tr>
                      <td>Finish Date</td>
                      <td>{{ item.student_assign.finish_date }}</td>
                    </tr>
                    <tr>
                      <td>Score</td>
                      <td v-if="item.student_assign.score">
                        {{ item.student_assign.score }}
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-card-text>
            <v-card-actions v-if="item.student_assign">
              <v-spacer></v-spacer>
              <v-dialog
                v-model="dialogReview[item.id]"
                persistent
                v-if="item.student_assign.finish_date"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-btn color="green" dark v-bind="attrs" v-on="on">
                    Review
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title class="headline">
                    {{ item.name }}
                  </v-card-title>
                  <v-card-text>
                    <v-simple-table>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Question</th>
                            <th>Your Answer</th>
                            <th v-if="item.is_show_review">True Answer</th>
                            <th v-if="item.is_show_review">Review</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                            v-for="(a, b) in item.student_assign
                              .tryout_student_answer"
                            :key="b"
                          >
                            <td>{{ b + 1 }}</td>
                            <td>{{ a.question.question }}</td>
                            <td v-if="a.answer_id == null">
                              <v-chip color="red" small>Tidak Dijawab</v-chip>
                            </td>
                            <td v-else>
                              {{ a.answer.answer }}
                            </td>
                            <td v-if="item.is_show_review">
                              {{ a.question.true_answer.answer }}
                            </td>
                            <td v-if="item.is_show_review">
                              <v-icon
                                color="success"
                                v-if="a.answer.id == a.question.true_answer.id"
                              >
                                mdi-check-decagram
                              </v-icon>
                              <v-icon v-else color="red">
                                mdi-close-circle
                              </v-icon>
                            </td>
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
                      @click="dialogReview[item.id] = false"
                    >
                      Cancel
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog
                v-model="dialog[item.id]"
                persistent
                max-width="500"
                v-if="!item.student_assign.finish_date"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-btn color="primary" dark v-bind="attrs" v-on="on">
                    Lanjutkan
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title class="headline">
                    {{ item.name }}
                  </v-card-title>
                  <v-card-text>
                    <v-simple-table>
                      <template v-slot:default>
                        <tbody>
                          <tr>
                            <td>Start Date</td>
                            <td>:</td>
                            <td>{{ item.date_start }}</td>
                          </tr>
                          <tr>
                            <td>Finish Date</td>
                            <td>:</td>
                            <td>{{ item.date_finish }}</td>
                          </tr>
                          <tr>
                            <td>Waktu Mengerjakan</td>
                            <td>:</td>
                            <td>{{ item.time }}</td>
                          </tr>
                          <tr>
                            <td>Jumlah Soal</td>
                            <td>:</td>
                            <td>{{ item.question_count }}</td>
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
                      @click="dialog[item.id] = false"
                    >
                      Cancel
                    </v-btn>
                    <v-btn
                      color="green darken-1"
                      text
                      :to="{
                        name: 's-tryout.detail',
                        params: { tryout_id: item.id },
                      }"
                      :loading="btnLoading"
                    >
                      Lanjutkan
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-card-actions>
            <v-card-actions v-else>
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog[item.id]" persistent max-width="500">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn color="primary" dark v-bind="attrs" v-on="on">
                    Kerjakan
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title class="headline">
                    {{ item.name }}
                  </v-card-title>
                  <v-card-text>
                    <v-simple-table>
                      <template v-slot:default>
                        <tbody>
                          <tr>
                            <td>Start Date</td>
                            <td>:</td>
                            <td>{{ item.date_start }}</td>
                          </tr>
                          <tr>
                            <td>Finish Date</td>
                            <td>:</td>
                            <td>{{ item.date_finish }}</td>
                          </tr>
                          <tr>
                            <td>Waktu Mengerjakan</td>
                            <td>:</td>
                            <td>{{ item.time }}</td>
                          </tr>
                          <tr>
                            <td>Jumlah Soal</td>
                            <td>:</td>
                            <td>{{ item.question_count }}</td>
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
                      @click="dialog[item.id] = false"
                    >
                      Cancel
                    </v-btn>
                    <v-btn
                      color="green darken-1"
                      text
                      @click="postTryOut(item)"
                      :loading="btnLoading"
                    >
                      Kerjakan
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-card-actions>
          </v-card>
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
      tryouts: [],
      dialog: {},
      dialogReview: {},
      btnLoading: false,
    };
  },
  mounted() {
    ApiService.get(`s-tryout`)
      .then((result) => {
        this.tryouts = result.data.data;
      })
      .catch((err) => {});
  },
  methods: {
    postTryOut(item) {
      this.btnLoading = true;
      ApiService.post(`s-tryout`, item)
        .then((result) => {
          this.btnLoading = false;
          this.$router.push({
            name: "s-tryout.detail",
            params: { tryout_id: item.id },
          });
        })
        .catch((err) => {});
    },
  },
};
</script>