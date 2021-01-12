<template>
  <v-row>
    <v-col cols="4">
      <v-skeleton-loader
        v-bind="attrs"
        type="card-avatar, article, actions"
      ></v-skeleton-loader>

      <v-skeleton-loader v-bind="attrs" type="date-picker"></v-skeleton-loader>
    </v-col>
    <v-col cols="4">
      <v-skeleton-loader
        v-bind="attrs"
        type="card-avatar, article, actions"
      ></v-skeleton-loader>

      <v-skeleton-loader v-bind="attrs" type="date-picker"></v-skeleton-loader>
    </v-col>
    <v-col cols="4">
      <v-skeleton-loader
        v-bind="attrs"
        type="card-avatar, article, actions"
      ></v-skeleton-loader>

      <v-skeleton-loader v-bind="attrs" type="date-picker"></v-skeleton-loader>
    </v-col>
  </v-row>
</template>

<script>
export default {
  data: () => ({
    attrs: {
      class: "mb-6",
      boilerplate: true,
      elevation: 2,
    },
  }),
};
</script>