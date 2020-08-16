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
                                    <button class="btn btn-primary bg-gradient-primary" data-toggle="modal" data-target="#addUserModal"><i class="fas fa-user-plus"></i> New User</button>
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
                                            <th>Level</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>183</td>
                                            <td>John Doe</td>
                                            <td>11-7-2014</td>
                                            <td><span class="tag tag-success">Approved</span></td>
                                            <td>
                                                <a href="">
                                                    <i class="fas fa-edit blue"></i>
                                                </a>
                                                <a href="">
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
                            <h5 class="modal-title" id="addUserModalLabel">Create New User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="createUser">

                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="form.name" id="name" type="text" name="name" Placeholder="First Name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.last_name" id="last_name" type="text" name="last_name" Placeholder="Last Name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }">
                                    <has-error :form="form" field="last_name"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.email" id="email" type="email" name="email" Placeholder="Email Address"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                <div class="form-group">
                                    <select v-model="form.type" id="text" name="type" Placeholder="User Level"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                        <option value="admin">Admin</option>
                                        <option value="director">Director</option>
                                        <option value="user">Standard User</option>
                                    </select>
                                    <has-error :form="form" field="type"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.password" type="password" name="password" Placeholder="Password"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
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
    import Form from 'vform'

    export default {
        data() {
            return{
                form: new Form({
                    name : '',
                    last_name : '',
                    photo : '',
                    email : '',
                    type : ''
                })
            }
        },
        methods: {
            createUser(){
                // this.form.post('api/register');
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
