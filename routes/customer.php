<?php
Route::group(['namespace' => 'Customer'], function () {
    Route::get('/', 'DashboardController@dashboard');
    Route::get('pricelist', 'PricelistController@index');
    Route::get('docs/api', 'DocsApiController@index');
    Route::get('charts', 'ChartsController@index');


    Route::get('loadCharts', 'ChartsController@loadCharts');
    
});