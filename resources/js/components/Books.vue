<template>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Books</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Books</li>
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
                                <h3 class="card-title"><i class="fas fa-book nav-icon"></i> Books</h3>

                                <div class="card-tools">
                                    <button class="btn btn-primary bg-gradient-primary" @click.prevent="newModal"><i class="fas fa-book"></i> New Book</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cover</th>
                                            <th>Name</th>
                                            <th>Author</th>
                                            <th>Year</th>
                                            <th>Type</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="book in books" :key="book.id">
                                            <td>{{book.id}}</td>
                                            <td>
                                                <div class="avatar img-fluid img-circle" style="margin-top:10px">
                                                    <img style="height:64px;width:40px" v-bind:src="'img/books/' + book.book_photo"/>
                                                </div>
                                            </td>
                                            <td>{{book.book_name | upperCase}}</td>
                                            <td>{{book.book_author | upperCase}}</td>
                                            <td>{{book.book_year }}</td>
                                            <td>{{book.type_name | upperCase}}</td>
                                            <td>{{book.category | upperCase}}</td>
                                            <td>{{book.book_status | upperCase}}</td>
                                            <td>
                                                <a href="" @click.prevent="editModal(book)">
                                                    <i class="fas fa-edit blue"></i>
                                                </a>
                                                <a href="" @click.prevent="deleteBook(book.id)">
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


                <!--AddBook Modal -->
                <div class="modal fade" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="addBookModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 v-show="editmode" class="modal-title" id="addBookModalLabel">Update Book Details</h5>
                            <h5 v-show="!editmode" class="modal-title" id="addBookModalLabel">Create New Book</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? updateBook() : createBook()">

                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="form.book_name" id="book_name" type="text" name="book_name" Placeholder="Book Title"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('book_name') }">
                                    <has-error :form="form" field="book_name"></has-error>
                                </div>
                                <div class="form-group">
                                    <textarea v-model="form.book_description" id="book_description" type="book_description" name="book_description" Placeholder="Book Description"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('book_description') }">
                                    </textarea>
                                    <has-error :form="form" field="book_description"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.book_author" id="book_author" type="text" name="book_author" Placeholder="Book Author"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('book_author') }">
                                    <has-error :form="form" field="book_author"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.book_publisher" id="book_publisher" type="text" name="book_publisher" Placeholder="Book Publisher"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('book_publisher') }">
                                    <has-error :form="form" field="book_publisher"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.book_pages" id="book_pages" type="text" name="book_pages" Placeholder="No of Pages"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('book_pages') }">
                                    <has-error :form="form" field="book_pages"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.book_year" id="book_year" type="text" name="book_year" Placeholder="Year of Publication"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('book_year') }">
                                    <has-error :form="form" field="book_year"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.catalogue_no" id="catalogue_no" type="text" name="catalogue_no" Placeholder="Book Catalogue Number"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('catalogue_no') }">
                                    <has-error :form="form" field="catalogue_no"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.accession_no" id="accession_no" type="text" name="accession_no" Placeholder="Book Accession Number"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('accession_no') }">
                                    <has-error :form="form" field="accession_no"></has-error>
                                </div>
                                <div class="form-group">
                                    <select v-model="form.book_status" id="book_status" name="book_status"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('book_status') }">
                                        <option value="" disabled selected hidden>Available ?</option>
                                        <option value="Available">Available</option>
                                        <option value="Not Available">Not Available</option>
                                        <option value="Not Available">Not Available</option>
                                        <option value="Not Available">Not Available</option>
                                    </select>
                                    <has-error :form="form" field="book_status"></has-error>
                                </div>
                                <div class="form-group">
                                    <select v-model="form.category_id" id="category_id" name="category_id"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }">
                                        <option value="" disabled selected hidden>Choose Category</option>
                                        <option v-for="category in categories" :value="category.id" :key="category.id">{{category.category_name}}</option>
                                    </select>
                                    <has-error :form="form" field="category_id"></has-error>
                                </div>
                                <div class="form-group">
                                    <select v-model="form.book_type_id" id="book_type_id" name="book_type_id"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('book_type_id') }">
                                        <option value="" disabled selected hidden>Choose Category Type</option>
                                        <option v-for="bookType in bookTypes" :value="bookType.id" :key="bookType.id">{{bookType.type_name}}</option>
                                    </select>
                                    <has-error :form="form" field="book_type_id"></has-error>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <input type="file" @change='upload_avatar' :class="{ 'is-invalid': form.errors.has('book_photo') }" name="book_photo">
                                        <has-error :form="form" field="avatar"></has-error>
                                        <div class="avatar img-fluid img-circle" style="margin-top:10px">
                                            <!-- <img v-bind:src="get_avatar()" v-bind:style="form.styleObject"/> -->
                                        </div>
                                    </div>
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
                books: {},
                bookTypes: {},
                categories: {},
                form: new Form({
                    id: '',
                    book_photo: '',
                    book_name : '',
                    book_description : '',
                    book_author : '',
                    book_publisher : '',
                    book_pages : '',
                    book_year : '',
                    catalogue_no : '',
                    accession_no : '',
                    book_status : '',
                    category_id : '',
                    book_type_id : '',

                    styleObject: {
                        width: '128px',
                        height: '80px'
                    }
                })
            }
        },
        methods: {
            deleteBook(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete the Book",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {

                        if (result.value) {
                            this.form.delete('api/book/'+id).then(()=>{

                                this.$Progress.start()
                                Fire.$emit('reloadBooks');

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
            viewBooks(){
                axios.get("api/book").then(({data}) => (this.books = data.data));
            },
            viewCategories(){
                axios.get("api/category").then(({data}) => (this.categories = data.data));
            },
            viewBookTypes(){
                axios.get("api/bookType",{
                 params: {
                   category_id: this.category
                 }
              }).then(({data}) => (this.bookTypes = data.data));
            },
            createBook(){
                this.$Progress.start()
                this.form.post('api/book')
                .then(()=>{

                Fire.$emit('reloadBooks');

                $('#addBookModal').modal('hide');

                Toast.fire({
                    icon: 'success',
                    title: 'Book Registered successfully'
                });

                    this.$Progress.finish();

                    this.form.reset();

                }).catch(()=>{
                    this.$Progress.fail()
                });

            },
            upload_avatar(e){
              let book_photo = e.target.files[0];
                let reader = new FileReader();

                if(book_photo['size'] < 2111775)
                {
                    reader.onloadend = (book_photo) => {
                    //console.log('RESULT', reader.result)
                     this.form.book_photo = reader.result;
                    }
                     reader.readAsDataURL(book_photo);
                }else{
                    alert('File size can not be bigger than 2 MB')
                }
            },
             //For getting Instant Uploaded Photo
            // get_avatar(){
            //    let photo = (this.form.book_photo.length > 100) ? this.form.book_photo : "img/books/"+ this.form.book_photo;
            //    return photo;
            // },
            updateBook(id){
                this.$Progress.start()
                this.form.put('api/book/'+ this.form.id).then(() => {

                    $('#addBookModal').modal('hide');

                    Swal.fire(
                        'Update!',
                        'Your Record has been updated.',
                        'success'
                    );

                    this.$Progress.finish();

                    Fire.$emit('reloadBooks');

                    this.form.reset();

                }).catch(() => {
                    this.$Progress.fail()
                })
            },
            editModal(book){
                this.viewBookTypes();
                this.viewCategories();
                this.editmode = true;
                this.form.clear();
                $('#addBookModal').modal('show');
                this.form.fill(book);
            },
            newModal(){
                this.form.reset();
                this.editmode = false;
                $('#addBookModal').modal('show');
                this.viewBookTypes();
                this.viewCategories();
            },
        },
        created() {
            this.viewBooks();
            Fire.$on('reloadBooks',() => {
                this.viewBooks();
            });
        }
    }
</script>
