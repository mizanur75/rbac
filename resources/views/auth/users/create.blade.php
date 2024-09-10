@extends('layouts.app')

@section('title','Add User')

@section('body')
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">@yield('title')</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
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
            <form id="exampleValidation" method="post" action="{{route('users.store')}}">
                @csrf
                <div class="card-body">
                    <div class="form-group form-show-validation row">
                        <label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">User Name <span class="required-label">*</span></label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="Enter User Name" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group form-show-validation row">
                        <label for="Email" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">User Email <span class="required-label">*</span></label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="email" class="form-control" id="Email" name="email" value="{{old('email')}}" placeholder="Enter User Email" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group form-show-validation row">
                        <label for="password" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Password <span class="required-label">*</span></label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group form-show-validation row">
                        <label for="password_confirmation" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Confirm Password <span class="required-label">*</span></label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-Enter Password" required autocomplete="off">
                        </div>
                    </div>

                    
                    <div class="form-group form-show-validation row">
                        <label for="role" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">{{__('Asign Role')}} <span class="required-label">*</span></label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <select name="roles[]" class="form-control" id="role" multiple>
                                <option selected="false" disabled>Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-success" type="submit"> <i class="fa fa-plus"></i> Create </button>
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



<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Users Information') }}
                            </h2>
                            <h2 class="text-lg font-medium text-gray-900">
                                <a href="{{route('users.index')}}">{{ __('User List') }}</a>
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Add your account's users information.") }}
                            </p>
                            @if(Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ Session::get('success') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @endif	
                            @if($errors->any())
                            <div class="col-md-12">
                                @foreach($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ $error }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </header>
                    
                        <form method="post" action="{{ route('users.store') }}" class="mt-6 space-y-6">
                            @csrf
                    
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="block mt-1 w-full"
                                                type="password"
                                                name="password"
                                                required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password"
                                                name="password_confirmation" required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <!-- Asign Role -->
                            <div class="mt-4">
                                <x-input-label for="password_confirmation" :value="__('Asign Role')" />
                                <select name="roles[]" class="block mt-1 w-full" id="" multiple>
                                    <option selected="false" disabled>Select Role</option>
                                    @foreach($roles as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                    
                                @if (session('status') === 'users-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
