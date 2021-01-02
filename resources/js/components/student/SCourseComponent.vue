<template>
  <v-card>
    <v-card-title> Course </v-card-title>
    <v-card-text>
      <v-card v-for="(item, i) in courses" :key="i" class="mb-5">
        <v-card-title>
          {{ item.name }}
          <v-spacer></v-spacer>
          <v-chip class="mr-2">{{ item.course_type.name }}</v-chip>
          <v-chip v-if="item.is_premium">{{ item.price }}</v-chip>
          <v-chip v-else color="success">FREE</v-chip>
        </v-card-title>
        <v-card-text>
          {{ item.desc }}
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
      courses: [],
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      ApiService.get("s-course").then((result) => {
        this.courses = result.data.data;
      });
    },
    learn(item) {
      this.$router.push({
        name: "s-course.detail",
        params: { course_id: item.id },
      });
    },
  },
};
</script>