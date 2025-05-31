@extends('seller.layouts.app')
@section('title', 'Dashboard - Edit Event')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <i class="ri-edit-line text-primary text-2xl"></i> Edit Event
    </h2>

    <form action="{{ route('seller.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <!-- Image -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="image">
                <i class="ri-image-line mr-1"></i> Event Image
            </label>
            <input type="file" name="image" id="image" class="w-full p-3 border border-gray-300 rounded-lg" />
            @if($event->image)
                <img src="{{ asset($event->image) }}" alt="Event Image" class="w-32 h-32 mt-2 object-cover rounded">
            @endif
        </div>

        <!-- Name -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="name">
                <i class="ri-font-size"></i> Name
            </label>
            <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}"
                class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
        </div>

        <!-- Description -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="description">
                <i class="ri-file-text-line"></i> Description
            </label>
            <textarea name="description" id="description" rows="4"
                class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">{{ old('description', $event->description) }}</textarea>
        </div>

        <!-- Category -->
        <div>
            <label for="category_id" class="block text-gray-700 font-medium mb-2">
                <i class="ri-price-tag-3-line"></i> Category
            </label>
            <select name="category_id" id="category_id"
                class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Date -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="date">
                <i class="ri-calendar-line"></i> Date
            </label>
            <input type="datetime-local" name="date" id="date"
                value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i')) }}"
                class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
        </div>

        <!-- Location -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="location">
                <i class="ri-map-pin-line"></i> Location
            </label>
            <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}"
                class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
        </div>

        <!-- Total Tickets -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="total_tickets">
                <i class="ri-ticket-line"></i> Total Tickets
            </label>
            <input type="number" name="total_tickets" id="total_tickets" value="{{ old('total_tickets', $event->total_tickets) }}"
                class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
        </div>

        <!-- Ticket Price -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="ticket_price">
                <i class="ri-cash-line"></i> Ticket Price
            </label>
            <input type="number" name="ticket_price" step="0.01" id="ticket_price" value="{{ old('ticket_price', $event->ticket_price) }}"
                class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
        </div>

        <!-- Status -->
        <div>
            <label class="block text-gray-700 font-medium mb-2" for="status">
                <i class="ri-checkbox-circle-line"></i> Status
            </label>
            <select name="status" id="status"
                class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="active" {{ $event->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $event->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit"
                class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                <i class="ri-save-line mr-1"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection



