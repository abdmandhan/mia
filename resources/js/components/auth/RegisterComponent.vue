<template>
  <v-container fill-height="fill-height">
    <v-layout align-center="align-center" justify-center="justify-center">
      <v-flex class="login-form text-xs-center" style="max-width: 500px">
        <div class="mb-3 text-center" style="font-size: 48px; font-weight: 900">
          Einstein
        </div>
        <v-card light="light">
          <v-card-text>
            <v-form>
              <v-text-field
                v-model="user.name"
                light="light"
                prepend-icon="mdi-account"
                label="Name"
                :error-messages="error.name"
              />
              <v-text-field
                v-model="user.email"
                light="light"
                prepend-icon="mdi-email"
                type="email"
                label="Email"
                :error-messages="error.email"
              />
              <v-text-field
                v-model="user.phone"
                light="light"
                prepend-icon="mdi-phone"
                label="Phone"
                type="number"
                :error-messages="error.phone"
              />
              <v-textarea
                v-model="user.address"
                light="light"
                prepend-icon="mdi-home"
                label="Address"
                :error-messages="error.address"
              />
              <v-text-field
                v-model="user.password"
                light="light"
                prepend-icon="mdi-lock"
                label="Password"
                type="password"
                :error-messages="error.password"
              />
              <v-text-field
                v-model="user.password_confirmation"
                light="light"
                prepend-icon="mdi-lock"
                label="Confirmation Password"
                type="password"
                :error-messages="error.password"
              />
              <v-btn
                @click.prevent="postLogin()"
                color="primary"
                block="block"
                type="submit"
                :loading="loading"
                class="text-white"
                >Sign Up</v-btn
              >
              <div class="mt-5">
                Have an account?
                <v-btn text small :to="{ name: 'login' }">Login</v-btn>
              </div>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import { mapState, mapGetters } from "vuex";
import { REGISTER } from "./../../services/store/auth.module";

export default {
  mounted() {
    if (this.isAuthenticated) {
      this.$router.push({ name: "dashboard" });
    }
  },
  data() {
    return {
      user: {
        name: "Islamia Nuraini",
        email: "islamia@gmail.com",
        address:
          "Id culpa laborum amet esse ullamco cupidatat in consequat Lorem commodo ipsum Lorem.",
        phone: "08772123123",
        password: "12341234",
        password_confirmation: "12341234",
      },
      loading: false,
      error: [],
    };
  },
  methods: {
    postLogin() {
      this.loading = true;

      setTimeout(() => {
        this.$store.dispatch(REGISTER, this.user).then((data) => {
          if (data.status == 200) {
            this.$router.push({ name: "dashboard" });
          } else {
            this.error = data.data.errors;
          }
        });

        this.loading = false;
      }, 1000);
    },
  },
  computed: {
    ...mapGetters(["isAuthenticated"]),
  },
};
</script>