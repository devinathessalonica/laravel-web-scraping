<?php
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::group(['middleware' => 'guest:web'], function () {
        Route::view('login', 'auth.login');
        Route::post('login', 'Auth\LoginController@doLogin');
    });

    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('logout', 'Auth\LoginController@logout');
        Route::get('dashboard', 'DashboardController@dashboard');

        /* Master User */
        Route::put('user/{user}/reset-password', 'UserController@resetPassword');
        Route::resource('user', 'UserController');

        /* Master Bank */
        Route::get('bank/source-data', 'Master\BankController@sourceData');
        Route::resource('bank', 'Master\BankController');

        /* Master Currency */
        Route::get('currency/source-data', 'Master\CurrencyController@sourceData');
        Route::resource('currency', 'Master\CurrencyController');

        /* Master Member */
        Route::get('member/source-data', 'Master\MemberController@sourceData');
        Route::resource('member', 'Master\MemberController');

        /* Transaction Kurs Rate */
        Route::get('kursRate/source-data', 'Transaction\KursRateController@sourceData');
        Route::resource('kursRate', 'Transaction\KursRateController');
        Route::get('getDataBank', ['uses' => 'Transaction\KursRateController@getDataBank', 'as' => 'bank.getBank']);
        Route::get('getDataBankDetail', ['uses' => 'Transaction\KursRateController@getDataBankDetail', 'as' => 'bank.getBankDetail']);
        Route::get('getDataScrapDetail', ['uses' => 'Transaction\KursRateController@getDataScrapDetail', 'as' => 'scrap.getScrapDetail']);

        /* Transaction Scrapping Kurs */
        Route::resource('scrapKurs', 'Transaction\ScrapKursController');

        /* Transaction Top Up */
        Route::get('topup/source-data', 'Transaction\TopUpController@sourceData');
        Route::resource('topup', 'Transaction\TopUpController');
        Route::get('getDataMember', ['uses' => 'Transaction\TopUpController@getDataMember', 'as' => 'member.getDataMember']);
    });
});
