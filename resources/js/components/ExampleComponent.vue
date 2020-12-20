<style>
button.page-link {
	display: inline-block;
}
button.page-link {
    font-size: 20px;
    color: #29b3ed;
    font-weight: 500;
}
.offset{
  width: 500px !important;
  margin: 20px auto;  
}
</style>

<template>
    <div class="container">
    
    <div class="row justify-content-end">
        <a role="button" href="getMoviesOMDB"  class="btn btn-primary ">Actualizar base de datos con OMDB API</a>
    </div>
    <br>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                    <h2>Prueba Nativapps</h2>
                    <p>Listado de peliculas que continen en su titulo la palabra 'love' del año 2020. Obtenidos de la 
                    <a href="http://www.omdbapi.com/"> OMDB API</a></p>
                    <p>Desarrolladora :  Angie paola medina cordoba</p>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th>Año</th>
                                    <th>Tipo</th>
                                    <th>Póster</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in displayedMovies">
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.year }}</td>
                                    <td>{{ item.type }}</td>

                                    <td><img v-bind:src="item.image_url" alt="poster" style=" width: 90px;"></td>
                                    
                                </tr>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                <button type="button" class="page-link" v-if="page != 1" @click="page--"> Previous </button>
                                </li>
                                <li class="page-item">
                                <button type="button" class="page-link" v-for="pageNumber in pages.slice(page-1, page+5)" @click="page = pageNumber"> {{pageNumber}} </button>
                                </li>
                                <li class="page-item">
                                <button type="button" @click="page++" v-if="page < pages.length" class="page-link"> Next </button>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
            movies: [],
            page: 1,
            perPage: 9,
            pages: [],  
            }
        },
        methods:{
            setPages () {
                let numberOfPages = Math.ceil(this.movies.length / this.perPage);
                for (let index = 1; index <= numberOfPages; index++) {
                    this.pages.push(index);
                }
            },
            paginate (movies) {
                let page = this.page;
                let perPage = this.perPage;
                let from = (page * perPage) - perPage;
                let to = (page * perPage);
                return  movies.slice(from, to);
            },
        },
        computed: {
            displayedMovies () {
                return this.paginate(this.movies);
            }
        },
        watch: {
            movies () {
                this.setPages();
            }
        },
        created(){
            axios.get('/getMovies')
            .then(res=>{
                this.movies = res.data.data;
                
                if(this.movies.length == 0){
                    alert("No hay datos para mostrar, intente actualizar la base de datos con OMDB API");
                }
            })
            .catch((error) => {
                alert("Error al obtener listado. Intente nuevamente");
            })
        },
    }
</script>
