<template>
    <div class="container">
        <div class="row justify-content-center">
            <b-table striped borderless hover :items="users" :fields="fields">                
                <template v-slot:cell(actions)="data">
                    <b-button v-bind:href="'users/'+data.item.id+'/edit'">Editar</b-button>
                    <b-button variant="danger" @click="eliminar(data.item.id)">Eliminar</b-button>
                </template>
            </b-table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: [],
            fields: [
                {
                    key: "name",
                    label: "Nombre",
                    sortable: true
                },
                {
                    key: "email",
                    sortable: false
                },
                {
                    key: "actions",
                    label:"",
                    thStyle:{width:'20%'}
                }
            ]
        };
    },
    methods: {
        getUsers() {
            axios.get("/users/provide", {
                _method: "GET"
            })
            .then(response => {
                const items = response.data;
                console.log(response.data);
                this.users = items;
            });
        },
        eliminar(id){
            axios.delete('/users/' + id)
            .then(response => {
                this.getUsers();
            });
        }
    },
    mounted() {
        console.log("Component mounted.");
    },
    created: function() {
        this.getUsers();
    }
};
</script>
