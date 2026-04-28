<?php use App\Models\UserData; ?>

@php 
$initial = 1; 
@endphp

@include('linkstack.modules.block-libraries', ['links' => $links])

@foreach($links as $link)
    @if(isset($link->custom_html) && $link->custom_html)
        @if(isset($link->ignore_container) && $link->ignore_container)
        </div></div></div>
        @endif
            @php setBlockAssetContext($link->type); @endphp
            <!-- Large embedding block (like video or heavy custom html) -->
            <div class="bento-item bento-2x2 bento-block-{{ $link->type }}">
                @include('blocks::' . $link->type . '.display', ['link' => $link, 'initial' => $initial++])
            </div>
        @if(isset($link->ignore_container) && $link->ignore_container)
        <div class="container"><div class="row"><div class="column">
        @endif
    @else
        <!-- Individual Bento App / Link Box -->
        <div style="--delay: {{ $initial++ }}s" class="bento-item bento-2x1 bento-link-item button-entrance">
            @switch($link->name)
                @case('icon')
                    @break
                @case('vcard')
                    <a id="{{ $link->id }}" class="bento-button" rel="noopener noreferrer nofollow noindex" href="{{ route('vcard') . '/' . $link->id }}">
                        <span class="bento-icon-wrapper">
                            <img alt="{{ __('vcard') }}" class="icon" src="@if(theme('use_custom_icons') == 'true'){{ url('themes/' . $GLOBALS['themeName'] . '/extra/custom-icons')}}/vcard{{theme('custom_icon_extension')}} @else{{ asset('/assets/linkstack/icons/')}}vcard.svg @endif">
                        </span>
                        <span class="bento-title">{{ $link->title ?: (__('messages.Contact Card') ?? 'Contact Card') }}</span>
                    </a>
                    @break
                
                @case('custom')
                    <a id="{{ $link->id }}" class="bento-button button-custom" rel="noopener noreferrer nofollow noindex" href="{{ $link->link }}" @if((UserData::getData($userinfo->id, 'links-new-tab') != false))target="_blank"@endif >
                        <span class="bento-icon-wrapper">
                            <i style="color: {{$link->custom_icon}}" class="icon fa {{$link->custom_icon}}"></i>
                        </span>
                        <span class="bento-title">{{ $link->title }}</span>
                    </a>
                    @break

                @case('custom_website')
                    <a id="{{ $link->id }}" class="bento-button button-custom_website" rel="noopener" href="{{ $link->link }}" @if((UserData::getData($userinfo->id, 'links-new-tab') != false))target="_blank"@endif >
                        <span class="bento-icon-wrapper">
                            <img alt="{{ $link->name }}" class="icon" src="@if(file_exists(base_path('assets/favicon/icons/').localIcon($link->id))){{url('assets/favicon/icons/'.localIcon($link->id))}}@else{{getFavIcon($link->id)}}@endif" onerror="this.onerror=null; this.src='{{asset('assets/linkstack/icons/website.svg')}}';">
                        </span>
                        <span class="bento-title">{{ $link->title }}</span>
                    </a>
                    @break
                
                @default
                    <a id="{{ $link->id }}" class="bento-button button-{{ $link->name }}" rel="noopener noreferrer nofollow noindex" href="{{ $link->link }}" @if((UserData::getData($userinfo->id, 'links-new-tab') != false))target="_blank"@endif >
                        <span class="bento-icon-wrapper">
                            <img alt="{{ $link->name }}" class="icon" src="@if(theme('use_custom_icons') == 'true'){{ url('themes/' . $GLOBALS['themeName'] . '/extra/custom-icons')}}/{{str_replace('default ','',$link->name)}}{{theme('custom_icon_extension')}} @else{{ asset('/assets/linkstack/icons/') . str_replace('default ','',$link->name) }}.svg @endif">
                        </span>
                        <span class="bento-title">{{ $link->title }}</span>
                    </a>
            @endswitch
        </div>
    @endif
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function handleClickOrTouch(event) {
            let target = event.target.closest('a.bento-button');
            if (target && target.id) {
                var id = target.id;
                if (!sessionStorage.getItem('clicked-' + id)) {
                    var url = '{{ route("clickNumber") }}/' + id;
                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    });
                    sessionStorage.setItem('clicked-' + id, 'true');
                }
            }
        }

        document.addEventListener('mousedown', function (event) {
            if (event.button === 0 || event.button === 1) {
                handleClickOrTouch(event);
            }
        });

        document.addEventListener('touchstart', handleClickOrTouch);
    });
</script>