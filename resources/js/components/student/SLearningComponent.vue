<template>
  <v-card>
    <v-card-title> Learning </v-card-title>
    <v-card-text>
      <v-card v-for="(item, i) in learnings" :key="i" class="mb-5">
        <v-card-title v-if="item.course">
          {{ item.course.name }}
          <v-spacer></v-spacer>
          <v-chip class="mr-2">{{ item.course.course_type.name }}</v-chip>
          <v-chip v-if="item.course.is_premium">{{ item.course.price }}</v-chip>
          <v-chip v-else color="success">FREE</v-chip>
        </v-card-title>
        <v-card-text>
          {{ item.course.desc }}
        </v-card-text>
        <v-card-actions>
          <v-btn text color="primary" @click="learn(item)"
            >Learn this Course</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-card-text>
  </v-card>
</template>
<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      learnings: [],
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      ApiService.get("s-learning").then((result) => {
        this.learnings = result.data.data;
      });
    },
    learn(item) {
      this.$router.push({
        name: "s-learning.detail",
        params: { learning_id: item.id },
      });
    },
  },
};
</script>