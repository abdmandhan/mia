<template>
  <v-card>
    <v-card-title
      >Change Password
      <v-spacer />
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <v-text-field
            dense
            v-model="cPassword.old_password"
            label="Old Password"
            type="password"
            :error-messages="errors.old_password"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-text-field
            dense
            v-model="cPassword.new_password"
            label="New Password"
            type="password"
            :error-messages="errors.new_password"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-text-field
            dense
            v-model="cPassword.new_password_confirmation"
            label="Confirmation New Password"
            type="password"
            :error-messages="errors.new_password_confirmation"
          ></v-text-field>
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions>
      <v-btn color="warning" @click="changePassword" block>
        Change Password
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      errors: {},
      cPassword: {
        old_password: "",
        new_password: "",
        new_password_confirmation: "",
      },
    };
  },
  methods: {
    back() {
      this.$router.back();
    },
    changePassword() {
      this.errors = {};
      ApiService.post("change-password", this.cPassword).then((result) => {
        if (result.status == 200) {
        } else {
          this.errors = result.data.errors;
        }
      });
    },
  },
};
</script>