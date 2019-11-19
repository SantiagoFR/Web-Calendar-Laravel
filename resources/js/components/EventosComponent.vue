<script>
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import esLocale from "@fullcalendar/core/locales/es";
import Calendar from "@fullcalendar/core";

export default {
    components: {
        FullCalendar
    },
    data: function() {
        return {
            calendarPlugins: [dayGridPlugin],
            titleFormat: "MMMM YYYY",
            customButtons: {
                newEventButton: {
                    text: "Nuevo Evento",
                    click: function() {
                        window.location.href = "/eventos/create";
                    }
                }
            },

            locale: esLocale,
            header: {
                left: "prev,next today ",
                center: "title",
                right: "newEventButton"
            },
            eventRender: function(info) {
                jQuery(function($) {
                    var tooltip = new Tooltip(info.el, {
                        title: info.event.extendedProps.tooltip,
                        placement: "top",
                        trigger: "hover",
                        container: "body",
                        html: "true"
                    });
                });
            }
        };
    },
    methods: {
        eventClick: function(info) {
            var div = '<div align="center" id="swal-id"></div>';
            Swal.fire({
                title: info.event.title,
                html: info.event.extendedProps.description,
                showConfirmButton: false,
                footer: div
            });
            var col = document.getElementById("swal-id");
            var edit =
                '<a href="/eventos/' +
                info.event.id +
                '/edit" class="btn btn-secondary btn-footer">Editar</a>';
            var delet =
                '<a href="/eventos/' +
                info.event.id +
                '/destroy" class="btn btn-danger btn-footer">Eliminar</a>';
            var cancel =
                '<button class="btn btn-light btn-footer" onclick="Swal.close()">Atrás</button>';
            col.innerHTML = edit + delet + cancel;
        }
    }
};
</script>

<template>
    <div>
        <FullCalendar
            defaultView="dayGridMonth"
            :plugins="calendarPlugins"
            :customButtons="customButtons"
            :header="header"
            :locale="locale"
            :eventRender="eventRender"
            @eventClick="eventClick"
            events="/eventos/provide"
        />
    </div>
</template>

<style lang='scss'>
@import "~@fullcalendar/core/main.css";
@import "~@fullcalendar/daygrid/main.css";
</style>