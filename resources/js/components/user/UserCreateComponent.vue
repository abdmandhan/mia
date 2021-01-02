<template>
  <v-card>
    <v-card-title
      >User Create <v-spacer />
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-form>
        <v-select
          item-text="name"
          item-value="id"
          v-model="user.user_type_id"
          :items="getOptions.user_types"
          label="User Type"
          :error-messages="errors.user_type_id"
        />
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
          v-model="user.password"
          label="Password"
          type="password"
          :error-messages="errors.password"
        />
        <v-text-field
          v-model="user.password_confirmation"
          label="Confirm Password"
          type="password"
          :error-messages="errors.password_confirmation"
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
    init() {},
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
        }
      }

      ApiService.post(`user`, formData).then((result) => {
        if (result.status == 200) {
          this.back();
        } else {
          this.errors = result.data.errors;
        }
      });
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