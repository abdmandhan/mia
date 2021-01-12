<template>
  <v-card>
    <v-card-title>
      <v-avatar size="40">
        <v-img :src="generateUrl(item.user.photo)" />
      </v-avatar>
      <span class="ml-4">
        {{ item.user.name }}
      </span>
      <v-spacer />
      <v-btn icon @click="remove(item)">
        <v-icon color="red">mdi-trash-can</v-icon>
      </v-btn>
      <v-btn icon v-if="is_open" @click="open(item)">
        <v-icon>mdi-chevron-up</v-icon>
      </v-btn>
      <v-btn icon v-else @click="close(item)"
        ><v-icon>mdi-chevron-down</v-icon></v-btn
      >
    </v-card-title>
    <v-card-text>
      {{ item.text }}
      <div class="text-right">{{ item.created_time }}</div>
      <!-- REPLIES -->
      <div
        v-for="reply in item.replies"
        :key="reply.id"
        class="mt-5"
        v-if="is_open"
      >
        <div class="mb-2">
          <v-avatar size="35">
            <v-img :src="generateUrl(reply.user.photo)" />
          </v-avatar>
          <span class="ml-4">
            {{ reply.user.name }}
          </span>
        </div>
        {{ reply.text }}
        <div class="text-right">
          {{ reply.created_time }}
          <v-btn icon @click="removeComment(reply)">
            <v-icon color="red">mdi-trash-can</v-icon>
          </v-btn>
        </div>
      </div>

      <!-- COMMENT -->
      <div>
        <v-textarea
          v-model="comment"
          label="Comment"
          :error-messages="errors.comment"
        />
        <v-btn color="primary" block @click="save">Send</v-btn>
      </div>
    </v-card-text>
  </v-card>
</template>

<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      errors: {},
      is_open: false,
      comment: "",
    };
  },
  props: {
    item: {
      type: Object,
    },
  },
  methods: {
    generateUrl(item) {
      return window.location.origin + "/" + item;
    },
    open(item) {
      this.is_open = false;
    },
    close(item) {
      this.is_open = true;
    },
    save() {
      this.errors = {};
      ApiService.post("discussion/reply", {
        discuss_id: this.item.id,
        comment: this.comment,
      }).then((result) => {
        if (result.status == 200) {
          this.comment = "";
          this.is_open = true;
          this.$emit("success");
        } else {
          this.errors = result.data.errors;
        }
      });
    },
    remove(item) {
      ApiService.delete(`discussion/${item.id}`).then((result) => {
        this.$emit("success");
      });
    },

    removeComment(item) {
      ApiService.delete(`discussion/reply/${item.id}`).then((result) => {
        this.$emit("success");
      });
    },
  },
};
</script>