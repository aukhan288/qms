@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
        <a href=""><img src="https://qms.easy-pasplus.com/templates/easypasplus_qms/images/competent-person-dashboard.png" alt=""></a>
        <div class="mt-5">
            <h3 class="text-success">My Account</h3>
            <hr>
            <div class="row">
                <div class="col-sm-4 border-end border-1">
                    <h4 class="text-success">Business Details</h4>
                    <span>
                    <img src="{{ Storage::url(Auth::user()->profile_pic) }}" class="img-fluid" alt="Profile Picture" />
                    </span>
                    <p class="mt-3">{{ Auth::user()->org }} <br>
                    {{ Auth::user()->street }} <br>
                    {{ Auth::user()->district }} <br>
                    {{ Auth::user()->city }} <br>
                    {{ Auth::user()->postal_code }}</p>
                </div>
                <div class="col-sm-4 border-end border-1">
                  <h4 class="text-success">Nominee</h4>
                  <p class="mt-3">{{ Auth::user()->name }}</p>
                </div>
                <div class="col-sm-4">
                <h4 class="text-success">Quarterly Newsletters</h4>
                @foreach($newsletters as $nl)
               
                 <a style="
                 text-decoration: none;
    color: #55A850;
    word-break: break-word;
    -webkit-hyphens: auto;
    -moz-hyphens: auto;
    hyphens: auto;
    font-size:12px;
    font-weight:700
                 " 
                 onclick="downloadFile('{{ $nl->id }}');  return false;"
                 href="{{ Storage::url($nl->file_path) }}">{{ $nl->name }}</a><br>
                @endforeach 
                </div>
            </div>
            <hr>
            <h3 class="text-success">Notification Center</h3>
            <hr>
            <h5 class="text-success">Upcoming Renewals</h5>
            <table class="table table-sm table-striped">
                <thead>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Renewal Date</th>
                    <th>Options</th>
                </thead>
                <tbody>
                    <tr>
                        <td>R11</td>
                        <td>Caunce O'Hara</td>
                        <td>2025-06-04</td>
                        <td>View</td>		
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
   

</script>
@endsection