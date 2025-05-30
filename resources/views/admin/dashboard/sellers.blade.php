@extends('admin.layouts.app')
@section('title', 'Merchants - ')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
<style>
    .glassmorphism {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
    }
</style>
@endpush

@section('sub_content')
<div class="py-6">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Merchants</h2>

    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="shadow-lg rounded-lg glassmorphism overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-100 to-purple-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Shop Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">City</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-gray-800">
                        <tr class="hover:bg-purple-50 transition">
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4">Mohamed Salem</td>
                            <td class="px-6 py-4">Salem Electronics</td>
                            <td class="px-6 py-4">01012345678</td>
                            <td class="px-6 py-4">Cairo</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button title="عرض" class="inline-flex items-center justify-center text-sm text-white bg-indigo-500 hover:bg-indigo-600 px-2 py-1 rounded-full transition">
                                    <i class="ri-eye-line text-base"></i>
                                </button>
                                <button title="تعديل" class="inline-flex items-center justify-center text-sm text-white bg-green-500 hover:bg-green-600 px-2 py-1 rounded-full transition">
                                    <i class="ri-pencil-line text-base"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- مزيد من التجار -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
