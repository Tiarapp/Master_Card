@extends('admin.templates.partials.default')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Error {{ $code ?? '500' }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="error-page">
                <div class="error-content">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bug mr-2"></i>
                                Something went wrong
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="lead">{{ $message ?? 'An unexpected error occurred.' }}</p>
                            
                            <div class="mt-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-primary mr-2">
                                    <i class="fas fa-home mr-1"></i>
                                    Back to Dashboard
                                </a>
                                <a href="javascript:history.back()" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Go Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection