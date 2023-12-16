<?php

use Illuminate\Support\Facades\Route;

 // About Us
 Route::get('/aboutus', 'AboutusController@list')->name('cms.aboutus.list')->middleware('access:cms.aboutus.list');
 Route::get('/aboutus/add', 'AboutusController@add')->name('cms.aboutus.add')->middleware('access:cms.aboutus.add');
 Route::post('/aboutus/add', 'AboutusController@save')->name('cms.aboutus.save')->middleware('access:cms.aboutus.save');
 Route::get('/aboutus/edit/{slug}', 'AboutusController@edit')->name('cms.aboutus.edit')->middleware('access:cms.aboutus.edit');
 Route::post('/aboutus/edit/{slug}', 'AboutusController@update')->name('cms.aboutus.update')->middleware('access:cms.aboutus.update');
 Route::get('/aboutus/delete/{slug}', 'AboutusController@delete')->name('cms.aboutus.delete')->middleware('access:cms.aboutus.delete');
 Route::get('/aboutus/view/{slug}', 'AboutusController@view')->name('cms.aboutus.view')->middleware('access:cms.aboutus.view');
 Route::any('/aboutus/search', 'AboutusController@search')->name('cms.aboutus.search')->middleware('access:cms.aboutus.search');
 Route::get('/aboutus/status/{slug}/{type}', 'AboutusController@status')->name('cms.aboutus.status')->middleware('access:cms.aboutus.status');