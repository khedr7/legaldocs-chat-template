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
    'passwordChangedSuccessfully'    => 'Password changed successfully !',
    'userSuccessfullyRegistered'     => 'User successfully registered',
    'userSuccessfullySignedIn'       => 'User successfully signed in',
    'userSuccessfullySignedOut'      => 'User successfully signed out',
    'newPasswordError'               => 'New Password cannot be same as your current password. Please choose a different password.',
    'currentPasswordIncorrect'       => 'Your current password does not matches with the password you provided. Please try again.',
    'passwordConfirmationNotMatch'   => 'The Password confirmation does not match.',
    'credentialsError'               => 'Wrong ID or password',
    'incorrect_password'             => 'incorrect password',

    'Unauthorized'                   => 'You do not have permissions to perform this action',
    'Unauthenticated'                => 'PLease login first',

    'blockedUser'                    => 'the user is blocked',

    // General msgs
    'dataAddedSuccessfully'          => 'Data added successfully',
    'dataUpdatedSuccessfully'        => 'Data updated successfully',
    'dataFetchedSuccessfully'        => 'Data fetched successfully',
    'mediaFetchedSuccessfully'       => 'Media fetched successfully',
    'dataDeletedSuccessfully'        => 'Data deleted successfully',

    'dataCanNotBeDeleted'            => 'data cannot be deleted',

    'objectNotFoundF'                => ':object Not Found',
    'objectNotFound'                 => ':object Not Found',


    //General errors

    'routeNotFound'                  => 'Route not found',
    'VerificationCompletedSuccessfully' => 'Verification completed successfully',
    'ThephoneNumberOrEmailAlreadyExists' => 'Phone number or the email already exists',


    //Booking
    'bookingSuccessfully'            => 'Booking successfully',
    'SorryYouCannotChangeTheBookingStatus' => 'Sorry, you cannot change the booking status',

    'TheRestauranIsClosedInThisTime' => 'The restauran is closed in this time.',
    'TheServiceIsNotAvailableInThisDate' => 'The service is not available in this date.',

    'YourBookingPendingSuccessfully'   => 'Your booking is pending .',
    'YourBookingConfirmedSuccessfully' => 'Your booking is confirmed successfully .',
    'YourBookingCancelledSuccessfully' => 'Your booking is cancelled successfully .',
    'CancelBooking'    => 'Cancel Booking',
    'ConfirmedBooking' => 'Confirmed Booking',
    'PendingBooking'   => 'pending Booking',
];
