<template>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
        <div class="container-fluid">

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-users nav-icon"></i> Users</h3>

                                <div class="card-tools">
                                    <button class="btn btn-primary bg-gradient-primary" @click.prevent="newModal"><i class="fas fa-user-plus"></i> New User</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Occupation</th>
                                            <th>Registered on</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in users" :key="user.id">
                                            <td>{{user.id}}</td>
                                            <td>{{user.name | upperCase}}</td>
                                            <td>{{user.email}}</td>
                                            <td>{{user.occupation }}</td>
                                            <td>{{user.created_at | customDate}}</td>
                                            <td>
                                                <a href="" @click.prevent="editModal(user)">
                                                    <i class="fas fa-edit blue"></i>
                                                </a>
                                                <a href="" @click.prevent="deleteUser(user.id)">
                                                    <i class="fas fa-trash red"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>


                <!--AddUser Modal -->
                <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-show="editmode" class="modal-title" id="addUserModalLabel">Update User Details</h5>
                            <h5 v-show="!editmode" class="modal-title" id="addUserModalLabel">Create New User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? updateUser() : createUser()">

                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="form.name" id="name" type="text" name="name" Placeholder="Full Names"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.email" id="email" type="email" name="email" Placeholder="Email Address"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.phone" id="phone" type="text" name="phone" Placeholder="2547********"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                                    <has-error :form="form" field="phone"></has-error>
                                </div>
                                <div class="form-group">
                                    <select v-model="form.occupation" id="text" name="occupation"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('occupation') }">
                                        <option value="" disabled selected hidden>Choose Occupation</option>
                                        <option value="Student">Student</option>
                                        <option value="Professional">Professional</option>
                                    </select>
                                    <has-error :form="form" field="occupation"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.institution" id="institution" type="text" name="institution" Placeholder="Institution"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('institution') }">
                                    <has-error :form="form" field="institution"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.password" type="password" name="password" Placeholder="Password"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button v-show="editmode" type="submit" class="btn btn-info">Update</button>
                                <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                            </div>

                        </form>

                        </div>
                    </div>
                </div>


            </div>

        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->

    </div>
  <!-- /.content-wrapper -->
</template>

<script>
    import Form from 'vform';
    import Swal from 'sweetalert2/src/sweetalert2.js';

    export default {
        data() {
            return{
                editmode: false,
                users: {},
                form: new Form({
                    id: '',
                    name : '',
                    email : '',
                    phone : '',
                    occupation : '',
                    institution : '',
                    password : ''
                })
            }
        },
        methods: {
            deleteUser(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete the user",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                        if (result.value) {
                            this.form.delete('api/user/'+id).then(()=>{

                                this.$Progress.start()
                                Fire.$emit('reloadUsers');

                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );

                                this.$Progress.finish()
                            })
                            .catch(()=>{
                                Swal.fire(
                                    'Error!',
                                    'You are not allowed to delete the entry.',
                                    'warning'
                                )
                            });
                    }
                })
            },
            viewUsers(){
                axios.get("api/user").then(({data}) => (this.users = data.data));
            },
            createUser(){
                this.$Progress.start()
                this.form.post('api/user')
                .then(()=>{

                Fire.$emit('reloadUsers');

                $('#addUserModal').modal('hide');

                Toast.fire({
                    icon: 'success',
                    title: 'User Registered successfully'
                });

                    this.$Progress.finish()

                }).catch(()=>{
                    this.$Progress.fail()
                });

            },
            updateUser(id){
                this.$Progress.start()
                this.form.put('api/user/'+ this.form.id).then(() => {

                    $('#addUserModal').modal('hide');

                    Swal.fire(
                        'Update!',
                        'Your Record has been updated.',
                        'success'
                    );

                    this.$Progress.finish();

                    Fire.$emit('reloadUsers');

                }).catch(() => {
                    this.$Progress.fail()
                })
            },
            editModal(user){
                this.editmode = true;
                this.form.clear();
                $('#addUserModal').modal('show');
                this.form.fill(user);
            },
            newModal(){
                this.editmode = false;
                this.form.clear();
                $('#addUserModal').modal('show');
            },
        },
        created() {
            this.viewUsers();
            Fire.$on('reloadUsers',() => {
                this.viewUsers();
            });
        }
    }
</script>
