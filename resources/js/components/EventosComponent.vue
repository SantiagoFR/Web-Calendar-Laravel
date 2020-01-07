<script>
    import FullCalendar from "@fullcalendar/vue";
    import dayGridPlugin from "@fullcalendar/daygrid";
    import esLocale from "@fullcalendar/core/locales/es";
    import Calendar from "@fullcalendar/core";
    import rrulePlugin from "@fullcalendar/rrule";
    import bootstrap from "@fullcalendar/bootstrap";

    export default {
        props: ["loggedUser"],
        components: {
            FullCalendar
        },
        data: function () {
            return {
                calendarPlugins: [dayGridPlugin, rrulePlugin, bootstrap],
                titleFormat: "MMMM YYYY",
                buttonIcons: {
                    close: "fa-times",
                    prev: "fas fa-chevron-left",
                    next: "fa-chevron-right",
                    prevYear: "fa-angle-double-left",
                    nextYear: "fa-angle-double-right"
                },
                customButtons: {
                    newEventButton: {
                        text: "Nuevo Evento",
                        class: "btn-primary",
                        click: function () {
                            window.location.href = "/eventos/create";
                        }
                    },
                    etiquetasButton: {
                        text: "Etiquetas",
                        class: "btn-danger",
                        click: function () {
                            window.location.href = "/etiquetas";
                        }
                    }
                },
                events: [],
                locale: esLocale,
                header: {
                    left: "prev,next today ",
                    center: "title",
                    right: "etiquetasButton,newEventButton"
                },
                users: [],
                user: this.loggedUser,
                etiqueta: '',
                etiquetas: [],
                eventRender: function (info) {
                    $(info.el).tooltip({
                        title: "<strong><p>" +
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
        mounted: function () {
            this.getUsers();
            this.getEtiquetas();
            this.getEvents();
        },
        methods: {
            showEvents: function (params) {
                console.log(this.$refs.calendar.getApi().getEvents());
            },
            getEtiquetas: function () {
                axios
                    .get("/eventos/getEtiquetas", {
                        _method: "GET"
                    })
                    .then(response => {
                        const items = response.data;
                        this.etiquetas = items;
                    });
            },
            getEvents: function () {
                var start = this.$refs.calendar.getApi().view.activeStart
                var end = this.$refs.calendar.getApi().view.activeEnd
                var user = $('#user').val();
                if (user == '') user = null
                var etiqueta = $('#etiqueta').val();
                if (etiqueta == '') etiqueta = null
                axios.get("/eventos/provide", {
                    _method: "GET",
                    params: {
                        start: start,
                        end: end,
                        user: user,
                        etiqueta: etiqueta
                    }
                }).then(response => {
                    const items = response.data;
                    console.log(response.data)
                    this.events = items;
                });
            },
            getUsers: function () {
                axios
                    .get("/eventos/getUsers", {
                        _method: "GET"
                    })
                    .then(response => {
                        const items = response.data;
                        this.users = items;
                    });
            },
            eventClick: function (info) {
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
        <div class="row justify-content-center">
            <div class="col-sm-3">
                <p class="mt-5">
                    <strong>Búsqueda por usuario</strong>
                </p>
                <b-form-select class="mb-3" v-model="user" :options="users" @change="getEvents" id="user"></b-form-select>
                <p>
                    <strong>Búsqueda por etiqueta</strong>
                </p>
                <b-form-select class="mb-3" v-model="etiqueta" :options="etiquetas" @change="getEvents" id="etiqueta"></b-form-select>
            </div>
            <div class="col-sm-9">
                <FullCalendar ref="calendar" defaultView="dayGridMonth" :plugins="calendarPlugins"
                              themeSystem="bootstrap" :customButtons="customButtons"
                              :buttonIcons="buttonIcons" :header="header" :locale="locale" :eventRender="eventRender"
                              @eventClick="eventClick" :events="events" :datesRender="getEvents"/>
            </div>
        </div>
    </div>
</template>

<style lang='scss'>
    @import "~@fullcalendar/core/main.css";
    @import "~@fullcalendar/daygrid/main.css";
</style>
