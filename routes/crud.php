<?php

use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\SeoMetaTagController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\UserController;

// Translates
Route::controller(LanguageController::class)->group(function () {
    Route::get('translates', 'translate')->name('language.translate');
    Route::get('translates/keys', 'translateKeys')->name('language.translateKeys');
    Route::post('translates/change', 'translateChange')->name('language.translateChange');
    Route::post('translates/add-key', 'translateAddKey')->name('language.translateAddKey');
    Route::delete('translates', 'translateRemove')->name('language.translateRemove');
});

// Languages
Route::resource('languages', LanguageController::class);

// Users
Route::resource('users', UserController::class);

// Permissions
Route::controller(PermissionController::class)->group(function () {
    Route::get('permissions/{permission}/option', 'option')->name('permission.option');
    Route::post('permissions/{permission}/option-save', 'optionSave')->name('permission.optionSave');
});
Route::resource('permissions', PermissionController::class);

// Setting
Route::resource('settings', SettingController::class)->only(['show', 'update']);

// Seo Meta Tags
Route::resource('seo-meta-tags', SeoMetaTagController::class);

// Menus
Route::resource('menus', MenuController::class);
