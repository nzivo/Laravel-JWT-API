<template>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Categories</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Categories</li>
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
                                <h3 class="card-title"><i class="fas fa-list-ol nav-icon"></i> Categories</h3>

                                <div class="card-tools">
                                    <button class="btn btn-primary bg-gradient-primary" @click.prevent="newModal"><i class="fas fa-list-ol"></i> New Category</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category Name</th>
                                            <th>Category Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="category in categories" :key="category.id">
                                            <td>{{category.id}}</td>
                                            <td>{{category.category_name}}</td>
                                            <td>{{category.category_status}}</td>
                                            <td>
                                                <a href="" @click.prevent="editModal(category)">
                                                    <i class="fas fa-edit blue"></i>
                                                </a>
                                                <a href="" @click.prevent="deleteCategory(category.id)">
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


                <!--AddCategory Modal -->
                <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-show="editmode" class="modal-title" id="addCategoryModalLabel">Update Category Details</h5>
                            <h5 v-show="!editmode" class="modal-title" id="addCategoryModalLabel">Create New Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? updateCategory() : createCategory()">

                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="form.category_name" id="category_name" type="text" name="category_name" Placeholder="Category Name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('category_name') }">
                                    <has-error :form="form" field="category_name"></has-error>
                                </div>
                                <div class="form-group">
                                    <textarea v-model="form.category_description" id="category_description" type="category_description" name="category_description" Placeholder="Category Description"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('category_description') }">
                                    </textarea>
                                    <has-error :form="form" field="category_description"></has-error>
                                </div>
                                <div class="form-group">
                                    <select v-model="form.category_status" id="text" name="category_status"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('category_status') }">
                                        <option value="" disabled selected hidden>Choose Status</option>
                                        <option value="Enabled">Enabled</option>
                                        <option value="Disabled">Disabled</option>
                                    </select>
                                    <has-error :form="form" field="category_status"></has-error>
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
                categories: {},
                form: new Form({
                    id: '',
                    category_name : '',
                    category_description : '',
                    category_status : '',
                })
            }
        },
        methods: {
            deleteCategory(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete the Category",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                        if (result.value) {
                            this.form.delete('api/category/'+id).then(()=>{

                                this.$Progress.start()
                                Fire.$emit('reloadCategories');

                                Swal.fire(
                                    'Deleted!',
                                    'Your record has been deleted.',
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
            viewCategories(){
                axios.get("api/category").then(({data}) => (this.categories = data.data));
            },
            createCategory(){
                this.$Progress.start()
                this.form.post('api/category')
                .then(()=>{

                Fire.$emit('reloadCategories');

                $('#addCategoryModal').modal('hide');

                Toast.fire({
                    icon: 'success',
                    title: 'Category Added successfully'
                });

                    this.$Progress.finish()

                }).catch(()=>{
                    this.$Progress.fail()
                });

            },
            updateCategory(id){
                this.$Progress.start()
                this.form.put('api/category/'+ this.form.id).then(() => {

                    $('#addCategoryModal').modal('hide');

                    Swal.fire(
                        'Update!',
                        'Your Record has been updated.',
                        'success'
                    );

                    this.$Progress.finish();

                    Fire.$emit('reloadCategories');

                }).catch(() => {
                    this.$Progress.fail()
                })
            },
            editModal(category){
                this.editmode = true;
                this.form.clear();
                $('#addCategoryModal').modal('show');
                this.form.fill(category);
            },
            newModal(){
                this.editmode = false;
                this.form.clear();
                $('#addCategoryModal').modal('show');
            },
        },
        created() {
            this.viewCategories();
            Fire.$on('reloadCategories',() => {
                this.viewCategories();
            });
        }
    }
</script>
