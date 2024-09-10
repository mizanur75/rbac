@extends('layouts.app')

@section('title','Permissions')

@section('body')
<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <h6 class="op-7 mb-2">@yield('title')</h6>
    </div>
    <div class="ms-md-auto py-2 py-md-0">
      <a href="{{route('permissions.index')}}" class="btn btn-primary btn-round">Permission List</a>
    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Permission</h4>
                </div>
                <form id="exampleValidation" method="post" action="{{route('permissions.store')}}">
                    @csrf
                    <div class="card-body">
                        {!! multi_errors($errors) !!}
                        {!! success() !!}
                        <div class="form-group form-show-validation row">
                            <label for="name" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Permission Name <span class="required-label">*</span></label>
                            <div class="col-lg-4 col-md-9 col-sm-8">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Username" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-success" type="submit"> Save </button>
                            </div>                                      
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">All Permission</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
                id="basic-datatables"
                class="display table table-striped table-hover"
              >
                <thead>
                  <tr>
                    <th>Permissions Name</th>
                    <th>Guard Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $d)
                    <tr>
                        <td>{{$d->name}}</td>
                        <td>{{$d->guard_name}}</td>
                        <td>
                            <a class="btn btn-padding btn-sm btn-info" href="{{route('permissions.edit', $d->id)}}">Edit</a> 
                            <form action="{{route('permissions.destroy', $d->id)}}" method="post"
                                style="display: inline;"
                                onsubmit="return confirm('Are you Sure? Want to delete')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-padding btn-sm btn-danger" type="submit"> Delete </button>
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
