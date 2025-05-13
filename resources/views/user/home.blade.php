@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <aside class="col-md-3">
        <nav class="bg-dark pt-3">
            <h2 class="text-success ms-3">Menu</h2>
            <ul class="nav flex-column">
            <li class="nav-item py-2 bg-dark">
                <a class="nav-link text-white d-flex align-items-center" href="#"><i class="mdi mdi-dashboard mdi-24px"></i> Dashboard</a>
            </li>

                <li class="nav-item py-2 bg-dark">
                    <a class="nav-link text-white d-flex align-items-center" href="#"><i class="mdi mdi-logout mdi-24px"></i> Logout</a>
                </li>
                <li class="nav-item py-2 bg-dark">
                    <a class="nav-link text-white d-flex align-items-center" href="#"><i class="mdi mdi-currency-gbp mdi-24px"></i> Billing Info</a>
                </li>
                <li class="nav-item py-2 bg-success d-flex align-items-center">
                    <a class="nav-link text-white" href="#">Customizing Authentication Views</a>
                </li>
            </ul>
        </nav>
    </aside>
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
                    <p class="mt-3">{{ Auth::user()->org }}</p>
                    <p class="mt-3">{{ Auth::user()->street }}</p>
                    <p class="mt-3">{{ Auth::user()->district }}</p>
                    <p class="mt-3">{{ Auth::user()->city }}</p>
                    <p class="mt-3">{{ Auth::user()->postal_code }}</p>
                </div>
                <div class="col-sm-4 border-end border-1">
                  <h4 class="text-success">Nominee</h4>
                  <p class="mt-3">{{ Auth::user()->name }}</p>
                </div>
                <div class="col-sm-4">
                <h4 class="text-success">Quarterly Newsletters</h4>
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
                    <tr>
                        <td>R11</td>
                        <td>Caunce O'Hara</td>
                        <td>2025-06-04</td>
                        <td>View</td>		
                    </tr>
                    <tr>
                        <td>R11</td>
                        <td>Caunce O'Hara</td>
                        <td>2025-06-04</td>
                        <td>View</td>		
                    </tr>
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
@endsection