@extends('linkstack.layout')

@section('content')
    @push('linkstack-head')
        @include('linkstack.modules.meta')
        @include('linkstack.modules.assets')
        <!-- Inject Custom Bento Grid CSS -->
        <link rel="stylesheet" href="{{ asset('assets/linkstack/css/bento.css') }}">
    @endpush

    @push('linkstack-head-end')
        @foreach($information as $info)
            @include('linkstack.modules.theme')
        @endforeach
    @endpush

    @push('linkstack-body-start')
        @include('linkstack.modules.admin-bar')
        @include('linkstack.modules.share-button')
        @include('linkstack.modules.report-icon')
    @endpush

    @push('linkstack-content')
        <!-- Main Bento Grid Container -->
        <main class="bento-grid" aria-label="{{ __('messages.User Profile') ?? 'User Profile' }}">
            
            <!-- Profile / Bio Box (Large 2x2 Bento Item) -->
            <div class="bento-item bento-profile bento-2x2">
                @foreach($information as $info)
                    <div class="bento-avatar-wrapper">
                        @include('linkstack.elements.avatar')
                    </div>
                    <div class="bento-profile-info">
                        <div class="bento-heading-wrapper">
                            @include('linkstack.elements.heading')
                        </div>
                        <div class="bento-bio-wrapper">
                            @include('linkstack.elements.bio')
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Social Icons (Dynamic Span based on size) -->
            <div class="bento-item bento-icons bento-2x1">
                @include('linkstack.elements.icons')
            </div>

            <!-- Links injected directly via the buttons loop -->
            @include('linkstack.elements.buttons')
            
            @yield('content')
            
        </main>
        
        @include('linkstack.modules.footer')
    @endpush
@endsection