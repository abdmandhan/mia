<template>
  <v-app style="font-family: Inter">
    <v-navigation-drawer app v-model="drawer">
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title text-center font-weight-bold">
            Einstein
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <span class="ml-5">Menu</span>
      <v-list dense>
        <div v-for="item in items" :key="item.title" class="my-4">
          <!-- SINGLE MENU -->
          <v-list-item v-if="!item.children" link :to="{ name: item.name }">
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title style="font-size: 14px">
                {{ item.title }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <!-- HAS CHILDREN -->
          <v-list-group
            v-else
            v-model="item.active"
            :prepend-icon="item.icon"
            no-action
          >
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title v-text="item.title"></v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item
              v-for="child in item.children"
              :key="child.name"
              link
              :to="{ name: item.name, params: child.params }"
            >
              <v-list-item-content>
                <v-list-item-title v-text="child.title"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
        </div>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar color="primary" dark app dense>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>
        <v-chip outlined label>
          <v-icon class="pr-2">mdi-calendar</v-icon>
          {{ date }}
        </v-chip>
        <v-chip outlined v-if="currentUser.user_type" label>
          {{ currentUser.user_type.name }}
        </v-chip>
      </v-toolbar-title>

      <v-spacer></v-spacer>

      <v-menu left bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on">
            <v-avatar size="40">
              <v-img :src="generateUrl(currentUser.photo)" />
            </v-avatar>
          </v-btn>
        </template>

        <v-list>
          <v-list-item :to="{ name: 'profile' }">
            <v-list-item-title>{{ currentUser.name }}</v-list-item-title>
          </v-list-item>
          <v-list-item @click="logout">
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>

    <v-main style="background-color: #f2f2f2">
      <v-container>
        <transition name="fade-in-up">
          <router-view />
        </transition>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { mapGetters } from "vuex";
import { LOGOUT } from "./../services/store/auth.module";

export default {
  mounted() {
    if (!this.isAuthenticated) {
      this.$router.push({ name: "login" });
    }
    this.updateTime();
  },
  watch: {
    currentUser() {
      console.log("currenuser", this.currentUser);
      switch (this.currentUser.user_type_id) {
        case 1:
          this.items = this.menu_admin;
          break;
        case 2:
          this.items = this.menu_teacher;
          break;
        case 3:
          this.items = this.menu_student;
          break;

        default:
          this.items = this.menu_student;
          break;
      }
    },
  },
  data() {
    return {
      date: "",
      drawer: null,
      items: [],
      menu_student: [
        {
          name: "dashboard",
          icon: "mdi-clipboard-edit-outline",
          title: "Dashboard",
        },
        {
          name: "discussion",
          icon: "mdi-chat",
          title: "Discussion",
        },
        {
          name: "teacher",
          icon: "mdi-account",
          title: "Teacher",
        },
        {
          name: "s-course",
          icon: "mdi-book",
          title: "Course",
        },
        {
          name: "s-transaction",
          icon: "mdi-cash",
          title: "Transaction",
        },
        {
          name: "s-learning",
          icon: "mdi-book-open",
          title: "Learning",
        },
        {
          name: "s-tryout",
          icon: "mdi-clipboard-list-outline",
          title: "Tryout",
        },
      ],
      menu_teacher: [
        {
          name: "dashboard",
          icon: "mdi-clipboard-edit-outline",
          title: "Dashboard",
        },
        {
          name: "discussion",
          icon: "mdi-chat",
          title: "Discussion",
        },
        {
          name: "course-management",
          icon: "mdi-book",
          title: "Course Management",
        },
        {
          name: "feedback",
          icon: "mdi-book-open-variant",
          title: "Feedback",
        },
        {
          name: "tryout-management",
          icon: "mdi-book-check-outline",
          title: "Tryout Management",
        },
      ],
      menu_admin: [
        {
          name: "dashboard",
          icon: "mdi-clipboard-edit-outline",
          title: "Dashboard",
        },
        {
          name: "transaction-management",
          icon: "mdi-cash",
          title: "Transaction Management",
        },
        {
          name: "user-management",
          icon: "mdi-account",
          title: "User Management",
        },
        {
          name: "discussion",
          icon: "mdi-chat",
          title: "Discussion",
        },
        {
          name: "course-management",
          icon: "mdi-book",
          title: "Course Management",
        },
        {
          name: "tryout-management",
          icon: "mdi-book-check-outline",
          title: "Tryout Management",
        },
        {
          name: "crud",
          icon: "mdi-monitor-star",
          title: "Content Management",
          children: [
            {
              title: "Announcement",
              params: { model: "announcement" },
            },
            {
              title: "Position",
              params: { model: "position" },
            },
            {
              title: "Course Type",
              params: { model: "course-type" },
            },
            {
              title: "Difficulty",
              params: { model: "difficulty" },
            },
            {
              title: "Education",
              params: { model: "education" },
            },
            {
              title: "Golongan",
              params: { model: "golongan" },
            },
            {
              title: "Grade",
              params: { model: "grade" },
            },
          ],
        },
      ],
    };
  },
  methods: {
    generateUrl(item) {
      if (item) {
        return window.location.origin + "/" + item;
      }
    },
    logout() {
      this.$store
        .dispatch(LOGOUT)
        .then(() => this.$router.push({ name: "login" }));
    },
    updateTime() {
      var week = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];

      var cd = new Date();
      this.date =
        this.zeroPadding(cd.getFullYear(), 4) +
        "-" +
        this.zeroPadding(cd.getMonth() + 1, 2) +
        "-" +
        this.zeroPadding(cd.getDate(), 2) +
        " " +
        week[cd.getDay()];
    },
    zeroPadding(num, digit) {
      var zero = "";
      for (var i = 0; i < digit; i++) {
        zero += "0";
      }
      return (zero + num).slice(-digit);
    },
  },
  computed: {
    ...mapGetters(["isAuthenticated", "currentUser"]),
  },
};
</script>
