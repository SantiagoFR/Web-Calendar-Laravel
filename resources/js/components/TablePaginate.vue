<template>
  <div>
    <div align="center">
      <button @click="show" class="btn btn-primary"><p v-if="showUsuarios">Ocultar todos los usuarios</p> <p v-else>Mostrar todos los usuarios</p></button>
    </div>    
    <br>
    <div v-if="showUsuarios">    
      <b-table 
        striped
        hover
        small
        bordered
        head-variant="dark"
        ref="tableAll"
        :filter-function="filteredUsers"
        :filter="[alumnos,departamento,centro,nombre]"
        :no-provider-paging="noProviderPaging"
        :fields="fields"
        selectable="true"
        select-mode="range"
        @row-selected="getUsersSelected"
        :items="users"
        :per-page="perPage"
        @row-dblclicked="addUsuario"
        @filtered="onFiltered"
        :current-page="currentPage"
      ></b-table>

      <div align="center">
        <button class="btn btn-primary" @click="addTodos()">Agregar seleccionados</button>
        <button class="btn btn-info" @click="selectAll(0)">Marcar todos</button>
        <button class="btn btn-info" @click="clearSelected(0)">Desmarcar todos</button>
      </div> 
    </div>
    <br>
    <hr>
    <br>
    <p>
      <strong>Seleccionados:</strong>
    </p>
    <b-table
      borderless
      hover
      small
      ref="tableSelected"
      :fields="fields"
      @row-selected="getAlumnosSelected"
      :selectable="true"
      select-mode="range"
      @row-dblclicked="borrarAlumno"
      :items="alumnos">    
      <template v-slot:head()="data">        
      </template>
    </b-table>
    <div align="center">
      <button class="btn btn-danger" @click="borrarTodos()">Borrar seleccionados</button>
      <button class="btn btn-info" @click="selectAll(1)">Marcar todos</button>
      <button class="btn btn-info" @click="clearSelected(1)">Desmarcar todos</button>
    </div>
    
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      noProviderPaging: true,
      fields: [
        {
          key: "nombre",
          label: "Nombre"
        },
        {
          key: "departamento",
          label: "Departamentos"
        },
        {
          key: "centro.nombre",
          label: "Centro"
        }
      ],
      showUsuarios: false,
      alumnos: [],
      alumnosSelected: [],
      users: [],
      usersSelected: [],
      nombre: null,
      departamento: null,
      centro : null,
    };
  },
  methods: {
    getUsersSelected: function(users) {
      this.usersSelected = [];
      users.forEach(user => {
        this.usersSelected.push(user.id);
      });
    },
    getAlumnosSelected: function(alumnos) {
      this.alumnosSelected = [];
      alumnos.forEach(alumno => {
        this.alumnosSelected.push(alumno.id);
      });
    },
    borrarAlumno: function(item, index, event) {
      axios
        .post("/cursos/" + this.id + "/asignar", {
          _method: "PUT",
          item: item.id,
          action: "delete"
        })
        .then(function(response) {
          console.log(response.data);
        })
        .catch(function(error) {});

      this.provideAlumnos();
      this.provideUsers();
    },
    borrarTodos: function() {
      axios
        .post("/cursos/" + this.id + "/asignar", {
          _method: "PUT",
          item: this.alumnosSelected,
          action: "deleteAll"
        })
        .then(function(response) {
          console.log(response.data);
        })
        .catch(function(error) {});

      this.provideAlumnos();
      this.provideUsers();
    },
    addUsuario: function(item, index, event) {
      axios
        .post("/cursos/" + this.id + "/asignar", {
          _method: "PUT",
          item: item.id,
          action: "add"
        })
        .then(function(response) {
          console.log(response.data);
        })
        .catch(function(error) {});

      this.provideAlumnos();
      this.provideUsers();
    },
    addTodos: function() {
      axios
        .post("/cursos/" + this.id + "/asignar", {
          _method: "PUT",
          item: this.usersSelected,
          action: "addAll"
        })
        .then(function(response) {
          console.log(response.data);
        })
        .catch(function(error) {});
      this.provideAlumnos();
      this.provideUsers();
    },
    provideAlumnos: function() {
      return axios
        .get("/cursos/getUsuarios", {
          _method: "GET",
          params: {
            id: this.id,
          }
        })
        .then(response => {
          const items = response.data;
          this.alumnos = items;
        });
    },
    provideUsers: function() {
      return axios
        .get("/cursos/getUsuarios", {
          _method: "GET",
          params: {
            id: 0,
          }
        })
        .then(response => {
          const items = response.data;
          this.rows = items.length;
          this.users = items;
        });
    },
    filtrarUsuarios(nombre,departamento,centro){    
      if(departamento=="")this.departamento = null
      else this.departamento = departamento    
      if(nombre=="")this.nombre = null
      else this.nombre = nombre    
      if(centro=="")this.centro = null
      else this.centro = centro
    },
    filteredUsers: function(row, filter) { 
      for (let i = 0; i < filter[0].length; i++) {
        if (row.id == filter[0][i].id) return false;
      }            
      if (filter[1] != null && !row.departamento.includes(filter[1])) return false
      if (filter[2] != null && row.centro_id != filter[2]) return false
      if (filter[3] != null && !row.nombre.toLowerCase().includes(filter[3].toLowerCase())) return false
      return true;
    },
    onFiltered(filteredUsers) {
      this.totalRows = filteredUsers.length;
      this.currentPage = 1;
    },
    show() {   
      this.showUsuarios = !this.showUsuarios;
    },
    selectAll(table) {   
      if(table){
        this.$refs.tableSelected.selectAllRows()
      } else{
        this.$refs.tableAll.selectAllRows()
      }    
    },
    clearSelected(table) {
      if(table){
        this.$refs.tableSelected.clearSelected()
      } else{
        this.$refs.tableAll.clearSelected()
      }     
    },
  },
  computed: {
    rows() {
      return this.filteredUsers.length;
    },

  },
  created: function() {
    this.provideAlumnos();
    this.provideUsers();
  },
  mounted() {}
};
</script>