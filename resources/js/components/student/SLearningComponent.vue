<template>
  <v-card v-if="!loading">
    <v-card-title> Learning </v-card-title>
    <v-card-text>
      <div v-if="learnings.length > 0">
        <v-card v-for="(item, i) in learnings" :key="i" class="mb-5">
          <template v-if="item.course">
            <v-card-title>
              {{ item.course.name }}
              <v-spacer></v-spacer>
              <v-chip class="mr-2">{{ item.course.course_type.name }}</v-chip>
              <v-chip v-if="item.course.is_premium">{{
                item.course.price
              }}</v-chip>
              <v-chip v-else color="success">FREE</v-chip>
            </v-card-title>
            <v-card-text>
              {{ item.course.desc }}
            </v-card-text>
            <v-card-actions>
              <v-btn text color="primary" @click="learn(item)">
                Learn this Course
              </v-btn>
            </v-card-actions>
          </template>
        </v-card>
      </div>
      <v-card v-else>
        <v-alert border="right" colored-border type="error" elevation="2">
          You did'nt have any course. please buy one
          <v-btn text color="primary" @click="buy">here</v-btn>
        </v-alert>
      </v-card>
    </v-card-text>
  </v-card>
</template>
<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      loading: true,
      learnings: [],
    };
  },
  mounted() {
    this.init();
  },
  watch: {
    learnings() {
      console.log("leng", this.learnings.length);
    },
  },
  methods: {
    init() {
      ApiService.get("s-learning").then((result) => {
        this.loading = false;
        this.learnings = result.data.data;
      });
    },
    learn(item) {
      this.$router.push({
        name: "s-learning.detail",
        params: { learning_id: item.id },
      });
    },
    buy() {
      this.$router.push({ name: "s-course" });
    },
  },
};
</script>