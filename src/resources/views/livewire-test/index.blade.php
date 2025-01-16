<html>
  <head>
    @livewireStyles
  </head>
  <body>
    livewireテスト
    @if (session('message'))
      <div class="alert alert-success">
          {{ session('message') }}
      </div>
    @endif
    <livewire:counter /> 
    {{-- @livewire('counter') --}}

    @livewireScripts
  </body>
</html>