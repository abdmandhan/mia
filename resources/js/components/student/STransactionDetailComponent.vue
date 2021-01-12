<template>
  <v-card>
    <v-card-title
      >Transaction: {{ transaction.id }}
      <v-spacer />
      <v-btn @click="back">Back</v-btn>
    </v-card-title>
    <v-card-text v-if="transaction.course">
      <v-alert
        v-if="transaction.transaction_status_id == 2"
        border="right"
        colored-border
        type="success"
        elevation="2"
      >
        Selamat!, course anda sudah bisa diakses
      </v-alert>
      <v-alert border="right" colored-border type="error" elevation="2" v-else>
        Course akan dapat diakses setelah pembayaran selesai.
      </v-alert>

      <v-simple-table>
        <template slot="default">
          <tbody>
            <tr>
              <td>Transaction ID</td>
              <td>:</td>
              <td>{{ transaction.id }}</td>
            </tr>
            <tr>
              <td>Course</td>
              <td>:</td>
              <td>{{ transaction.course.name }}</td>
            </tr>
            <tr>
              <td>Transaction Status</td>
              <td>:</td>
              <td>{{ transaction.transaction_status.name }}</td>
            </tr>
            <tr>
              <td>Transaction Date</td>
              <td>:</td>
              <td>{{ transaction.transaction_date }}</td>
            </tr>
            <tr>
              <td>Transaction Status</td>
              <td>:</td>
              <td>{{ transaction.transaction_status.name }}</td>
            </tr>
            <tr>
              <td>Amount</td>
              <td>:</td>
              <td>{{ transaction.amount }}</td>
            </tr>
            <tr>
              <td>Account Number</td>
              <td>:</td>
              <td>{{ transaction.account_no }}</td>
            </tr>
            <tr>
              <td>Account Name</td>
              <td>:</td>
              <td>{{ transaction.account_name }}</td>
            </tr>
            <tr>
              <td>Note</td>
              <td>:</td>
              <td>{{ transaction.note }}</td>
            </tr>
            <tr>
              <td>Image</td>
              <td>:</td>
              <td>
                <v-img
                  :src="generateUrl(transaction.image)"
                  height="300"
                  width="300"
                ></v-img>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-card-text>
  </v-card>
</template>
<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      transaction: {},
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      ApiService.get(`s-transaction/${this.$route.params.transaction_id}`).then(
        (result) => {
          this.transaction = result.data.data;
        }
      );
    },
    back() {
      this.$router.push({ name: "s-transaction" });
    },
    generateUrl(item) {
      return window.location.origin + "/" + item;
    },
  },
};
</script>