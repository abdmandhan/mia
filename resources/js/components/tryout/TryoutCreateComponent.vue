<template>
  <v-card>
    <v-card-title>
      Tryout Create <v-spacer></v-spacer>
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
  </v-card>
</template>

<script>
export default {
  methods: {
    back() {
      this.$router.back();
    },
  },
};
</script>