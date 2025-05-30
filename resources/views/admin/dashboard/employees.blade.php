@extends('admin.layouts.app')
@section('title', 'Employees - ')

@push('styles')
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
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Employees</h2>

    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="shadow-lg rounded-lg glassmorphism overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-100 to-purple-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Role
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-gray-800">
                        <tr class="hover:bg-purple-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">1</td>
                            <td class="px-6 py-4 whitespace-nowrap">Ahmed Ali</td>
                            <td class="px-6 py-4 whitespace-nowrap">ahmed@example.com</td>
                            <td class="px-6 py-4 whitespace-nowrap">Manager</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button class="text-sm text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-lg transition">Edit</button>
                                <button class="text-sm text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg transition">Delete</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-purple-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">2</td>
                            <td class="px-6 py-4 whitespace-nowrap">Sara Youssef</td>
                            <td class="px-6 py-4 whitespace-nowrap">sara@example.com</td>
                            <td class="px-6 py-4 whitespace-nowrap">HR</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button class="text-sm text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-lg transition">Edit</button>
                                <button class="text-sm text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg transition">Delete</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-purple-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">3</td>
                            <td class="px-6 py-4 whitespace-nowrap">Khaled Mansour</td>
                            <td class="px-6 py-4 whitespace-nowrap">khaled@example.com</td>
                            <td class="px-6 py-4 whitespace-nowrap">Support</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button class="text-sm text-white bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-lg transition">Edit</button>
                                <button class="text-sm text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg transition">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
