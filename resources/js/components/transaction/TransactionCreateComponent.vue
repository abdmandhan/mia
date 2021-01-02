<template>
  <v-card>
    <v-card-title>
      Transaction Create <v-spacer />
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-form>
        <v-select
          item-text="name"
          item-value="id"
          v-model="transaction.user_id"
          :items="getOptions.student"
          label="Student"
          :error-messages="errors.user_id"
        />

        <v-select
          item-text="name"
          item-value="id"
          v-model="transaction.course_id"
          :items="getOptions.courses"
          label="Course"
          :error-messages="errors.course_id"
        />

        <v-select
          item-text="name"
          item-value="id"
          v-model="transaction.transaction_status_id"
          :items="getOptions.transaction_statuses"
          label="Transaction Status"
          :error-messages="errors.transaction_status_id"
        />

        <v-text-field
          v-model="transaction.transaction_date"
          label="Transaction Date"
          type="date"
          :error-messages="errors.transaction_date"
        />

        <v-text-field
          v-model="transaction.amount"
          label="Amount"
          type="number"
          :error-messages="errors.amount"
        />

        <v-text-field
          v-model="transaction.account_no"
          label="Account Number"
          type="number"
          :error-messages="errors.account_no"
        />

        <v-text-field
          v-model="transaction.account_name"
          label="Account Name"
          type="text"
          :error-messages="errors.account_name"
        />

        <v-file-input
          v-model="transaction.image"
          label="Image"
          :error-messages="errors.image"
        />
      </v-form>
    </v-card-text>
    <v-card-actions>
      <v-btn color="primary" block @click="create">Create</v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import { mapGetters } from "vuex";
import ApiService from "../../services/api.service";

export default {
  data() {
    return {
      errors: {},
      transaction: {},
    };
  },
  methods: {
    back() {
      this.$router.back();
    },
    create() {
      this.errors = {};

      let formData = new FormData();

      for (const key in this.transaction) {
        formData.append(key, this.transaction[key]);
      }

      ApiService.post("transaction", formData).then((result) => {
        if (result.status == 200) {
          this.back();
        } else {
          this.errors = result.data.errors;
        }
      });
    },
  },
  computed: {
    ...mapGetters(["getOptions"]),
  },
};
</script>