<template>
    <div class="container">
        <div class="card mt-5" v-if="$gate.isAdmin()">
            <div class="card-header border-transparent">
                <h1 class="card-title mt-2">Comenzi</h1>

                <div class="card-tools">
                    <button type="button" class="btn btn-success" @click="newModal">
                        <i class="fas fa-user-plus fa-fw"></i> Adauga Comanda
                    </button>

                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>


                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0" style="display: block;">

                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                        <tr>
                            <th>Nume</th>
                            <th>Email</th>
                            <th>Tip</th>
                            <th>Descriere</th>
                            <th>Data inceput</th>
                            <th>Actiuni</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{user.email}}</td>
                            <td>{{user.type | upText}}</td>
                            <td>{{user.bio}}</td>
                            <td>{{user.data | myDate}}</td>
                            <td>
                                <button @click="editModal(user)" class="btn btn-sm btn-success"><i class="fa fa-edit blue"></i></button>
                                <button @click="deleteUser(user.id)" class="btn btn-sm btn-danger"><i class="fa fa-trash red"></i></button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <pagination :data="users" @pagination-change-page="getResults">
                    <span slot="prev-nav">&lt; Pagina Precedenta</span>
                    <span slot="next-nav">Pagina Urmatoare &gt;</span>
                </pagination>
            </div>
        </div>

        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="utilizatorNou" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="utilizatorNouLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5  class="modal-title" v-show="!editmode" id="utilizatorNouLabel">Adauga Utilizator Nou</h5>
                        <h5  class="modal-title" v-show="editmode" id="utilizatorNouLabel">Editeaza Utilizator</h5>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-window-close"></i> </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                    <div class="modal-body">
                        <div class="form-group">
                            <input v-model="form.name" type="text" name="name" placeholder="Nume"
                                   class="form-control " :class="{ 'is-invalid': form.errors.has('name') }" >
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <input v-model="form.email" type="text" name="email" placeholder="Email"
                                   class="form-control " :class="{ 'is-invalid': form.errors.has('email') }" >
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <input v-model="form.password" type="password" name="password" placeholder="Parola"
                                   class="form-control " :class="{ 'is-invalid': form.errors.has('password') }" >
                            <has-error :form="form" field="password"></has-error>
                        </div>

                        <div class="form-group">
                            <textarea v-model="form.bio" type="text" name="bio" id="bio" placeholder="Bio (Optional)"
                                      class="form-control " :class="{ 'is-invalid': form.errors.has('bio') }" ></textarea>
                            <has-error :form="form" field="bio"></has-error>
                        </div>

                        <div class="form-group">
                            <select v-model="form.type" id="type" name="type"
                                    class="form-control " :class="{ 'is-invalid': form.errors.has('type') }" >

                                <option value="">Alege tip utilizator</option>
                                <option value="admin">Administrator</option>
                                <option value="user">Angajat</option>

                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Renunta</button>
                        <button v-show="!editmode" type="submit" class="btn btn-success">Adauga</button>
                        <button v-show="editmode" type="submit" class="btn btn-primary">Editeaza</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

export default {

        data(){

            return{
                editmode: false,
                users: {},
                form: new Form(
                    {
                        id:'',
                        name: '',
                        email: '',
                        password:'',
                        type:'',
                        bio:'',
                        photo:'',
                    }
                )
            }
        },

        methods:{
            getResults(page = 1) {
                axios.get('api/user?page=' + page)
                    .then(response => {
                        this.users = response.data;
                    });
            },
            getProfilePhoto(){

                let photo = (this.form.photo.length > 200) ? this.form.photo : "./img/profile/"+ this.form.photo ;
                return photo;
            },
            updateUser(id){

                Swal.fire({
                    title: 'Esti sigur?',
                    text: "Datele modificate nu mai pot fi refacute",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Actualizeaza'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //Trimite request catre server pentru stergere
                        this.$Progress.start();
                        //console.log('Merge Boss');
                            this.form.put('api/user/'+this.form.id)
                            .then(() => {
                                Swal.fire(
                                    'Actualizat!',
                                    'Datele au fost modificate',
                                    'success'
                                );
                                this.$Progress.finish();
                                $('#utilizatorNou').modal('hide');
                                Fire.$emit('Eveniment');
                            })
                            .catch(() => {
                                this.$Progress.fail();
                                Swal.fire(
                                    'Ceva nu a functionat!',
                                    'Datele NU au fost modificate!',
                                    'warning'
                                );
                            });
                    }
                });
            },
            editModal(user){
                this.editmode=true;
                this.form.clear();
                this.form.reset();
                $('#utilizatorNou').modal('show');
                this.form.fill(user);
            },
            newModal(){
                this.editmode=false;
                this.form.reset();
                $('#utilizatorNou').modal('show');
            },

            loadUsers(){
                if(this.$gate.isAdmin()) {
                    axios.get("api/user").then(({data}) => (this.users = data));
                }
            },
            deleteUser(id){
                Swal.fire({
                    title: 'Esti sigur?',
                    text: "Datele sterse nu mai pot fi recuperate",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Da, sterge!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //Trimite request catre server pentru stergere
                        this.form.delete('api/user/' + id)
                            .then(() => {
                            Swal.fire(
                                'Sters!',
                                'Contul a fost sters.',
                                'success'
                            );
                            Fire.$emit('Eveniment');
                        })
                            .catch(() => {
                            Swal.fire(
                                'Ceva nu a functionat!',
                                'Contul NU a fost sters!',
                                'warning'
                            );
                        });
                    }
                });
            },


            createUser(){

                this.$Progress.start();
                this.form.post('/api/user') // trimite catre baza de date
                    .then(()=>{
                        //Notificare pentru creare cont


                        Fire.$emit('Eveniment'); //creaza eveniment ca sa faca refresh la tabel

                        $('#utilizatorNou').modal('hide'); // ascunde modal creare cont

                        toast.fire({
                            icon: 'success',
                            title: 'Creat cu Succes'
                        });
                    })
                    .catch(()=>{

                        });

                    this.$Progress.finish();
            }
        },

        created() {
            Fire.$on('Cautare',()=>{
                let query=this.$parent.search;
                axios.get('api/findUser?q='+ query)
                .then((data)=>{
                    this.users=data.data;
                })
                .catch(()=>{
                    toast.fire({
                        icon: 'warning',
                        title: 'Nu exista intrari care sa corespunda cautarii tale!'
                    });
                })
            });
            this.loadUsers();
            //Actionam refresh pentru custom event de mai sus
            Fire.$on('Eveniment',()=>{
                this.loadUsers();
            });

        }
    }
</script>
