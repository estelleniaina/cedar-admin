@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')
  <div class="card">
    <h5 class="card-header">Gestion des centres</h5>
    <div class="table-responsive text-nowrap">
      <table class="table table-striped">
        <thead>
        <tr>
          <th>Nom</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody class="table-border-bottom-0">
        @foreach($centres as $centre)
          <tr>
            <td>{{ $centre["nom"] }}</td>
            <td>
              <a>
                <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
              </a>
              <a>
                <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
              </a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
