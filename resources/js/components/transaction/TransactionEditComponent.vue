<template>
  <v-card>
    <v-card-title>
      Transaction Edit: {{ transaction.id }} <v-spacer />
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text>
      <v-form v-if="transaction.user">
        <v-text-field
          v-model="transaction.user.name"
          label="User"
          disabled
          :error-messages="errors.user_id"
        />
        <v-text-field
          v-model="transaction.course.name"
          label="Course"
          disabled
          :error-messages="errors.user_id"
        />

        <v-text-field
          v-model="transaction.transaction_date"
          label="Date"
          disabled
          :error-messages="errors.transaction_date"
        />

        <v-text-field
          v-model="transaction.amount"
          label="Amount"
          disabled
          :error-messages="errors.amount"
        />

        <v-textarea
          v-model="transaction.note"
          label="Note"
          :error-messages="errors.note"
        />

        <v-select
          item-text="name"
          item-value="id"
          v-model="transaction.transaction_status_id"
          :items="getOptions.transaction_statuses"
          label="Transaction Status"
          :error-messages="errors.transaction_status_id"
        />
        <span>Bukti Transfer</span>
        <v-img :src="generateUrl(transaction.image)"></v-img>
      </v-form>
    </v-card-text>
    <v-card-actions>
      <v-btn @click="save" block color="primary">Save</v-btn>
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
  mounted() {
    this.init();
  },
  methods: {
    init() {
      ApiService.get(`transaction/${this.$route.params.transaction_id}`).then(
        (result) => {
          this.transaction = result.data.data;
        }
      );
    },
    back() {
      this.$router.back();
    },
    generateUrl(item) {
      return window.location.origin + "/" + item;
    },
    save() {
      ApiService.post(`transaction/${this.$route.params.transaction_id}`, {
        ...this.transaction,
        _method: "PUT",
      }).then((result) => {
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