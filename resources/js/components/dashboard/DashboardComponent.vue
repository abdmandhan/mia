<template>
  <v-container>
    <v-row>
      <v-col cols="4">
        <dashboard-card-greeting-component :announcements="announcements" />
      </v-col>
      <v-col cols="8">
        <div class="headline text-center">Absensi</div>
        <v-sheet tile height="54" class="d-flex">
          <v-btn icon class="ma-2" @click="$refs.calendar.prev()">
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
          <v-spacer></v-spacer>
          <span v-if="$refs.calendar" class="mt-4">
            {{ $refs.calendar.title }}
          </span>
          <v-spacer></v-spacer>
          <v-btn icon class="ma-2" @click="$refs.calendar.next()">
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </v-sheet>
        <v-sheet height="600">
          <v-calendar
            ref="calendar"
            v-model="value"
            :weekdays="weekday"
            :type="type"
            :events="events"
            :event-overlap-mode="mode"
            :event-overlap-threshold="30"
            event-color="primary"
          ></v-calendar>
        </v-sheet>
      </v-col>
    </v-row>
  </v-container>
</template>


<script>
import ApiService from "../../services/api.service";
export default {
  data() {
    return {
      announcements: [],
      type: "month",
      mode: "stack",
      weekday: [0, 1, 2, 3, 4, 5, 6],
      value: "",
      events: [],
    };
  },
  mounted() {
    ApiService.get(`dashboard`)
      .then((result) => {
        this.announcements = result.data.data.announcements;
        this.convertDate(result.data.data.absensi);
      })
      .catch((err) => {});
  },
  methods: {
    convertDate(events) {
      const ev = [];

      events.forEach((element, key) => {
        var start = new Date(0);
        start.setUTCSeconds(element.start);

        var end = new Date(0);
        end.setUTCSeconds(element.end);

        ev.push({
          name: element.name,
          start: start,
          end: end,
          color: element.color,
          timed: element.timed,
        });
      });

      this.events = ev;
      console.log("events", this.events);
    },
  },
};
</script>

