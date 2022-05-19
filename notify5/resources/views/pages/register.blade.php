@extends('layouts.main')
@section('content')

    <section>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h4 class="text-center">Account Register</h4>
                        </div>
                        <div class="card-body">
                            <form id="form-register" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter First Name">
                                </div>
    
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email">
                                </div>

                                <div class="form-group">
                                    <label for="operator"> Operator</label>
                                    <select name="operator" class="form-control" id="operator">
                                        <option value="">-- Operator Option --</option>
                                        <option value="boiler">Boiler</option>
                                        <option value="turbine">Turbine</option>
                                    </select>
                                </div>
    
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
                                </div>

                                <button type="submit" class="btn btn-dark btn-block" id="save_form">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection





@push('javascript')
<script>
        $(document).ready(function() {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#save_form').on('click', function(e) {
                e.preventDefault();
                var name = $("#name").val();
                var operator = $("#operator").val();
                var email = $("#email").val();
                var password = $("#password").val();
    
                $.ajax({
                    type: "POST",
                    url: "store_register",
                    data: $("#form-register").serialize(),
                    success:function(data){
                        if(data.success){
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'green');
                            $('#notifDiv').text(data.success);
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                            $('[name="name"]').val('');
                            $('[name="email"]').val('');
                            $('[name="password"]').val('');
                            
                        } else if(data.exists) {
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'red');
                            $('#notifDiv').text('Email already exists');
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                            $('#password').val('');
                        } else {
                            $('#notifDiv').fadeIn();
                            $('#notifDiv').css('background', 'red');
                            $('#notifDiv').text('An error occured. Please try later');
                            setTimeout(() => {
                                $('#notifDiv').fadeOut();
                            }, 3000);
                        }
                        $(this).text('Save');
                        $(this).removeAttr('disabled');
                            }.bind($(this))
                });       
            });
        });
    </script>
@endpush




