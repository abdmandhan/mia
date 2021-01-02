<template>
  <v-card v-if="course.name">
    <v-card-title>
      Course {{ course.name }} <v-spacer />
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-simple-table>
        <template slot="default">
          <tbody>
            <tr>
              <td>Course Type</td>
              <td>:</td>
              <td>{{ course.course_type.name }}</td>
            </tr>
            <tr>
              <td>Course Grade</td>
              <td>:</td>
              <td>{{ course.grade.name }}</td>
            </tr>
            <tr>
              <td>Course Name</td>
              <td>:</td>
              <td>{{ course.name }}</td>
            </tr>
            <tr>
              <td>Course Description</td>
              <td>:</td>
              <td>{{ course.desc }}</td>
            </tr>
            <tr>
              <td>Price</td>
              <td>:</td>
              <td v-if="course.price">{{ course.price }}</td>
              <td v-else>FREE</td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>

      <div class="headline my-2 text-center">Teacher</div>
      <v-card v-for="(item, i) in course.course_teacher" :key="i" class="mb-2">
        <v-card-title>
          <v-avatar size="40" class="mr-2">
            <v-img :src="generateUrl(item.teacher.photo)"></v-img>
          </v-avatar>
          {{ item.teacher.name }}
        </v-card-title>
        <v-card-text>
          <v-simple-table>
            <template slot="default">
              <tbody>
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <td>{{ item.teacher.email }}</td>
                </tr>
                <tr>
                  <td>Education</td>
                  <td>:</td>
                  <td>{{ item.teacher.user_teacher.education.name }}</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-card-text>
      </v-card>
    </v-card-text>
    <v-card-actions>
      <v-dialog
        transition="dialog-bottom-transition"
        max-width="600"
        persistent
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn color="primary" v-bind="attrs" v-on="on" block>Learn</v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar color="primary" dark class="mb-10 text-center">
              Payment
            </v-toolbar>
            <v-card-text v-if="course.is_premium">
              <v-row>
                <v-col cols="12">
                  <v-file-input
                    v-model="transaction.image"
                    label="Bukti Transfer"
                    :error-messages="errors.image"
                  ></v-file-input>
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    v-model="transaction.account_name"
                    label="Bank Account Name"
                    :error-messages="errors.account_name"
                  ></v-text-field>
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    v-model="transaction.account_no"
                    label="Bank Account Number"
                    :error-messages="errors.account_no"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions class="justify-end">
              <v-btn text @click="dialog.value = false" color="red"
                >Close</v-btn
              >
              <v-btn text @click="buy" color="primary">Buy</v-btn>
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>
    </v-card-actions>
  </v-card>
</template>
<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      errors: {},
      transaction: {
        course_id: this.$route.params.course_id,
        account_no: "",
        account_name: "",
      },
      course: {},
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      ApiService.get(`s-course/${this.$route.params.course_id}`).then(
        (result) => {
          this.course = result.data.data;
        }
      );
    },
    generateUrl(item) {
      return window.location.origin + "/" + item;
    },
    back() {
      this.$router.back();
    },
    buy() {
      let formData = new FormData();

      for (const key in this.transaction) {
        formData.append(key, this.transaction[key]);
      }

      ApiService.post("s-course", formData).then((result) => {
        if (result.status == 200) {
          this.$router.push({
            name: "s-transaction.detail",
            params: { transaction_id: result.data.data.id },
          });
        } else {
          this.errors = result.data.errors;
        }
      });
    },
  },
};
</script>