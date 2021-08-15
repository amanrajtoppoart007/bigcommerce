<?php

Route::get('/', 'Logistics\DashboardController@index')->name("dashboard");
Route::get('/test',function () {
    echo "hre";die;
});
