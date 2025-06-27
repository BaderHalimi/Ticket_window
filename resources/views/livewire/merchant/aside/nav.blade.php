<nav class="flex flex-col gap-2">
    <a href="{{ route('merchant.dashboard.overview') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.overview') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.overview')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <rect width="7" height="9" x="3" y="3" rx="1"></rect>
            <rect width="7" height="5" x="14" y="3" rx="1"></rect>
            <rect width="7" height="9" x="14" y="12" rx="1"></rect>
            <rect width="7" height="5" x="3" y="16" rx="1"></rect>
        </svg><span>نظرة عامة</span>
    </a>
    <a href="{{ route('merchant.dashboard.offer.index') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.offer.index') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.offer.index')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
            <path d="M13 5v2"></path>
            <path d="M13 17v2"></path>
            <path d="M13 11v2"></path>
        </svg><span>إدارة الخدمات</span>
    </a>
    <a href="{{ route('merchant.dashboard.reservations.index') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.reservations.index') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.reservations.index')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
            <path d="M12 11h4"></path>
            <path d="M12 16h4"></path>
            <path d="M8 11h.01"></path>
            <path d="M8 16h.01"></path>
        </svg><span>إدارة الحجوزات</span>
    </a>
    <a href="{{ route('merchant.dashboard.checking') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.checking') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.checking')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <rect width="5" height="5" x="3" y="3" rx="1"></rect>
            <rect width="5" height="5" x="16" y="3" rx="1"></rect>
            <rect width="5" height="5" x="3" y="16" rx="1"></rect>
            <path d="M21 16h-3a2 2 0 0 0-2 2v3"></path>
            <path d="M21 21v.01"></path>
            <path d="M12 7v3a2 2 0 0 1-2 2H7"></path>
            <path d="M3 12h.01"></path>
            <path d="M12 3h.01"></path>
            <path d="M12 16v.01"></path>
            <path d="M16 12h1"></path>
            <path d="M21 12v.01"></path>
            <path d="M12 21v-1"></path>
        </svg><span>التحقق</span>
    </a>
    <a href="{{ route('merchant.dashboard.pos') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.pos') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.pos')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
            <rect width="12" height="8" x="6" y="14"></rect>
        </svg><span>البيع الداخلي (POS)</span>
    </a>
    <a href="{{ route('merchant.dashboard.social_reservation') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.social_reservation') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.social_reservation')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect>
            <path d="M9 22v-4h6v4"></path>
            <path d="M8 6h.01"></path>
            <path d="M16 6h.01"></path>
            <path d="M12 6h.01"></path>
            <path d="M12 10h.01"></path>
            <path d="M12 14h.01"></path>
            <path d="M16 10h.01"></path>
            <path d="M16 14h.01"></path>
            <path d="M8 10h.01"></path>
            <path d="M8 14h.01"></path>
        </svg><span>نظام الحجز الجماعي</span>
    </a>
    <a href="{{ route('merchant.dashboard.offers_codes') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.offers_codes') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.offers_codes')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path>
            <path d="M7 7h.01"></path>
        </svg><span>العروض والأكواد</span>
    </a>
    <a href="{{route('merchant.dashboard.customer_reviews')}}" wire:click.prevent="intended('{{ route('merchant.dashboard.customer_reviews') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.customer_reviews')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
        </svg><span>مراجعات العملاء</span>
    </a>
    <a href="{{route('merchant.dashboard.reports_analysis') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.reports_analysis') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.reports_analysis')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <path d="M3 3v18h18"></path>
            <path d="M18 17V9"></path>
            <path d="M13 17V5"></path>
            <path d="M8 17v-3"></path>
        </svg><span>التقارير والتحليلات</span>
    </a>
    <a href="{{ route('merchant.dashboard.intelligence_analytics') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.intelligence_analytics') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.intelligence_analytics')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <path d="M12 4.5a2.5 2.5 0 0 0-4.96-.46 2.5 2.5 0 0 0-1.98 3 2.5 2.5 0 0 0-1.32 4.24 3 3 0 0 0 .34 5.58 2.5 2.5 0 0 0 2.96 3.08 2.5 2.5 0 0 0 4.91.05L12 20V4.5Z"></path>
            <path d="M16 8V5c0-1.1.9-2 2-2"></path>
            <path d="M12 13h4"></path>
            <path d="M12 18h6a2 2 0 0 1 2 2v1"></path>
            <path d="M12 8h8"></path>
            <path d="M20.5 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"></path>
            <path d="M16.5 13a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"></path>
            <path d="M20.5 21a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"></path>
            <path d="M18.5 3a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"></path>
        </svg><span>الذكاء والتحليلات</span>
    </a>
    <a href="{{ route('merchant.dashboard.notification_management') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.notification_management') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.notification_management')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
        </svg><span>إدارة الإشعارات</span>
    </a>
    <a href="{{ route('merchant.dashboard.message_center')}}" wire:click.prevent="intended('{{  route('merchant.dashboard.message_center') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.message_center')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg><span>مركز الرسائل</span>
    </a>
    <a href="{{ route('merchant.dashboard.withdraws.index')}}" wire:click.prevent="intended('{{ route('merchant.dashboard.withdraws.index') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.withdraws.index')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"></path>
            <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"></path>
            <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"></path>
        </svg><span>المحفظة والسحب</span>
    </a>
    <a href="{{ route('merchant.dashboard.branch.index')}}" wire:click.prevent="intended('{{ route('merchant.dashboard.branch.index') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.branch.index')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <line x1="6" x2="6" y1="3" y2="15"></line>
            <circle cx="18" cy="6" r="3"></circle>
            <circle cx="6" cy="18" r="3"></circle>
            <path d="M18 9a9 9 0 0 1-9 9"></path>
        </svg><span>إدارة الفروع</span>
    </a>
    <a href="{{ route('merchant.dashboard.team_management')}}" wire:click.prevent="intended('{{ route('merchant.dashboard.team_management') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.team_management')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
        </svg><span>إدارة الفريق</span>
    </a>
    <a href="{{ route('merchant.dashboard.page_setup')}}" wire:click.prevent="intended('{{ route('merchant.dashboard.page_setup') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.page_setup')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <circle cx="13.5" cy="6.5" r=".5"></circle>
            <circle cx="17.5" cy="10.5" r=".5"></circle>
            <circle cx="8.5" cy="7.5" r=".5"></circle>
            <circle cx="6.5" cy="12.5" r=".5"></circle>
            <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"></path>
        </svg><span>إعداد الصفحة</span>
    </a>
    <a href="{{route('merchant.dashboard.policies_settings') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.policies_settings')  }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.policies_settings')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <circle cx="6" cy="13" r="3"></circle>
            <path d="m9.7 14.4-.9-.3"></path>
            <path d="m3.2 11.9-.9-.3"></path>
            <path d="m4.6 16.7.3-.9"></path>
            <path d="m7.6 16.7-.4-1"></path>
            <path d="m4.8 10.3-.4-1"></path>
            <path d="m2.3 14.6 1-.4"></path>
            <path d="m8.7 11.8 1-.4"></path>
            <path d="m7.4 9.3-.3.9"></path>
            <path d="M14 2v6h6"></path>
            <path d="M4 5.5V4a2 2 0 0 1 2-2h8.5L20 7.5V20a2 2 0 0 1-2 2H6a2 2 0 0 1-2-1.5"></path>
        </svg><span>السياسات والإعدادات</span>
    </a>
    <a href="{{ route('merchant.dashboard.languages_translation') }}" wire:click.prevent="intended('{{ route('merchant.dashboard.languages_translation') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.languages_translation')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
            <path d="M2 12h20"></path>
        </svg><span>اللغات والترجمة</span>
    </a>
    <a href="{{route('merchant.dashboard.api')}}" wire:click.prevent="intended('{{route('merchant.dashboard.api') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.api')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <polyline points="16 18 22 12 16 6"></polyline>
            <polyline points="8 6 2 12 8 18"></polyline>
        </svg><span>API والتكاملات</span>
    </a>
    <a href="{{route('merchant.dashboard.activity_log')}}" wire:click.prevent="intended('{{ route('merchant.dashboard.activity_log') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if(Route::is('merchant.dashboard.activity_log')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
            <path d="M3 3v5h5"></path>
            <path d="M12 7v5l4 2"></path>
        </svg><span>سجل الأنشطة</span>
    </a>
</nav>
