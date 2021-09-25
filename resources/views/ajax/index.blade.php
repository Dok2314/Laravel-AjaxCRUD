<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Создать Пост</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


</head>
<body>
    <h1 class="alert alert-info" style="text-align:center;">Создайте Пост</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
            <form class="form-control">
                @csrf
                <span id="addP">Добавить Новый Пост</span>
            <span id="updateP">Обновить Пост</span>
                <div class="form-group">
                <label for="name">Введите Имя:</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Имя">
                </div>
                <span class="text-danger" id="nameError"></span>
                <div class="form-group">
                <label for="email">Введите E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="E-mail">
                </div>
                <span class="text-danger" id="emailError"></span>
                <div class="form-group">
                <label for="message">Введите Имя:</label>
                <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Пост"></textarea>
                </div>
                <span class="text-danger" id="messageError"></span>
                <br>
                <input type="hidden" id="id">
                <button type="submit" id="updateButton" onclick="updateData()" class="btn btn-primary">Обновить</button>
                <button type="submti" id="addButton" onclick="addData()" class="btn btn-success">Создать</button>
            </form>
            </div>
            <div class="col-lg-6">
            <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Имя</th>
      <th scope="col">E-mail</th>
      <th scope="col">Пост</th>
      <th scope="col">Действие</th>
    </tr>
  </thead>
  <tbody>
    
  </tbody>
</table>
            </div>
        </div>
    </div>
<script>
    $('#addP').show();
    $('#addButton').show();
    $('#updateP').hide();
    $('#updateButton').hide();
    
    $.ajaxSetup({
            headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                 }
        });
    function allData(){
        $.ajax({
                type: "GET",
                dataType: "json",
                url: "/posts/all",
                success:function(response){
                    var data = ""
                    $.each(response, function(key,value){
                        data = data + "<tr>"
                        data = data + "<td>"+value.id+"</td>"
                        data = data + "<td>"+value.name+"</td>"
                        data = data + "<td>"+value.email+"</td>"
                        data = data + "<td>"+value.message+"</td>"
                        data = data + "<td>"
                        data = data + "<button class='btn btn-sm btn-primary mr-2' onclick='editData("+value.id+")'>Редактировать</button>"
                        data = data + "<button class='btn btn-sm btn-danger' onclick='deleteData("+value.id+")'>Удалить</button>"
                        data = data + "</td>"
                        data = data + "</tr>"
                    });
                    $('tbody').html(data);
                }
        });
    }
    allData();
    function clearData(){
        $('#name').val('');
        $('#email').val('');
        $('#message').val('');
        $('#nameError').text('');
        $('#emailError').text('');
        $('#messageError').text('');   
    }
    $('#addButton').click(function(e){
            e.preventDefault();
        });
    function addData(){
        var name = $('#name').val();
        var email = $('#email').val();
        var message = $('#message').val(); 
        $.ajax({
            type: "POST",
            dataType: "json",
            data: {name:name,email:email,message:message},
            url: "/posts/create",
            success:function(data){
                allData();
                clearData();
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Пост успешно добавлен!',
                showConfirmButton: false,
                timer: 1500
                })
            },
            error:function(error){
                   $('#nameError').text(error.responseJSON.errors.name);
                    $('#emailError').text(error.responseJSON.errors.email);
                    $('#messageError').text(error.responseJSON.errors.message);
                    Swal.fire({
                    icon: 'error',
                    title: 'Ой...',
                    text: 'Что-то пошло не так!',
                    })
                }
        });
    }
    
    function editData(id){
        $.ajax({
            data: "GET",
            dataType: "json",
            url: "/posts/find/"+id,
            success:function(data){
            $('#addP').hide();
            $('#addButton').hide();
            $('#updateButton').show();
            $('#updateP').show();

            $('#id').val(data.id);
            
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#message').val(data.message);
            console.log(data); 
            }
        });
    }

    $('#updateButton').click(function(e){
            e.preventDefault();
        });
        function updateData(){
            
           var id = $('#id').val();
           var name = $('#name').val();
           var email = $('#email').val();
           var message = $('#message').val(); 

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {name:name,email:email,message:message},
                url: "/posts/update/"+id,
                success:function(data){
                    $('#addP').hide();
                    $('#addButton').hide();
                    $('#updateButton').show();
                    $('#updateP').show();
                    clearData();
                    allData();
                    Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Пост успешно обновлен!',
                    showConfirmButton: false,
                    timer: 1500
                    }) 
                },
                error:function(error){
                    $('#nameError').text(error.responseJSON.errors.name);
                    $('#emailError').text(error.responseJSON.errors.email);
                    $('#messageError').text(error.responseJSON.errors.message);
                    Swal.fire({
                    icon: 'error',
                    title: 'Ой...',
                    text: 'Что-то пошло не так!',
                    })
                }
            }); 
        }
        function deleteData(id){
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/post/delete/"+id,
                success:function(data){
                    $('#addP').show();
                    $('#addButton').show();
                    $('#updateButton').hide();
                    $('#updateP').hide();
                    clearData();
                    allData();
                    Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Пост успешно удален!',
                    showConfirmButton: false,
                    timer: 1500
                    }) 
                    console.log(data);
                },
                error:function(error){
                    console.log(error);
                    Swal.fire({
                    icon: 'error',
                    title: 'Ой...',
                    text: 'Что-то пошло не так!',
                    })
                }   
            }); 
        }
    
    
</script>
</body>
</html>