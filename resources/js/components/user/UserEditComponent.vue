<template>
  <v-card>
    <v-card-title
      >User Edit: {{ user.id }} <v-spacer />
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-form v-if="user.name">
        <v-select
          item-text="name"
          item-value="id"
          v-model="user.user_type_id"
          :items="getOptions.user_types"
          label="User Type"
          :error-messages="errors.user_type_id"
        />
        <v-img :src="generateUrl(photo)" width="300" height="300" />
        <v-text-field
          v-model="user.name"
          label="Name"
          :error-messages="errors.name"
        />
        <v-text-field
          v-model="user.email"
          label="Email"
          type="email"
          :error-messages="errors.email"
        />
        <v-text-field
          v-model="user.phone"
          label="Phone"
          :error-messages="errors.phone"
        />
        <v-textarea
          v-model="user.address"
          label="Address"
          :error-messages="errors.address"
        />
        <v-text-field
          v-model="user.password"
          label="Password"
          type="password"
          :error-messages="errors.password"
        />
        <v-text-field
          v-model="user.password_confirmation"
          label="Confirm Password"
          type="password"
          :error-messages="errors.password"
        />
        <v-file-input
          v-model="user.photo"
          label="Photo"
          :error-messages="errors.photo"
        />
        <!-- jika teacher -->
        <div v-if="user.user_teacher">
          <div class="headline text-center">Teacher Data</div>
          <v-select
            item-text="name"
            item-value="id"
            v-model="user.user_teacher.position_id"
            :items="getOptions.positions"
            label="Position"
            :error-messages="errors.position_id"
          />
          <v-select
            item-text="name"
            item-value="id"
            v-model="user.user_teacher.golongan_id"
            :items="getOptions.golongans"
            label="Golongan"
            :error-messages="errors.golongan_id"
          />
          <v-select
            item-text="name"
            item-value="id"
            v-model="user.user_teacher.education_id"
            :items="getOptions.educations"
            label="Education"
            :error-messages="errors.education_id"
          />
        </div>

        <!-- jika student -->
        <div v-if="user.user_student">
          <div class="headline text-center">Student Data</div>
          <v-select
            item-text="name"
            item-value="id"
            v-model="user.user_student.grade_id"
            :items="getOptions.grades"
            label="Grade"
            :error-messages="errors.grade_id"
          />
        </div>
      </v-form>
    </v-card-text>
    <v-card-actions>
      <v-btn color="primary" block @click="save">Save</v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import { mapGetters } from "vuex";

import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      photo: {},
      errors: {},
      user: {},
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      ApiService.get(`user/${this.$route.params.user_id}`).then((result) => {
        let us = {};
        for (const key in result.data.data) {
          if (key == "photo") {
            this.photo = result.data.data[key];
            us[key] = { name: result.data.data[key] };
          } else {
            us[key] = result.data.data[key];
          }
        }
        this.user = us;
      });
    },
    save() {
      let formData = new FormData();

      for (const key in this.user) {
        if (typeof this.user[key] === "object" && this.user[key] !== null) {
          if (key == "user_teacher" || key == "user_student") {
            for (const k in this.user[key]) {
              formData.append(k, this.user[key][k]);
            }
          } else {
            formData.append(key, this.user[key]);
          }
        } else {
          formData.append(key, this.user[key]);
          formData.append("_method", "PUT");
        }
      }

      ApiService.post(`user/${this.$route.params.user_id}`, formData).then(
        (result) => {
          if (result.status == 200) {
            this.back();
            // this.init();
          } else {
            this.errors = result.data.errors;
          }
        }
      );
    },
    back() {
      this.$router.back();
    },
    generateUrl(item) {
      return window.location.origin + "/" + item;
    },
  },

  computed: {
    ...mapGetters(["getOptions"]),
  },
};
</script>