<template>
  <v-card v-if="user.name">
    <v-card-title
      >Profile: {{ user.name }}
      <v-spacer />
      <v-btn text color="red" :to="{ name: 'change.password' }"
        >Change Password</v-btn
      >
    </v-card-title>
    <v-card-text>
      <v-form>
        <v-img :src="generateUrl(currentUser.photo)" width="300" height="300" />
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
        <v-file-input
          v-model="user.photo"
          label="Photo"
          :error-messages="errors.photo"
        />
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
      user: {},
      errors: {},
    };
  },
  watch: {
    currentUser() {
      let us = {};
      for (const key in this.currentUser) {
        if (key == "photo") {
          us[key] = { name: this.currentUser[key] };
        } else {
          us[key] = this.currentUser[key];
        }
      }
      this.user = us;
    },
  },
  computed: {
    ...mapGetters(["currentUser", "getOptions"]),
  },
  methods: {
    generateUrl(item) {
      return window.location.origin + "/" + item;
    },
    save() {
      let formData = new FormData();

      for (const key in this.user) {
        formData.append(key, this.user[key]);
      }

      ApiService.post("update", formData).then((result) => {
        if (result.status == 200) {
        } else {
          this.errors = result.data.errors;
        }
      });
    },
  },
};
</script>