<?php

return [

    /*
    |--------------------------------------------------------------------------
    | نصوص التطبيق المخصصة
    |--------------------------------------------------------------------------
    |
    | ملف الترجمة هذا يحتوي على النصوص المخصصة للتطبيق
    | والتي لا تندرج تحت ملفات الترجمة الأساسية الأخرى.
    |
    */

    // نصوص عامة
    'welcome' => 'مرحباً',
    'hello' => 'أهلاً',
    'goodbye' => 'وداعاً',
    'thank_you' => 'شكراً لك',
    'please' => 'من فضلك',
    'yes' => 'نعم',
    'no' => 'لا',
    'ok' => 'موافق',
    'cancel' => 'إلغاء',
    'save' => 'حفظ',
    'edit' => 'تعديل',
    'delete' => 'حذف',
    'create' => 'إنشاء',
    'update' => 'تحديث',
    'view' => 'عرض',
    'back' => 'رجوع',
    'next' => 'التالي',
    'previous' => 'السابق',
    'submit' => 'إرسال',
    'search' => 'بحث',
    'filter' => 'تصفية',
    'sort' => 'ترتيب',
    'loading' => 'جاري التحميل...',
    'success' => 'نجح',
    'error' => 'خطأ',
    'warning' => 'تحذير',
    'info' => 'معلومات',

    // نصوص الخدمات
    'services' => [
        'title' => 'الخدمات',
        'create' => 'إنشاء خدمة جديدة',
        'edit' => 'تعديل الخدمة',
        'delete' => 'حذف الخدمة',
        'view' => 'عرض الخدمة',
        'list' => 'قائمة الخدمات',
        'no_services' => 'لا توجد خدمات',
        'service_created' => 'تم إنشاء الخدمة بنجاح',
        'service_updated' => 'تم تحديث الخدمة بنجاح',
        'service_deleted' => 'تم حذف الخدمة بنجاح',
    ],

    // نصوص الفعاليات
    'events' => [
        'title' => 'الفعاليات',
        'create' => 'إنشاء فعالية جديدة',
        'edit' => 'تعديل الفعالية',
        'delete' => 'حذف الفعالية',
        'view' => 'عرض الفعالية',
        'list' => 'قائمة الفعاليات',
        'no_events' => 'لا توجد فعاليات',
        'event_created' => 'تم إنشاء الفعالية بنجاح',
        'event_updated' => 'تم تحديث الفعالية بنجاح',
        'event_deleted' => 'تم حذف الفعالية بنجاح',
    ],

    // نصوص المستخدمين
    'users' => [
        'title' => 'المستخدمون',
        'profile' => 'الملف الشخصي',
        'settings' => 'الإعدادات',
        'logout' => 'تسجيل الخروج',
        'login' => 'تسجيل الدخول',
        'register' => 'التسجيل',
        'dashboard' => 'لوحة التحكم',
    ],

    // نصوص النماذج
    'forms' => [
        'required_fields' => 'الحقول المطلوبة',
        'optional_fields' => 'الحقول الاختيارية',
        'fill_required_fields' => 'يرجى ملء جميع الحقول المطلوبة',
        'form_saved' => 'تم حفظ النموذج بنجاح',
        'form_error' => 'حدث خطأ في النموذج',
        'invalid_input' => 'مدخل غير صالح',
        'field_required' => 'هذا الحقل مطلوب',
    ],

    // نصوص الحالات
    'status' => [
        'active' => 'نشط',
        'inactive' => 'غير نشط',
        'pending' => 'في الانتظار',
        'approved' => 'موافق عليه',
        'rejected' => 'مرفوض',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
        'draft' => 'مسودة',
        'published' => 'منشور',
    ],

    // نصوص التواريخ والأوقات
    'datetime' => [
        'today' => 'اليوم',
        'yesterday' => 'أمس',
        'tomorrow' => 'غداً',
        'this_week' => 'هذا الأسبوع',
        'last_week' => 'الأسبوع الماضي',
        'next_week' => 'الأسبوع القادم',
        'this_month' => 'هذا الشهر',
        'last_month' => 'الشهر الماضي',
        'next_month' => 'الشهر القادم',
        'this_year' => 'هذا العام',
        'last_year' => 'العام الماضي',
        'next_year' => 'العام القادم',
    ],

    // نصوص الأخطاء
    'errors' => [
        'general' => 'حدث خطأ عام',
        'not_found' => 'غير موجود',
        'unauthorized' => 'غير مصرح',
        'forbidden' => 'محظور',
        'validation_failed' => 'فشل في التحقق',
        'server_error' => 'خطأ في الخادم',
        'network_error' => 'خطأ في الشبكة',
        'timeout' => 'انتهت المهلة الزمنية',
    ],

    // نصوص النجاح
    'success' => [
        'operation_completed' => 'تمت العملية بنجاح',
        'data_saved' => 'تم حفظ البيانات بنجاح',
        'data_updated' => 'تم تحديث البيانات بنجاح',
        'data_deleted' => 'تم حذف البيانات بنجاح',
        'email_sent' => 'تم إرسال البريد الإلكتروني بنجاح',
        'file_uploaded' => 'تم رفع الملف بنجاح',
    ],

    // نصوص التأكيد
    'confirmations' => [
        'are_you_sure' => 'هل أنت متأكد؟',
        'delete_confirmation' => 'هل أنت متأكد من أنك تريد حذف هذا العنصر؟',
        'save_confirmation' => 'هل تريد حفظ التغييرات؟',
        'cancel_confirmation' => 'هل تريد إلغاء العملية؟',
        'logout_confirmation' => 'هل تريد تسجيل الخروج؟',
    ],

    // نصوص الأمان
    'security' => [
        'dangerous_content' => 'محتوى خطير',
        'xss_detected' => 'تم اكتشاف محاولة XSS',
        'sql_injection_detected' => 'تم اكتشاف محاولة SQL Injection',
        'invalid_characters' => 'أحرف غير صالحة',
        'content_blocked' => 'تم حظر المحتوى',
        'security_threat' => 'تهديد أمني',
    ],

    // نصوص الملفات
    'files' => [
        'upload' => 'رفع ملف',
        'download' => 'تحميل',
        'delete' => 'حذف الملف',
        'file_too_large' => 'الملف كبير جداً',
        'invalid_file_type' => 'نوع ملف غير صالح',
        'upload_failed' => 'فشل في رفع الملف',
        'upload_success' => 'تم رفع الملف بنجاح',
    ],

    // نصوص البحث
    'search' => [
        'search_results' => 'نتائج البحث',
        'no_results' => 'لا توجد نتائج',
        'search_placeholder' => 'ابحث هنا...',
        'advanced_search' => 'بحث متقدم',
        'clear_search' => 'مسح البحث',
    ],

    // نصوص التصفح
    'navigation' => [
        'home' => 'الرئيسية',
        'about' => 'حول',
        'contact' => 'اتصل بنا',
        'help' => 'مساعدة',
        'faq' => 'الأسئلة الشائعة',
        'terms' => 'الشروط والأحكام',
        'privacy' => 'سياسة الخصوصية',
    ],

];
