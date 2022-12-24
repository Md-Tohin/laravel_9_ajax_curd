<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel 9 Ajax CURD Operations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>

<body>
    <h1 class="text-danger text-center my-5">Laravel 9 Ajax CURD Operations</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="text-bold ">All Room</h6>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Room Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="show-data">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 id="add-title" class="text-bold ">Add New Room</h6>
                        <h6 id="update-title" class="text-bold ">Update Room</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="hidden" id="room_id" name="room_id">
                            <label for="name" class="form-label">Room Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Pleae Enter Room Name">
                            <div id="name_err" class="form-text text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" id="description"
                                placeholder="Pleae Enter Room Description">
                            <div id="description_err" class="form-text text-danger"></div>
                        </div>
                        <button id="add-btn" class="btn btn-primary">Save Room</button>
                        <button id="update-btn" class="btn btn-primary">Update Room</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $('#add-title').show();
        $('#add-btn').show();
        $('#update-title').hide();
        $('#update-btn').hide();

        function getRoom(){
            $.ajax({
                url: "{{ url('/room/get-rooms') }}",
                type: "get",
                dataType: "json",
                success: function(res){                    
                    $.each(res, function(key,value) {                       
                        let row = `
                            <tr>
                                <th scope="row">${key+1}</th>
                                <td>${value.name}</td>
                                <td>${value.description}</td>
                                <td>
                                    <a href="" data-name="${value.name}" data-id="${value.id}" data-description="${value.description}" id="editBtn" class="btn btn-sm btn-success"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="{{ url('/room/delete/${value.id}') }}" id="delete" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>   
                        `; 
                        $('#show-data').append(row); 
                    });
                },
                error: function(err){
                    console.log(err);
                }
            });
        }
        getRoom();

        //  Store Room 
        $(document).on('click', '#add-btn', function(){
            clearErrorMessage();
            let name = $('#name').val();
            let description = $('#description').val();
            // console.log(name, description);

            $.ajax({
                url: "{{ url('/room/store') }}",
                type: "post",
                data: {name:name, description:description},
                success: function(res){
                    $('#show-data').html('');
                    getRoom();
                    clearInputFields();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    // console.log(res);
                },
                error: function(err){
                    $('#name_err').text(err.responseJSON.errors.name);
                    $('#description_err').text(err.responseJSON.errors.description);
                },
            })
        });

        //  Clear input fields
        function clearInputFields(){
            $('#name').val('');
            $('#description').val('');
        }

        //  Clear errors message
        function clearErrorMessage(){
            $('#name_err').text('');
            $('#description_err').text('');
        }

        //  Edit a room
        $(document).on('click', '#editBtn', function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            $('#add-title').hide();
            $('#add-btn').hide();
            $('#update-title').show();
            $('#update-btn').show();

            let dataId = $(this).data('id');
            let name = $(this).data('name');
            let description = $(this).data('description');
            $('#name').val(name);
            $('#description').val(description);
            $('#room_id').val(dataId);
        });

        //  Update a room
        $(document).on('click', '#update-btn', function(){
            clearErrorMessage();
            let room_id = $('#room_id').val();
            let name = $('#name').val();
            let description = $('#description').val();

            $.ajax({
                url: "{{ url('/room/update') }}",
                type: "post",
                data: {room_id:room_id, name:name, description:description},
                success: function(res){
                    $('#show-data').html('');
                    $('#add-title').show();
                    $('#add-btn').show();
                    $('#update-title').hide();
                    $('#update-btn').hide();
                    getRoom();                    
                    clearInputFields();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1000
                    });
                    // console.log(res);
                },
                error: function(err){
                    console.log(err);
                    $('#name_err').text(err.responseJSON.errors.name);
                    $('#description_err').text(err.responseJSON.errors.description);
                },
            });
        });

        //  delete alert
        $(document).on('click', '#delete', function(e){  
            e.preventDefault();         
            let href = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {                       
                        $.ajax({
                            url: href,
                            type: "get",
                            success: function(res){
                                $('#show-data').html('');
                                getRoom();                                
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: res.message,
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            },
                            error:function(err){
                                console.log(err);
                            }
                        })
                    }
                });
        });
    </script>



</body>

</html>