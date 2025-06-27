@php
    use App\Enums\TemplateCategory;
    use App\Enums\installerReords;
@endphp
<aside class="col-md-3">
        <nav class="bg-dark pt-3">
            <h2 class="text-success ms-3">Menu</h2>
            <ul class="nav flex-column">
            <li class="nav-item py-2 bg-dark">
                <a class="nav-link text-white d-flex align-items-center" href="#"><i class="mdi mdi-dashboard mdi-24px"></i> Dashboard</a>
            </li>

                <li class="nav-item py-2 bg-dark">
<li class="nav-item">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn nav-link text-white d-flex align-items-center border-0 bg-transparent">
            <i class="mdi mdi-logout mdi-24px me-2"></i> Logout
        </button>
    </form>
</li>

                </li>
                <li class="nav-item py-2 bg-dark">
                    <a class="nav-link text-white d-flex align-items-center" href="#"><i class="mdi mdi-currency-gbp mdi-24px"></i> Billing Info</a>
                </li>
               <li class="nav-item py-2 bg-success">
                <a class="nav-link text-white d-flex align-items-center" data-bs-toggle="collapse" href="#authSubmenu" role="button" aria-expanded="false" aria-controls="authSubmenu">
                    </i> Installer QMS (v10) <i class="mdi mdi-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled ps-4 bg-dark" id="authSubmenu">
                @foreach (TemplateCategory::cases() as $category)
                        <li class="nav-item py-1">
                            <a class="nav-link text-white" href="{{ url('/documents/' . $category->value) }}">
                                {{ ucwords($category->value) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
               <li class="nav-item py-2 bg-success">
                <a class="nav-link text-white d-flex align-items-center" data-bs-toggle="collapse" href="#installerSubmenu" role="button" aria-expanded="false" aria-controls="installerSubmenu">
                    </i> Installer Records <i class="mdi mdi-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled ps-4 bg-dark" id="installerSubmenu">
                        <li class="nav-item py-1">
                            <a class="nav-link text-white" href="{{ url('/innstaller-records/projects-folder') }}">
                                GDR01 Projects Folder
                            </a>
                        </li>
                        <li class="nav-item py-1">
                            <a class="nav-link text-white" href="{{ url('/innstaller-records/complaints-records') }}">
                                GDR 06 - Complaints Record
                            </a>
                        </li>
                        <li class="nav-item py-1">
                            <a class="nav-link text-white" href="{{ url('/innstaller-records/personal-skills') }}">
                                GDR07 Personal Skills & Training Record
                            </a>
                        </li>
                        <li class="nav-item py-1">
                            <a class="nav-link text-white" href="{{ url('/innstaller-records/suppliers') }}">
                                GDR08 Approved Suppliers List
                            </a>
                        </li>
                        <li class="nav-item py-1">
                            <a class="nav-link text-white" href="{{ url('/innstaller-records/sub-contractors') }}">
                                GDR09 Approved Subcontractors List
                            </a>
                        </li>
                        <li class="nav-item py-1">
                            <a class="nav-link text-white" href="{{ url('/innstaller-records/company-documents') }}">
                                GDR11 Company Documents
                            </a>
                        </li>
                </ul>
            </li>
            </ul>
        </nav>
    </aside>