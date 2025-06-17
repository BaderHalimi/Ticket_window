@extends('merchant.layouts.app')
@section('content')

<div class="flex-1 p-8">
  <div class="space-y-8">
    <div class="flex justify-between items-center">
      <h2 class="text-3xl font-bold text-slate-800">إعداد الصفحة الخاصة</h2>
      <form method="POST" action="{{ route('merchant.dashboard.update',Auth::id())}}" class="flex items-center space-x-4" enctype="multipart/form-data">
    
        @csrf
        
      <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-600 h-10 px-4 py-2 text-white">
        <svg class="w-4 h-4 ml-2" ...></svg>
        حفظ التغييرات
      </button>
    </div>

    <!-- الشعار والبنرات -->
    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
      <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-xl font-semibold tracking-tight">الشعار والبنرات</h3>
        <p class="text-sm text-slate-500">ارفع شعار علامتك التجارية والبنر الرئيسي لصفحتك.</p>
      </div>
      <div class="p-6 pt-0 grid md:grid-cols-2 gap-6">
        <div class="space-y-2">
          <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">الشعار (Logo)</label>
          <div class="flex items-center gap-4">
            <!-- المعاينة -->
            <div class="w-20 h-20 rounded-full bg-slate-100 overflow-hidden flex items-center justify-center">
              <img id="preview_logo" src="{{ isset(json_decode(Auth::user()->additional_data)->profile_picture) ? asset('storage/' . json_decode(Auth::user()->additional_data)->profile_picture) : '#' }}"
              alt="Preview" class="w-full h-full object-cover {{ isset(json_decode(Auth::user()->additional_data)->profile_picture) ? '' : 'hidden' }}"              >
              <svg id="default_logo_icon" class="w-8 h-8 text-slate-400 {{ isset(json_decode(Auth::user()->additional_data)->profile_picture) ? 'hidden' : '' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
            </div>
        
            <!-- زر الرفع -->
            <label class="cursor-pointer bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm font-medium">
              رفع صورة
              <input type="file" name="profile_picture" class="hidden" accept="image/*" onchange="previewImage(this, 'preview_logo', 'default_logo_icon')">
            </label>
          </div>
        </div>
        
        <div class="space-y-2">
          <label for="banner" class="block text-sm font-medium text-gray-700 mb-2">البنر الرئيسي</label>
          <div class="flex items-center gap-4">
            <div class="w-full h-20 rounded-lg bg-slate-100 overflow-hidden flex items-center justify-center">
              <img id="preview_banner" src="#" alt="Preview" class="w-full h-full object-cover hidden">
              <svg id="default_banner_icon" class="w-8 h-8 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
            </div>
        
            <label class="cursor-pointer bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm font-medium">
              رفع صورة
              <input type="file" name="banner" class="hidden" accept="image/*" onchange="previewImage(this, 'preview_banner', 'default_banner_icon')">
            </label>
          </div>
        </div>
        
      </div>
    </div>
<form>
    <!-- الألوان والقوالب -->
    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
      <div class="flex flex-col space-y-1.5 p-6">
        <h3 class="text-xl font-semibold tracking-tight">الألوان والقوالب</h3>
        <p class="text-sm text-slate-500">اختر القالب والألوان التي تناسب هويتك البصرية.</p>
      </div>
      <div class="p-6 pt-0 space-y-6">

        <!-- اللون الرئيسي -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">اللون الرئيسي</label>
          <div class="flex items-center gap-2 mt-2">
            <div class="w-10 h-10 rounded-lg bg-orange-500 cursor-pointer border-4 border-white ring-2 ring-orange-500"></div>
            <div class="w-10 h-10 rounded-lg bg-rose-500 cursor-pointer"></div>
            <div class="w-10 h-10 rounded-lg bg-amber-500 cursor-pointer"></div>
            <div class="w-10 h-10 rounded-lg bg-slate-800 cursor-pointer"></div>
            <input type="color" value="#ff7842" class="rounded-lg border border-slate-300 w-12 h-10 p-1 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
          </div>
        </div>

        <!-- القوالب -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">اختر القالب</label>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
            <div class="cursor-pointer group">
              <div class="h-24 rounded-lg bg-slate-200 flex items-center justify-center group-hover:ring-2 ring-orange-500 ring-offset-2 transition-all">
                <svg class="w-8 h-8 text-white/50" ...></svg>
              </div>
              <p class="text-center mt-2 font-semibold text-sm">الافتراضي</p>
            </div>
            <div class="cursor-pointer group">
              <div class="h-24 rounded-lg bg-gray-800 flex items-center justify-center group-hover:ring-2 ring-orange-500 ring-offset-2 transition-all">
                <svg class="w-8 h-8 text-white/50" ...></svg>
              </div>
              <p class="text-center mt-2 font-semibold text-sm">المظلم</p>
            </div>
            <div class="cursor-pointer group">
              <div class="h-24 rounded-lg bg-rose-200 flex items-center justify-center group-hover:ring-2 ring-orange-500 ring-offset-2 transition-all">
                <svg class="w-8 h-8 text-white/50" ...></svg>
              </div>
              <p class="text-center mt-2 font-semibold text-sm">الوردي</p>
            </div>
            <div class="cursor-pointer group">
              <div class="h-24 rounded-lg bg-sky-200 flex items-center justify-center group-hover:ring-2 ring-orange-500 ring-offset-2 transition-all">
                <svg class="w-8 h-8 text-white/50" ...></svg>
              </div>
              <p class="text-center mt-2 font-semibold text-sm">السماوي</p>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>


<script>
  function previewImage(input, previewId, iconId) {
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();

      reader.onload = function(e) {
        const preview = document.getElementById(previewId);
        const icon = document.getElementById(iconId);

        preview.src = e.target.result;
        preview.classList.remove('hidden');
        icon.classList.add('hidden');
      }

      reader.readAsDataURL(file);
    }
  }
</script>

@endsection
