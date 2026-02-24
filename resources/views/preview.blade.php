@extends('layouts.guest')

@section('title', 'UI Preview — EasyColoc')

@section('content')
  <div class="flex flex-col gap-6">
    <div class="bg-white rounded-xl shadow p-6">
      <h1 class="text-2xl font-semibold text-black-600">UI Preview</h1>
      <p class="mt-2 text-black-500">هذه الصفحة فقط لعرض واجهات Blade بدون أي منطق. اربطها بـ <code class="px-2 py-1 bg-gray-100 rounded">Route::view</code>.</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
      @php
        $items = [
          ['/', 'Landing (welcome)'],
          ['/login', 'Login'],
          ['/register', 'Register'],
          ['/dashboard', 'Dashboard'],
          ['/colocations', 'Colocations list'],
          ['/colocations/create', 'Create colocation'],
          ['/colocations/1', 'Colocation show'],
          ['/colocations/1/expenses', 'Expenses list'],
          ['/colocations/1/expenses/create', 'Create expense'],
          ['/expenses/1/edit', 'Edit expense'],
          ['/categories', 'Categories list'],
          ['/categories/create', 'Create category'],
          ['/categories/1/edit', 'Edit category'],
          ['/settlements', 'Qui doit à qui'],
          ['/admin', 'Admin dashboard'],
          ['/invitations/create', 'Send invitation'],
          ['/invite/EXAMPLE_TOKEN', 'Accept invitation (token)'],
        ];
      @endphp

      @foreach($items as [$href, $label])
        <a href="{{ url($href) }}" class="group bg-white rounded-xl shadow hover:shadow-md transition p-5 border border-gray-100">
          <div class="text-sm text-black-500">Route</div>
          <div class="mt-1 font-semibold text-black-600 group-hover:text-orange-500">{{ $label }}</div>
          <div class="mt-2 text-xs text-black-500"><span class="px-2 py-1 bg-gray-100 rounded">{{ $href }}</span></div>
        </a>
      @endforeach
    </div>

    <div class="bg-white rounded-xl shadow p-6">
      <h2 class="text-lg font-semibold text-black-600">Quick routes snippet</h2>
      <pre class="mt-3 text-xs bg-gray-900 text-gray-100 rounded-xl p-4 overflow-x-auto"><code>{{ "
" }}Route::view('/ui', 'preview');{{ "
" }}// Example: Route::view('/dashboard', 'dashboard.index');{{ "
" }}</code></pre>
    </div>
  </div>
@endsection
