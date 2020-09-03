<template>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Book Types</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Book Types</li>
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
                                <h3 class="card-title"><i class="fas fa-stream nav-icon"></i> Book Types</h3>

                                <div class="card-tools">
                                    <button class="btn btn-primary bg-gradient-primary" @click.prevent="newModal"><i class="fas fa-stream"></i> New Book Type</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="bookType in bookTypes" :key="bookType.id">
                                            <td>{{bookType.id}}</td>
                                            <td>{{bookType.type_name }}</td>
                                            <td>{{bookType.category}}</td>
                                            <td>
                                                <a href="" @click.prevent="editModal(bookType)">
                                                    <i class="fas fa-edit blue"></i>
                                                </a>
                                                <a href="" @click.prevent="deleteBookType(bookType.id)">
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


                <!--AddBookType Modal -->
                <div class="modal fade" id="addBookTypeModal" tabindex="-1" role="dialog" aria-labelledby="addBookTypeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-show="editmode" class="modal-title" id="addBookTypeModalLabel">Update Book Type Details</h5>
                            <h5 v-show="!editmode" class="modal-title" id="addBookTypeModalLabel">Create New Book Type</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? updateBookType() : createBookType()">

                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="form.type_name" id="name" type="text" name="type_name" Placeholder="Full Names"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('type_name') }">
                                    <has-error :form="form" field="type_name"></has-error>
                                </div>
                                <div class="form-group">
                                    <textarea v-model="form.type_description" id="type_description" type="type_description" name="type_description" Placeholder="Category Type Description"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('type_description') }">
                                    </textarea>
                                    <has-error :form="form" field="type_description"></has-error>
                                </div>
                                <div class="form-group">
                                    <select v-model="form.category_id" id="text" name="category_id"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }">
                                        <option value="" disabled selected hidden>Choose Category</option>
                                        <option v-for="category in categories" :value="category.id" :key="category.id">{{category.category_name}}</option>
                                    </select>
                                    <has-error :form="form" field="category_id"></has-error>
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
                bookTypes: {},
                categories: {},
                form: new Form({
                    id: '',
                    type_name : '',
                    type_description : '',
                    category_id : '',
                    category : ''
                })
            }
        },
        methods: {
            deleteBookType(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete the Book Type",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                        if (result.value) {
                            this.form.delete('api/bookType/'+id).then(()=>{

                                this.$Progress.start()
                                Fire.$emit('reloadBookTypes');

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
            viewBookTypes(){
                axios.get("api/bookType").then(({data}) => (this.bookTypes = data.data));
            },
            viewCategories(){
                axios.get("api/category").then(({data}) => (this.categories = data.data));
            },
            createBookType(){
                this.$Progress.start()
                this.form.post('api/bookType')
                .then(()=>{

                Fire.$emit('reloadBookTypes');

                $('#addBookTypeModal').modal('hide');

                Toast.fire({
                    icon: 'success',
                    title: 'Book Type Registered successfully'
                });

                    this.$Progress.finish()

                }).catch(()=>{
                    this.$Progress.fail()
                });

            },
            updateBookType(id){
                this.$Progress.start()
                this.form.put('api/bookType/'+ this.form.id).then(() => {

                    $('#addBookTypeModal').modal('hide');

                    Swal.fire(
                        'Update!',
                        'Your Record has been updated.',
                        'success'
                    );

                    this.$Progress.finish();

                    Fire.$emit('reloadBookTypes');

                }).catch(() => {
                    this.$Progress.fail()
                })
            },
            editModal(bookType){
                this.form.clear();
                this.editmode = true;
                $('#addBookTypeModal').modal('show');
                this.form.fill(bookType);
            },
            newModal(){
                this.form.clear();
                this.editmode = false;
                $('#addBookTypeModal').modal('show');
            },
        },
        created() {
            this.viewBookTypes();
            this.viewCategories();
            Fire.$on('reloadBookTypes',() => {
                this.viewBookTypes();
            });
        }
    }
</script>
