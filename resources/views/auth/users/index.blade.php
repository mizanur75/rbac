@extends('layouts.app')

@section('title','Users')

@section('body')
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">@yield('title')</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
        <a href="{{route('users.create')}}" class="btn btn-primary btn-round">Add User</a>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{ __('Users List') }}</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table
            id="basic-datatables"
            class="display table table-striped table-hover"
          >
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              @foreach($data as $d)
                <tr>
                    <td>{{$loop->index +1}}</td>
                    <td>{{$d->name}}</td>
                    <td>{{$d->email}}</td>
                    <td>
                        @if(!empty($d->getRoleNames()))
                            @foreach($d->getRoleNames() as $roleName)
                                <span for="" class="badge badge-success">{{$roleName}}</span>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-sm btn-info" href="{{route('users.edit', $d->id)}}">Edit</a> 
                        <form action="{{route('users.destroy', $d->id)}}" method="post"
                            style="display: inline;"
                            onsubmit="return confirm('Are you Sure? Want to delete')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit"> Delete </button>
                        </form>
                    </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    $("#basic-datatables").DataTable({});
</script>
@endpush
