<script>
    import FullCalendar from "@fullcalendar/vue";
    import dayGridPlugin from "@fullcalendar/daygrid";
    import esLocale from "@fullcalendar/core/locales/es";
    import Calendar from "@fullcalendar/core";
    import rrulePlugin from "@fullcalendar/rrule";
    import bootstrap from "@fullcalendar/bootstrap";

    export default {
        props: ["loggedUser", "admin"],
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
                etiquetas: [],
                eventRender: function (info) {
                    $(info.el).tooltip({
                        title: "<strong><p>" +
                            info.event.title +
                            "</p></strong>" +
                            info.event.extendedProps.full_description
                        ,
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
                let start = this.$refs.calendar.getApi().view.activeStart
                let end = this.$refs.calendar.getApi().view.activeEnd
                if($('#my-events').is(":checked")){
                    var user = this.loggedUser
                }else{
                    var user = null
                }
                let etiqueta = $('#etiqueta').val();
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
                console.log(this.loggedUser)
                console.log(info.event.extendedProps.creator_id)
                console.log(this.admin)
                if (this.loggedUser == info.event.extendedProps.creator_id || this.admin) {
                    var delet =
                        '<a href="/eventos/' +
                        info.event.id +
                        '/destroy" class="btn btn-danger btn-footer">Eliminar</a>';
                    col.innerHTML += delet;
                }
                if (info.event.extendedProps.belongs || this.admin) {
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
        <div class="row justify-content-center mt-5">
            <div class="col-sm-3">
                <div class="card mt-5">
                    <div class="card-header">Filtros</div>
                    <div class="card-body">
                        <b-form-checkbox switch class="mb-3" v-model="allUsers" @change="getEvents" id="my-events"><strong>Mostrar sólo mis eventos</strong></b-form-checkbox>
                        <p><strong>Búsqueda por título</strong></p>
                        <b-form-input @change="getEvents" ></b-form-input>
                        <p><strong>Búsqueda por etiqueta</strong></p>
                        <b-form-select class="mb-3" v-model="etiqueta" :options="etiquetas" @change="getEvents"
                                       id="etiqueta"></b-form-select>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 mt-n3">
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
