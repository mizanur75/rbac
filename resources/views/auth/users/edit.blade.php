@extends('layouts.app')

@section('title','Edit User')

@section('body')
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">@yield('title')</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <a href="{{route('users.create')}}" class="btn btn-primary btn-round"> <i class="fa fa-plus"></i> Add User</a>
        <a href="{{route('users.index')}}" class="btn btn-primary btn-round"><i class="fa fa-list"></i> All User</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit User</h4>
            </div>
            
            {!! multi_errors($errors) !!}
            {!! success() !!}
            <form id="exampleValidation" method="post" action="{{route('users.update', $user->id)}}">
                @method('PUT')
                @csrf
                <div class="card-body">
                    <div class="form-group form-show-validation row">
                        <label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">User Name <span class="required-label">*</span></label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name', $user->name)}}" placeholder="Enter Username" required>
                        </div>
                    </div>
                    <div class="form-group form-show-validation row">
                        <label for="Email" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">User Email <span class="required-label">*</span></label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="email" class="form-control" id="Email" name="email" value="{{old('email', $user->email)}}" placeholder="Enter User Email" required>
                        </div>
                    </div>

                    
                    <div class="form-group form-show-validation row">
                        <label for="role" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">{{__('Asign Role')}} <span class="required-label">*</span></label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <select name="roles[]" class="form-control" id="role" multiple>
                                <option selected="false" disabled>Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{$role->name}}" {{in_array($role->name, $user_roles) ? "selected" : ""}}>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success" type="submit"> <i class="fa fa-refresh"></i> Update </button>
                        </div>                                      
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')

@endpush

