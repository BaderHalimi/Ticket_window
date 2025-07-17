@extends('merchant.layouts.app')
@section('content')

@php
$data = is_array(Auth::guard('merchant')->user()->additional_data??null) ? Auth::guard('merchant')->user()->additional_data : json_decode(Auth::guard('merchant')->user()->additional_data??'', true);
$socialLinks = $data['social_links'] ?? [];
@endphp

<div class="flex-1 p-8">
    <form method="POST" action="{{ route('merchant.dashboard.update', ['id'=>Auth::id()]) }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- الشعار والبنر -->
        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg p-6 space-y-6">
            <h2 class="text-2xl font-bold">الشعار والبانر</h2>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- الشعار -->
                <div class="space-y-2">
                    <label class="block font-medium mb-1">الشعار</label>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-slate-100 rounded-full overflow-hidden flex items-center justify-center">
                            <img id="preview_logo" src="{{ isset($data['profile_picture']) ? asset('storage/' . $data['profile_picture']) : '#' }}"
                                class="w-full h-full object-cover {{ isset($data['profile_picture']) ? '' : 'hidden' }}">
                            <i id="default_logo_icon" class="ri-image-add-line text-2xl text-slate-400 {{ isset($data['profile_picture']) ? 'hidden' : '' }}"></i>
                        </div>
                        <label class="cursor-pointer bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm">
                            رفع صورة
                            <input type="file" name="profile_picture" class="hidden" accept="image/*" onchange="previewImage(this, 'preview_logo', 'default_logo_icon')">
                        </label>
                    </div>
                </div>

                <!-- البنر -->
                <div class="space-y-2">
                    <label class="block font-medium mb-1">البانر</label>
                    <div class="flex items-center gap-4">
                        <div class="w-full h-20 bg-slate-100 rounded-lg overflow-hidden flex items-center justify-center">
                            <img id="preview_banner" src="{{ isset($data['banner']) ? asset('storage/' . $data['banner']) : '#' }}"
                                class="w-full h-full object-cover {{ isset($data['banner']) ? '' : 'hidden' }}">
                            <i id="default_banner_icon" class="ri-image-add-line text-2xl text-slate-400 {{ isset($data['banner']) ? 'hidden' : '' }}"></i>
                        </div>
                        <label class="cursor-pointer bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm">
                            رفع صورة
                            <input type="file" name="banner" class="hidden" accept="image/*" onchange="previewImage(this, 'preview_banner', 'default_banner_icon')">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- روابط التواصل -->
        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg p-6 space-y-4">
            <h2 class="text-2xl font-bold">روابط التواصل الاجتماعي</h2>
            <div id="social-links-container" class="space-y-3">
                @foreach ($socialLinks as $link)
                <div class="flex items-center gap-2 social-input-group">
                    <span class="icon w-6 h-6 text-slate-400 flex items-center justify-center">
                        <i class="ri-global-line"></i>
                    </span>
                    <input name="social_links[]" type="url" value="{{ $link }}" oninput="updateSocialIcon(this)"
                        class="flex-1 border border-slate-300 px-4 py-2 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                        placeholder="https://...">
                    <button type="button" onclick="removeSocialLink(this)" class="text-red-500 hover:text-red-700 text-sm">✕</button>
                </div>
                @endforeach
            </div>

            <div>
                <button type="button" onclick="addSocialLink()" class="text-orange-600 hover:text-orange-800 text-sm flex items-center gap-1">
                    <i class="ri-add-line"></i>
                    إضافة رابط جديد
                </button>
            </div>
            <div class="text-end">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-md">حفظ التغييرات</button>
            </div>
        </div>
    </form>

    <!-- القوالب والألوان -->
    <!-- <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg p-6 space-y-6">
  <h2 class="text-2xl font-bold">الألوان والقوالب</h2>

  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">اختر اللون الرئيسي</label>
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-lg bg-orange-500 ring-2 ring-orange-500"></div>
      <div class="w-10 h-10 rounded-lg bg-blue-500"></div>
      <div class="w-10 h-10 rounded-lg bg-rose-500"></div>
      <div class="w-10 h-10 rounded-lg bg-slate-800"></div>
      <input type="color" value="#ff7842" disabled class="rounded-lg border border-slate-300 w-12 h-10 p-1 opacity-50 cursor-not-allowed">
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-700 mb-2">نماذج القوالب</label>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="cursor-pointer group">
        <div class="h-24 rounded-lg bg-white border flex items-center justify-center group-hover:ring-2 ring-orange-500 transition-all">
          <i class="ri-layout-4-fill text-slate-500 text-2xl"></i>
        </div>
        <p class="text-center mt-2 font-semibold text-sm">القالب الأبيض</p>
      </div>
      <div class="cursor-pointer group">
        <div class="h-24 rounded-lg bg-slate-900 flex items-center justify-center group-hover:ring-2 ring-orange-500 transition-all">
          <i class="ri-layout-4-fill text-white text-2xl"></i>
        </div>
        <p class="text-center mt-2 font-semibold text-sm">القالب الداكن</p>
      </div>
      <div class="cursor-pointer group">
        <div class="h-24 rounded-lg bg-pink-200 flex items-center justify-center group-hover:ring-2 ring-orange-500 transition-all">
          <i class="ri-layout-4-fill text-pink-800 text-2xl"></i>
        </div>
        <p class="text-center mt-2 font-semibold text-sm">الوردي</p>
      </div>
      <div class="cursor-pointer group">
        <div class="h-24 rounded-lg bg-sky-200 flex items-center justify-center group-hover:ring-2 ring-orange-500 transition-all">
          <i class="ri-layout-4-fill text-sky-800 text-2xl"></i>
        </div>
        <p class="text-center mt-2 font-semibold text-sm">السماوي</p>
      </div>
    </div>
  </div>
</div> -->

</div>

<!-- سكريبت المعاينة والتبديل -->
<script>
    function previewImage(input, previewId, iconId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(previewId);
                const icon = document.getElementById(iconId);
                img.src = e.target.result;
                img.classList.remove('hidden');
                icon.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function addSocialLink() {
        const container = document.getElementById('social-links-container');
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 social-input-group';
        div.innerHTML = `
      <span class="icon w-6 h-6 text-slate-400 flex items-center justify-center">
        <i class="ri-add-line"></i>
      </span>
      <input name="social_links[]" type="url" placeholder="https://..." oninput="updateSocialIcon(this)"
             class="flex-1 border border-slate-300 px-4 py-2 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
      <button type="button" onclick="removeSocialLink(this)" class="text-red-500 hover:text-red-700 text-sm">✕</button>
    `;
        container.appendChild(div);
    }

    function removeSocialLink(btn) {
        btn.parentElement.remove();
    }

    function updateSocialIcon(input) {
        const url = input.value.toLowerCase();
        const iconSpan = input.parentElement.querySelector('.icon');
        let iconClass = 'ri-global-line';

        if (url.includes('facebook.com')) iconClass = 'ri-facebook-fill';
        else if (url.includes('twitter.com')) iconClass = 'ri-twitter-x-fill';
        else if (url.includes('instagram.com')) iconClass = 'ri-instagram-line';
        else if (url.includes('tiktok.com')) iconClass = 'ri-tiktok-fill';
        else if (url.includes('youtube.com')) iconClass = 'ri-youtube-fill';

        iconSpan.innerHTML = `<i class="${iconClass}"></i>`;
    }
</script>

<!-- Remix Icon CDN -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

@endsection
