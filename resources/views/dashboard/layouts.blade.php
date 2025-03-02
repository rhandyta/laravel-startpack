
@include("dashboard.partials.header")
{{-- Header --}}

    <div class="main-wrapper main-wrapper-1">
    {{-- Navbar --}}

    @include("dashboard.partials.navbar")

    {{-- Sidebar --}}
    @include("dashboard.partials.sidebar")

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>@yield("title-content")</h1>
          </div>

          <div class="section-body">
            {{-- Content --}}
            @yield("content")
          </div>
        </section>
      </div>


  @yield("modal")

{{-- Footer --}}

@include("dashboard.partials.footer")