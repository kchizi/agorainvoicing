@extends('themes.default1.layouts.master')
@section('content')

<div class="row">
    
    <div class="col-md-12">

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>


    <div class="col-md-6">


        {!! Form::model($user,['url'=>'profile', 'method' => 'PATCH','files'=>true]) !!}


        <div class="box box-primary">

            <div class="content-header">

                <h4>{{Lang::get('message.profile')}}	{!! Form::submit(Lang::get('message.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

            </div>

            <div class="box-body">



                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{{Lang::get('message.alert')}}!</b> {{Lang::get('message.success')}}.
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('success')}}
                </div>
                @endif
                <!-- fail message -->
                @if(Session::has('fails'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{{Lang::get('message.alert')}}!</b> {{Lang::get('message.failed')}}.
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('fails')}}
                </div>
                @endif

                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <!-- first name -->
                    {!! Form::label('first_name',Lang::get('message.first_name')) !!}
                    {!! Form::text('first_name',null,['class' => 'form-control']) !!}

                </div>

                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                    <!-- last name -->
                    {!! Form::label('last_name',Lang::get('message.last_name')) !!}
                    {!! Form::text('last_name',null,['class' => 'form-control']) !!}

                </div>


                <div class="form-group">
                    <!-- email -->
                    {!! Form::label('email',Lang::get('message.email')) !!}
                    <div>
                        {{$user->email}}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                    <!-- company -->
                    {!! Form::label('company',Lang::get('message.company')) !!}
                    {!! Form::text('company',null,['class' => 'form-control']) !!}

                </div>

                <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                    <!-- mobile -->
                    {!! Form::label('mobile',Lang::get('message.mobile')) !!}
                    {!! Form::text('mobile',null,['class' => 'form-control']) !!}

                </div>

                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <!-- phone number -->
                    {!! Form::label('address',Lang::get('message.address')) !!}
                    {!! Form::textarea('address',null,['class' => 'form-control']) !!}

                </div>
                
                <div class="form-group {{ $errors->has('currency') ? 'has-error' : '' }}">
                    <!-- mobile -->
                    {!! Form::label('currency',Lang::get('message.currency')) !!}
                    {!! Form::select('currency',DB::table('currencies')->lists('name','id'),null,['class' => 'form-control']) !!}

                </div>

                <div class="form-group {{ $errors->has('town') ? 'has-error' : '' }}">
                    <!-- mobile -->
                    {!! Form::label('town',Lang::get('message.town')) !!}
                    {!! Form::text('town',null,['class' => 'form-control']) !!}

                </div>

                <div class="row">

                    <div class="col-md-6 form-group {{ $errors->has('state') ? 'has-error' : '' }}">
                        <!-- mobile -->
                        {!! Form::label('state',Lang::get('message.state')) !!}
                        {!! Form::text('state',null,['class' => 'form-control']) !!}

                    </div>

                    <div class="col-md-6 form-group {{ $errors->has('zip') ? 'has-error' : '' }}">
                        <!-- mobile -->
                        {!! Form::label('zip',Lang::get('message.zip')) !!}
                        {!! Form::text('zip',null,['class' => 'form-control']) !!}

                    </div>
                </div>


                <div class="form-group {{ $errors->has('profile_pic') ? 'has-error' : '' }}">
                    <!-- profile pic -->
                    {!! Form::label('profile_pic',Lang::get('message.profile-picture')) !!}
                    {!! Form::file('profile_pic') !!}

                </div>

                {!! Form::token() !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">



        {!! Form::model($user,['url'=>'password' , 'method' => 'PATCH']) !!}



        <div class="box box-primary">

            <div class="content-header">

                <h4>{{Lang::get('message.change-password')}}	{!! Form::submit(Lang::get('message.save'),['class'=>'form-group btn btn-primary pull-right'])!!}</h4>

            </div>

            <div class="box-body">
                @if(Session::has('success1'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{{Lang::get('message.alert')}}!</b> {{Lang::get('message.success')}}.
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('success')}}
                </div>
                @endif
                <!-- fail message -->
                @if(Session::has('fails1'))
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{{Lang::get('message.alert')}}!</b> {{Lang::get('message.failed')}}.
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{Session::get('fails')}}
                </div>
                @endif
                <!-- old password -->
                <div class="form-group has-feedback {{ $errors->has('old_password') ? 'has-error' : '' }}">
                    {!! Form::label('old_password',Lang::get('message.old_password')) !!}
                    {!! Form::password('old_password',['placeholder'=>'Password','class' => 'form-control']) !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <!-- new password -->
                <div class="form-group has-feedback {{ $errors->has('new_password') ? 'has-error' : '' }}">
                    {!! Form::label('new_password',Lang::get('message.new_password')) !!}
                    {!! Form::password('new_password',['placeholder'=>'New Password','class' => 'form-control']) !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <!-- cofirm password -->
                <div class="form-group has-feedback {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                    {!! Form::label('confirm_password',Lang::get('message.confirm_password')) !!}
                    {!! Form::password('confirm_password',['placeholder'=>'Confirm Password','class' => 'form-control']) !!}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

            </div>
        </div>
    </div>
</div>


{!! Form::close() !!}
@stop