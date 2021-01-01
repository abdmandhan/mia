<template>
  <v-app style="font-family: Inter">
    <snackbar-component />
    <router-view></router-view>
    <v-footer app="app">
      <v-flex class="text-xs-center">© 2020. Islamia Nuraini.</v-flex>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  name: "CRM",
  data() {
    return {};
  },
  methods: {
    showSnackbar() {
      this.$snackbar.showMessage({ content: "Hello, snackbar", color: "red" });
    },
  },
};
</script>
