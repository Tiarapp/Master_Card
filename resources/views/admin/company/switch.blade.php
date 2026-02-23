@extends('admin.templates.master')

@section('title', 'Company Management')
@section('header', 'Company Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Current Company Info -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Current Company Information</h3>
                </div>
                <div class="card-body">
                    @if($currentUser->company)
                        <div class="row">
                            <div class="col-md-6">
                                <h4>{{ $currentUser->company->name }}</h4>
                                <p><strong>Address:</strong> {{ $currentUser->company->address ?? 'Not set' }}</p>
                                <p><strong>Phone:</strong> {{ $currentUser->company->phone ?? 'Not set' }}</p>
                                <p><strong>Email:</strong> {{ $currentUser->company->email ?? 'Not set' }}</p>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <h5>No Company Assigned</h5>
                            <p>You are not currently assigned to any company. Please contact your administrator or choose a company below.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Switch Company -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Switch Company (Demo Purpose)</h3>
                </div>
                <div class="card-body">
                    <p>For testing purposes, you can switch between different companies to see how menu access changes.</p>
                    <div class="row">
                        @foreach($companies as $company)
                            <div class="col-md-6 mb-3">
                                <div class="card {{ $currentUser->company_id == $company->id ? 'card-success' : 'card-default' }}">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            {{ $company->name }}
                                            @if($currentUser->company_id == $company->id)
                                                <span class="badge badge-success">Current</span>
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Address:</strong> {{ $company->address ?? 'Not set' }}</p>
                                        <p><strong>Phone:</strong> {{ $company->phone ?? 'Not set' }}</p>
                                        <p><strong>Email:</strong> {{ $company->email ?? 'Not set' }}</p>
                                        @if($currentUser->company_id != $company->id)
                                            <form action="{{ route('company.switch', $company->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Switch to This Company</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Menu Structure Preview -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Current Menu Structure</h3>
                </div>
                <div class="card-body">
                    <div id="menu-structure">
                        <p>Loading menu structure...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load menu structure
    fetch('{{ route('company.info') }}')
        .then(response => response.json())
        .then(data => {
            const menuDiv = document.getElementById('menu-structure');
            if (data.error) {
                menuDiv.innerHTML = '<div class="alert alert-warning">' + data.error + '</div>';
            } else {
                let menuHtml = '<ul class="list-group">';
                data.menu_structure.forEach(menu => {
                    menuHtml += '<li class="list-group-item">';
                    menuHtml += '<i class="' + menu.icon + '"></i> ' + menu.name;
                    if (menu.submenus && menu.submenus.length > 0) {
                        menuHtml += '<ul class="list-group list-group-flush mt-2">';
                        menu.submenus.forEach(submenu => {
                            menuHtml += '<li class="list-group-item">';
                            menuHtml += '<i class="' + submenu.icon + '"></i> ' + submenu.name;
                            menuHtml += '</li>';
                        });
                        menuHtml += '</ul>';
                    }
                    menuHtml += '</li>';
                });
                menuHtml += '</ul>';
                
                if (data.menu_structure.length === 0) {
                    menuHtml = '<div class="alert alert-info">No menus available for current company and division.</div>';
                }
                
                menuDiv.innerHTML = menuHtml;
            }
        })
        .catch(error => {
            document.getElementById('menu-structure').innerHTML = '<div class="alert alert-danger">Error loading menu structure</div>';
        });
});
</script>
@endsection