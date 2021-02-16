<template>
  <v-card>
    <v-card-title>Teacher</v-card-title>
    <v-card-text>
      <v-card v-for="item in teachers" :key="item.id" class="mt-4">
        <v-card-title>
          <v-avatar size="40" class="mr-4">
            <v-img :src="generateUrl(item.photo)" />
          </v-avatar>
          {{ item.name }}</v-card-title
        >
        <v-card-text>
          <v-simple-table>
            <template slot="default">
              <tbody>
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <td>{{ item.email }}</td>
                </tr>
                <tr>
                  <td>Address</td>
                  <td>:</td>
                  <td>{{ item.address }}</td>
                </tr>
                <tr>
                  <td>Phone</td>
                  <td>:</td>
                  <td>{{ item.phone }}</td>
                </tr>
                <tr>
                  <td>Education</td>
                  <td>:</td>
                  <td v-if="item.user_teacher">
                    {{ item.user_teacher.education.name }}
                  </td>
                </tr>
                <tr>
                  <td>Golongan</td>
                  <td>:</td>
                  <td v-if="item.user_teacher">
                    {{ item.user_teacher.golongan.name }}
                  </td>
                </tr>
                <tr>
                  <td>Position</td>
                  <td>:</td>
                  <td v-if="item.user_teacher">
                    {{ item.user_teacher.position.name }}
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-card-text>
      </v-card>
    </v-card-text>
  </v-card>
</template>
<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      teachers: [],
    };
  },
  mounted() {
    ApiService.get("teacher").then((result) => {
      this.teachers = result.data.data;
    });
  },
  methods: {
    generateUrl(item) {
      return window.location.origin + "/" + item;
    },
  },
};
</script>