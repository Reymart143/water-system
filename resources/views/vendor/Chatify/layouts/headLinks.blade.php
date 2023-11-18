<title>Meedo Chat System</title>

{{-- Meta tags --}}
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="id" content="{{ $id }}">
<meta name="messenger-color" content="{{ $messengerColor }}">
<meta name="messenger-theme" content="{{ $dark_mode }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url" content="{{ url('').'/'.config('chatify.routes.prefix') }}" data-user="{{ Auth::user()->id }}">

 <!-- site icon -->
      <link href="data:image/x-icon;base64,AAABAAEAEBAAAAEACABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAAAnagAAZwAHABRCAAAnYAcASwYGAPv/+QA3ZwAAYggDAP78/wAbTgIA//z/AP38+AApagYAI1kAACFmAAD1+PIALy8vAPv//wAEBAQA8//qAPb29gD+//8A////APz/+AAnbAEA9//+APn//gD6//4ATQgAAChpAAASTgAAO0YTAPr6+gAePQgA/v/9AEAnKgD6+/4AImgHAJ2dnQD8/PwAUgUFACBPBAAoaQUAMQcFAPr//ADBwcEA/P7+AP7+/gD//v4AH1AIAClsBQAjaQQA+vv2AF0DAgAnaQQAJWcBAFkFBAD+//sAES0EAP//+wD+/f8A7f3wACdqAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFhYWFhYWFhYWFhYWFhYWFhYWFgEWIAEWFgEWFgEWFhYWFhYWAQEWAQEWAQEvFhYWFhYULRYBCwEBNAEWEBYWFhYWJhYBARYrARYBARYSFhYWFi8BAQEWAQEWKCMBJxYWFhYWLhkBFQEBEQEaMBYWFhY8OgkpATYBATYBMQI6ORYWOgYBNgcfAQE2ATYBNjoWFjoDNQE4NgEBDQQBAQw6FhY6KjYBNhwBAQEeATYYIRYWFzoOJQE2AQE2ATMyOgUWFgoPOjo2Nh03PgA6OiQ7FhYWIiwbOjo2Njo6CDwWFhYWFhYWFjw9OjoTPBYWFhYWFhYWFhYWFhYWFhYWFhYWFgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=" rel="icon" type="image/x-icon">

{{-- scripts --}}
{{-- <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
  <script src="{{ asset('js/chatify/addJs/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/chatify/font.awesome.min.js') }}"></script>
<script src="{{ asset('js/chatify/autosize.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
{{-- <script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script> --}}
<script src="{{ asset('js/chatify/addJs/nprogress@0.2.0.js') }}"></script>

{{-- styles --}}
{{-- <link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/> --}}
<link href="{{ asset('css/chatify/addCss/nprogress@0.2.0.css') }}" rel="stylesheet" />
<link href="{{ asset('css/chatify/style.css') }}" rel="stylesheet" />
<link href="{{ asset('css/chatify/'.$dark_mode.'.mode.css') }}" rel="stylesheet" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />

{{-- Setting messenger primary color to css --}}
<style>
    :root {
        --primary-color: {{ $messengerColor }};
    }
</style>
