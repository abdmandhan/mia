<template>
  <v-card>
    <v-card-title>Feedback Course Task</v-card-title>
    <v-card-text v-if="feedbacks.length > 0">
      <v-card v-for="(item, i) in feedbacks" :key="i">
        <v-card-title>
          {{ item.user.name }}
          <v-divider></v-divider>
          {{ item.course.name }}
        </v-card-title>
        <v-card-text>
          <v-simple-table>
            <tbody>
              <tr>
                <td>Nama Tugas</td>
                <td>:</td>
                <td>{{ item.course_task.name }}</td>
              </tr>
              <tr>
                <td>Start Date</td>
                <td>:</td>
                <td>{{ item.start_date }}</td>
              </tr>
              <tr>
                <td>Finish Date</td>
                <td>:</td>
                <td>{{ item.finish_date }}</td>
              </tr>
              <tr>
                <td>Score</td>
                <td>:</td>
                <td>
                  <span v-if="item.score">
                    <v-chip small>{{ item.score }}</v-chip>
                  </span>
                  <span v-else>
                    <v-chip small>Menunggu Feedback dari Guru</v-chip>
                  </span>
                </td>
              </tr>
            </tbody>
          </v-simple-table>
        </v-card-text>
        <v-card-actions>
          <v-btn block color="primary" @click="feedback(item)">Feedback</v-btn>
        </v-card-actions>
      </v-card>
    </v-card-text>
    <v-card-text v-else>
      <v-alert border="right" colored-border type="error" elevation="2">
        Tidak ada feedback.
      </v-alert>
    </v-card-text>
  </v-card>
</template>
<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      feedbacks: [],
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      ApiService.get("feedback").then((result) => {
        this.feedbacks = result.data.data;
        console.log("e", this.feedbacks.length);
      });
    },
    feedback(item) {
      this.$router.push({
        name: "feedback.detail",
        params: { feedback_id: item.id },
      });
    },
  },
};
</script>