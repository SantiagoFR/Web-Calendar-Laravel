<script>
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import esLocale from "@fullcalendar/core/locales/es";
import Calendar from "@fullcalendar/core";
import rrulePlugin from "@fullcalendar/rrule";

export default {
  props: ["loggedUser"],
  components: {
    FullCalendar
  },
  data: function() {
    return {
      calendarPlugins: [dayGridPlugin, rrulePlugin],
      titleFormat: "MMMM YYYY",
      customButtons: {
        newEventButton: {
          text: "Nuevo Evento",
          click: function() {
            window.location.href = "/eventos/create";
          }
        }
      },
      events: {
        url: "/eventos/provide",
        method: "GET",/*
        extraParams: {
          custom_param1: "something",
          custom_param2: "somethingelse"
        },*/
        failure: function() {
          console.log("Error");
        },
        success: function(response) {
          console.log(response);
        },
        color: "blue", // a non-ajax option
        textColor: "black" // a non-ajax option
      },

      locale: esLocale,
      header: {
        left: "prev,next today ",
        center: "title",
        right: "newEventButton"
      },
      eventRender: function(info) {
        $(info.el).tooltip({
          title:
            "<strong><p>" +
            info.event.title +
            "</p></strong>" +
            info.event.extendedProps.full_description +
            "<p><strong>Creado por: </strong>" +
            info.event.extendedProps.creator.name +
            "</p>",
          placement: "top",
          trigger: "hover",
          container: "body",
          html: true
        });
      }
    };
  },
  methods: {
    showEvents: function(params) {
      console.log(this.$refs.calendar.getApi().getEvents());
    },
    eventClick: function(info) {
      var div = '<div align="center" id="swal-id"></div>';
      Swal.fire({
        title: info.event.title,
        html: info.event.extendedProps.full_description,
        showConfirmButton: false,
        footer: div
      });
      var col = document.getElementById("swal-id");
      if (this.loggedUser == info.event.extendedProps.creator_id) {
        var delet =
          '<a href="/eventos/' +
          info.event.id +
          '/destroy" class="btn btn-danger btn-footer">Eliminar</a>';
        col.innerHTML += delet;
      }
      if (info.event.extendedProps.belongs) {
        var edit =
          '<a href="/eventos/' +
          info.event.id +
          '/edit" class="btn btn-secondary btn-footer">Editar</a>';
        col.innerHTML += edit;
      }
      var cancel =
        '<button class="btn btn-light btn-footer" onclick="Swal.close()">Atrás</button>';
      col.innerHTML += cancel;
    }
  }
};
</script>

<template>
  <div>
    <button @click="showEvents">click</button>
    <FullCalendar
      ref="calendar"
      defaultView="dayGridMonth"
      :plugins="calendarPlugins"
      :customButtons="customButtons"
      :header="header"
      :locale="locale"
      :eventRender="eventRender"
      @eventClick="eventClick"
      :events="events"
    />
  </div>
</template>

<style lang='scss'>
@import "~@fullcalendar/core/main.css";
@import "~@fullcalendar/daygrid/main.css";
</style>