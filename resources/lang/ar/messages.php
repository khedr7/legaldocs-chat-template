<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Messages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    //Auth msgs
    'passwordChangedSuccessfully'    => 'تم تغيير كلمة المرور بنجاح',
    'userSuccessfullyRegistered'     => 'تم تسجيل المستخدم بنجاح',
    'userSuccessfullySignedIn'       => 'تم تسجيل الدخول بنجاح',
    'userSuccessfullySignedOut'      => 'تم تسجيل الخروج بنجاح',
    'newPasswordError'               => 'كلمة المرور الجديدة لا يمكن ان تكون مماثلة للقديمة . يرجى إعادة المحاولة',
    'currentPasswordIncorrect'       => 'كلمة المرور الحالية لا تتطابق مع التي تم ادخالها. يرجى إعادة المحاولة',
    'passwordConfirmationNotMatch'   => 'تأكيد كلمة المرور غير متطابقة. يرجى إعادة المحاولة',
    'credentialsError'               => 'خطأ في الرقم الوطني او كلمة المرور',
    'incorrect_password'             => 'كلمة السر خاطئة',

    'Unauthorized'                   => 'لا تملك صلاحيات للقيام بهذا الإجراء',
    'Unauthenticated'                => 'الرجاء تسجيل الدخول اولاً',

    'blockedUser'                    => 'المستخدم محظور',

    // General msgs
    'dataAddedSuccessfully'          => 'تمت إضافة البيانات بنجاح',
    'dataUpdatedSuccessfully'        => 'تم تعديل البيانات بنجاح',
    'dataFetchedSuccessfully'        => 'تم جلب البيانات بنجاح',
    'mediaFetchedSuccessfully'       => 'تم جلب الميديا بنجاح',
    'dataDeletedSuccessfully'        => 'تم حذف البيانات بنجاح',

    'dataCanNotBeDeleted'            => 'لا يمكنك حذف البيانات',


    'objectNotFoundF'                => ':object غير موجودة',
    'objectNotFound'                 => ':object غير موجود',


    //General errors

    'routeNotFound'                  => 'الرابط غير موجود',

    'VerificationCompletedSuccessfully' => 'تم التحقق بنجاح',
    'ThephoneNumberOrEmailAlreadyExists' => 'رقم الهاتف او الأيميل موجود مسبقا',

    //booking
    'bookingSuccessfully'            => 'تم الحجز بنجاح',
    'SorryYouCannotChangeTheBookingStatus' => 'عذراً لا يمكنك تغيير حالة الحجز',
    'TheRestauranIsClosedInThisTime' => '.المطعم مغلق في هذا الوقت',
    'TheServiceIsNotAvailableInThisDate' => '.الخدمة غير متاحة في هذا الوقت',



    'YourBookingPendingSuccessfully' => 'تم تقديم حجزك بنجاح وهو في انتظار الموافقة. ستتلقى رسالة إلكترونية بالتأكيد بمجرد تأكيد الحجز.',
    'YourBookingConfirmedSuccessfully' => 'تم تأكيد حجزك بنجاح. ستتلقى رسالة إلكترونية بجميع تفاصيل حجزك.',
    'YourBookingCancelledSuccessfully' => 'تم إلغاء حجزك بنجاح. ستتلقى رسالة إلكترونية بالتأكيد في وقت قريب.',
    'CancelBooking' => 'إلغاء الحجز',
    'ConfirmedBooking' => 'تأكيد الحجز',
    'PendingBooking' => 'الحجز معلق',
];
