@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold">Profile</h1>
        <p class="text-gray-600 mt-1">Manage your account information and security.</p>
    </div>
    <div class="space-y-6">
        @include('profile.partials.update-profile-information-form')
        @include('profile.partials.update-password-form')
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
