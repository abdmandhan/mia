<template>
  <v-card>
    <v-img src="http://crm.test/images/grey1.png">
      <v-container>
        <v-row>
          <v-col>
            <v-chip outlined label>
              <v-icon color="white">mdi-clock-time-four-outline</v-icon>
              <span class="text-white pl-2">13:34 PM</span>
            </v-chip>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="text-center">
            <v-avatar>
              <v-img :src="generateUrl(currentUser.photo)" />
            </v-avatar>
          </v-col>
        </v-row>
        <v-row>
          <v-col class="text-center text-white">
            <div class="headline">Good Evening!</div>
            <div style="color: black">Welcome Back, {{ currentUser.name }}</div>
          </v-col>
        </v-row>
      </v-container>
    </v-img>
    <v-card-text>
      <div class="body-1 font-weight-bold">Pengumuman</div>
      <v-virtual-scroll height="400" item-height="100" :items="announcements">
        <template v-slot:default="{ item }">
          <span class="d-flex mt-5">
            <v-icon small color="primary" class="pa-4">
              mdi-checkbox-blank-circle-outline
            </v-icon>
            <div>
              <span class="font-weight-bold">{{ item.title }}</span>
              <div>{{ item.created_at }}</div>
            </div>
          </span>
        </template>
      </v-virtual-scroll>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: {
    announcements: {
      type: Array,
    },
  },
  computed: {
    ...mapGetters(["isAuthenticated", "currentUser"]),
  },
  methods: {
    generateUrl(item) {
      return window.location.origin + "/" + item;
    },
  },
};
</script>