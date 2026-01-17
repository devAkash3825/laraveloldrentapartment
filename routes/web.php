<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// User Side Controllers
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\UserLoginController;
use App\Http\Controllers\User\UserFavoriteController;
use App\Http\Controllers\User\UserPropertyController;
use App\Http\Controllers\User\UserNotesController;
use App\Http\Controllers\SearchController;

// Admin Side Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\ResourceSectionController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\AdminNotesController;
use App\Http\Controllers\Admin\AdministrationController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Http\Request;



// Auth Routes 
Route::get('/register', [UserLoginController::class, 'showRegisterForm'])->name('user-register');
Route::get('/login', [UserLoginController::class, 'showUserLoginForm'])->name('show-login');
Route::post('/login', [UserLoginController::class, 'userLogin'])->name('login');
Route::post('renter-register', [UserLoginController::class, 'renterRegister'])->name('renter-register');
Route::post('manager-register', [UserLoginController::class, 'managerRegister'])->name('manager-register');
Route::get('/forgot-password', [UserLoginController::class, 'forgotPasswod'])->name('forgot-password');


Route::get('login-user', [UserLoginController::class, 'loginUserForm'])->name('login-user');





// User Home Controller
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::post('/submit-contact-us', [HomeController::class, 'submitContactUs'])->name('submit-contact-us');
Route::post('/request-quote', [HomeController::class, 'requestQuote'])->name('request-quote');

Route::get('/privacy-promise', [HomeController::class, 'privacyPromise'])->name('privacy-promise');
Route::get('/manager-terms', [HomeController::class, 'managerTerms'])->name('manager-terms');
Route::get('/equal-opportunity', [HomeController::class, 'equalOpportunity'])->name('equal-opportunity');
Route::get('/report-lease', [HomeController::class, 'reportLease'])->name('report-lease');
Route::post('/report-lease', [HomeController::class, 'submitReportLease'])->name('submit-report-lease');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('advance-search', [HomeController::class, 'advanceSearchPage'])->name('advance-search');


// Route::post('/submit-contact-us', [HomeController::class, 'submitContactUs'])->name('submit-contact-us');
Route::get('/search-property', [SearchController::class, 'searchPropertyAll'])->name('search-property');
Route::get('/cities/{state_id}', [UserPropertyController::class, 'getCities']);
Route::get('/list-properties', [UserPropertyController::class, 'listProperty'])->name('list-properties');
Route::post('/quick-search', [SearchController::class, 'quickSearch'])->name('quick-search');


Route::middleware(['authenticated'])->group(function () {
    Route::get('/logout', [UserLoginController::class, 'logout'])->name('logout');
    Route::get('/change-password', [UserLoginController::class, 'changePassword'])->name('change-password');
    Route::post('/reset-password', [UserLoginController::class, 'resetPassword'])->name('reset-password');

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('user-profile');
    Route::get('/customer-feedback', [HomeController::class, 'customerFeedback'])->name('customer-feedback');
    Route::get('/recently-visited', [HomeController::class, 'recentlyVisited'])->name('recently-visited');
    Route::get('/referred-renter', [HomeController::class, 'referredRenter'])->name('referred-renter');
    Route::post('/update-user', [HomeController::class, 'updateUser'])->name('update.user');


    Route::group(['prefix' => 'favorite'], function () {
        Route::get('/', function() { return redirect()->route('list-view'); });
        Route::get('/list-view', [UserFavoriteController::class, 'listview'])->name('list-view');
        Route::get('/thumbnail-view', [UserFavoriteController::class, 'thumbnailView'])->name('thumbnail-view');
        Route::get('/map-view', [UserFavoriteController::class, 'mapView'])->name('map-view');
        Route::get('/street-view/{id}', [UserFavoriteController::class, 'streetView'])->name('street-view');
    });



    Route::get('/my-properties', [UserPropertyController::class, 'myProperties'])->name('my-properties');
    Route::post('/get-lat-n-lon', [UserPropertyController::class, 'getEmbeddedCode'])->name('embedded-map');
    Route::get('/add-property', [UserPropertyController::class, 'addProperty'])->name('add-property');
    Route::get('/states-n-cities', [UserPropertyController::class, 'getStates']);
    Route::get('/property-display/{id}', [UserPropertyController::class, 'propertyDisplay'])->name('property-display');
    Route::get('/getstate-city-name/{city_id}', [UserPropertyController::class, 'getStateAndCityName']);
    Route::post('/compare-apartments', [UserPropertyController::class, 'compareApartments'])->name('compare-apartments');
    Route::get('/manager-profile/{id}', [UserPropertyController::class, 'managerProfile'])->name('manager-profile');
    Route::post('/delete-gallery-image/{id}', [UserPropertyController::class, 'deleteGalleryImage'])->name('delete-gallery-img');
    Route::get('/edit-properties/{id}', [UserPropertyController::class, 'editProperty'])->name('edit-properties');
    Route::post('/edit-property-details/{id}', [UserPropertyController::class, 'editPropertyDetail'])->name('edit-property-detail');
    Route::post('/edit-additional-details/{id}', [UserPropertyController::class, 'editAdditionalDetail'])->name('edit-additional-detail');
    Route::post('/edit-general-details/{id}', [UserPropertyController::class, 'editGeneralDetail'])->name('edit-general-detail');
    Route::get('/create-floor-plan/{id}', [UserPropertyController::class, 'floorPlanDetail'])->name('create-floor-plan');
    Route::post('/store-floor-plan', [UserPropertyController::class, 'storeFloorPlan'])->name('store-floor-plan');
    Route::post('/update-floor-plan/{id}', [UserPropertyController::class, 'updateFloorPlan'])->name('update-floor-plan');
    Route::post('/delete-floor-plan/{id}', [UserPropertyController::class, 'deleteFloorPlan'])->name('delete-floor-plan');
    Route::post('/upload-image', [UserPropertyController::class, 'uploadImage'])->name('upload-image');

    Route::post('/add-to-favorite', [UserFavoriteController::class, 'addToFavoriteByUser'])->name('add-to-favorite');
    Route::post('/is-favorite', [UserFavoriteController::class, 'checkIsFavorite'])->name('check-is-favorite');
    Route::post('/bulk-remove-favorites', [UserFavoriteController::class, 'bulkRemoveFavorites'])->name('bulk-remove-favorites');

    Route::post('request-quote', [UserPropertyController::class, 'requestQuote'])->name('request-quote');
    Route::post('add-new-property', [UserPropertyController::class, 'addNewProperty'])->name('add-new-property');






    Route::get('/messages-tab', [UserNotesController::class, 'messagePage'])->name('messages-tab');
    Route::get('/send-message/{id}', [UserNotesController::class, 'sendMessagePage'])->name('send-messages');
    Route::get('/manager-message/property_{p_id}/renter_{r_id}', [UserNotesController::class, 'managerMessagePage'])->name('manager-message');
    Route::post('/favorite/add-notes', [UserNotesController::class, 'addNotes'])->name('add-notes');
    Route::post('/favorite/get-notes-detail', [UserNotesController::class, 'getNoteDetail'])->name('get-notes-detail');
    Route::post('/store-message', [UserNotesController::class, 'storeMessage'])->name('store-message');
    Route::post('marked-all-as-read', [UserNotesController::class, 'markedAllAsReadForFrontEnd'])->name('markedallasread');
    Route::post('marked-as-seen', [UserNotesController::class, 'markedAsSeen'])->name('markedasseen');




    Route::get('test-file', [HomeController::class, 'testFile'])->name('test-file');




});












//  Admin Panel
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin-login');
    Route::get('/forgot-password', [AdminLoginController::class, 'forgotPassword'])->name('admin-forgot-password');
    Route::post('/password-reset',[AdminLoginController::class,'requestPasswordReset'])->name('admin-request-password-reset');
    Route::post('/verify-otp',[AdminLoginController::class,'verifyOTP'])->name('admin-verify-otp');
    Route::post('/reset-password',[AdminLoginController::class,'resetPassword'])->name('admin-reset-password');
    
    
    Route::get('/cities/{state_id}', [AdminDashboardController::class, 'getCities'])->name('admin-get-cities');
    Route::post('get-cities', [AdminDashboardController::class, 'AdministrationCities']);
    // Route::post('/reset-password', [AdminLoginController::class, 'resetPassword'])->name('admin-reset-password');
    Route::post('/login', [AdminLoginController::class, 'adminLogin']);

    // Search Property 
    Route::get('/property/search', [PropertyController::class, 'propertySearch'])->name('admin-property-search');
    Route::get('property-search',[PropertyController::class,'propertySearching'])->name('admin-property-searching');

    Route::middleware('authadmin')->group(function () {
        Route::get('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
        Route::get('/scheduled-dates', [AdminDashboardController::class, 'getRemainders'])->name('get-remainders');
        Route::get('/manage-profile', [AdminDashboardController::class, 'manageProfile'])->name('admin-manage-profile');
        Route::get('/change-password', [AdminDashboardController::class, 'changePassword'])->name('admin-change-password');
        Route::post('/update-profile', [AdminDashboardController::class, 'updateProfile'])->name('admin-update-profile');
        Route::post('/update-password', [AdminDashboardController::class, 'updatePassword'])->name('admin-update-password');
        
        Route::post('/claim-renter', [AdminDashboardController::class, 'claimRenter'])->name('admin-claim-renter');
        Route::post('/change-property-status', [AdminDashboardController::class, 'changePropertyStatus'])->name('admin-change-property-status');
        Route::get('/agent-remainder', [AdminDashboardController::class, 'agentRemainder'])->name('admin-agent-remainder');
        
        Route::get('/message/renter_{rid}/property_{pid}', [MessageController::class, 'getMessages'])->name('admin-get-messages');
        Route::post('/send-message', [MessageController::class, 'sendMessage'])->name('admin-send-message');
        Route::get('/view-profile/{id}', [AdminDashboardController::class, 'viewProfile'])->name('admin-view-profile');
        Route::post('/set-remainder/{id}', [AdminDashboardController::class, 'setRemainder'])->name('admin-set-remainder');
        Route::post('/notify-manager', [AdminNotesController::class, 'notifyManager'])->name('notify-manager');
        Route::post('/mark-all-as-read', [AdminDashboardController::class, 'markAllAsRead'])->name('admin-mark-all-as-read');
        Route::post('/mark-as-seen', [AdminDashboardController::class, 'markAsSeen'])->name('admin-mark-as-seen');
        Route::get('/notes/view/renter_{renterId}/property_{propertyId}', [AdminNotesController::class, 'viewNotes'])->name('admin-view-notes');
        Route::post('/notes/save', [AdminNotesController::class, 'saveNote'])->name('admin-save-note');

        Route::post('change-status/{id}', [AdminDashboardController::class, 'changeStatus'])->name('admin-change-status');
        Route::get('add-lease', [AdminDashboardController::class, 'addLease'])->name('admin-add-lease');
        Route::post('add-lease', [AdminDashboardController::class, 'storeLease'])->name('admin-store-lease');
        Route::get('specials', [AdminDashboardController::class, 'specials'])->name('admin-specials');
        Route::get('show-all', [AdminDashboardController::class, 'showAll'])->name('admin-showall');
        Route::get('admin-messages', [AdminDashboardController::class, 'adminMessages'])->name('admin-messages');

        Route::get('/revert-contactus', [AdminDashboardController::class, 'revertContactUsForm'])->name('admin-revert-contactus');
        

        Route::group(['prefix' => 'client'], function () {
            Route::get('/add-user', [ClientController::class, 'addUser'])->name('admin-client-adduser');
            Route::post('/create-renter', [ClientController::class, 'createRenter'])->name('admin-create-renter');
            Route::get('/active-renters', [ClientController::class, 'activeRenter'])->name('admin-activeRenter');
            Route::get('/inactive-renters', [ClientController::class, 'inactiveRenter'])->name('admin-inactiveRenter');
            Route::get('/leased-renters', [ClientController::class, 'leasedRenter'])->name('admin-leasedRenter');
            Route::get('/unassigned-renters', [ClientController::class, 'unassignedRenters'])->name('admin-unassigned-renters');
            Route::delete('/delete-renters/{id}', [ClientController::class, 'deleteRenters'])->name('admin-deleteRenter');

            Route::get('/edit-renter/{id}', [ClientController::class, 'editRenter'])->name('admin-edit-renter');
            Route::post('/edit-renter-update', [ClientController::class, 'editRenterUpdate'])->name('admin-edit-renter-update');

            Route::get('/search', [ClientController::class, 'searchClient'])->name('admin-client-search');

            Route::get('/call-history', [ClientController::class, 'callHistory'])->name('admin-call-history');
            Route::get('/map-view/{id}', [ClientController::class, 'switchMapView'])->name('admin-switch-map-view');
            Route::get('/map-search/{id}', [ClientController::class, 'MapSearch'])->name('admin-map-search');
            Route::get('/favorite-listing/{id}', [ClientController::class, 'getFavoriteListing'])->name('admin-fav-listing');
            Route::get('/history-favorite-listing/{id}', [ClientController::class, 'getHistoryFavoriteListing'])->name('admin-history-fav-listing');
            Route::get('/property-inquiry-history/{id}', [ClientController::class, 'getPropertyInquiry'])->name('admin-inquiry-history');

            Route::get('/search-renter', [ClientController::class, 'searchRenter'])->name('admin-search-renter');
            Route::get('/search-renters', [ClientController::class, 'searchRenters'])->name('admin-search-renters');
            Route::get('/searched-renters-results', [ClientController::class, 'searchedRentersResult'])->name('admin-searched-renter-result');

            Route::get('/renter-info-update-history', [ClientController::class, 'infoUpdateHistory'])->name('admin-client-infoUpdate');
            
            Route::get('/notify-history', [ClientController::class, 'notifyHistory'])->name('admin-notify-history');
            Route::get('/view-notify-history/{id}', [ClientController::class, 'viewNotifyHistory'])->name('admin-view-notify-history');
            Route::get('/edit-notify-history/{id}', [ClientController::class, 'editNotifyHistory'])->name('admin-edit-notify-history');
            Route::post('/delete-notify-history/{id}', [ClientController::class, 'deleteNotifyHistory'])->name('admin-edit-notify-history-post');

            Route::get('/client/renter-reports', [ClientController::class, 'renterReports'])->name('admin-renter-reports');
            Route::get('/client/listing-fav', [ClientController::class, 'listingFavorite'])->name('admin-listing-fav');
            Route::get('/client/listing-fav-reports', [ClientController::class, 'listingFavoriteReports'])->name('admin-listing-fav-reports');
        });

        
        
        
        
        
        
        Route::get('map-view/{id}', [AdminDashboardController::class, 'mapView'])->name('admin-map-view');

        Route::group(['prefix' => 'resources'], function () {

            Route::get('/add-manager', [ResourceSectionController::class, 'addManager'])->name('admin-add-manager');
            Route::get('/list-manager', [ResourceSectionController::class, 'listManager'])->name('admin-list-manager');
            Route::get('/edit-manager/{id}', [ResourceSectionController::class, 'editManager'])->name('admin-edit-manager');
            Route::get('/search-manager', [ResourceSectionController::class, 'searchManager'])->name('admin-search-manager');
            Route::get('/search-manager/data', [ResourceSectionController::class, 'searchManagers'])->name('admin-search-managers');
            Route::get('/manager-login-log', [ResourceSectionController::class, 'managerLoginLog'])->name('admin-login-log');
            Route::get('/add-company', [ResourceSectionController::class, 'addCompany'])->name('admin-add-company');
            Route::get('/manage-company', [ResourceSectionController::class, 'manageCompany'])->name('admin-manage-company');
            Route::post('/create-manager', [ResourceSectionController::class, 'createManager'])->name('admin-create-manager');

        });








        // Admin Property Section
        Route::group(['prefix' => 'property'], function () {
            Route::get('/list-properties', [PropertyController::class, 'listProperty'])->name('admin-property-listproperty');
            
            Route::group(['middleware' => 'admin.permission:property_addedit,property_delete,property_active'], function () {
                Route::get('/addProperty', [PropertyController::class, 'addProperty'])->name('admin-addProperty');
                Route::get('/edit-property/{id}', [PropertyController::class, 'editProperty'])->name('admin-edit-property');
                Route::delete('/delete-property/{id}', [PropertyController::class, 'deleteProperty'])->name('admin-delete-property');
            });
            
            Route::post('/upload-gallery-image', [PropertyController::class, 'uploadGalleryImages'])->name('upload-gallery-image');
            Route::post('/update-gallery-details', [PropertyController::class, 'updateGalleryDetails'])->name('admin-update-gallery-details');
            Route::delete('/delete-gallery-image/{id}', [PropertyController::class, 'deleteGalleryImage'])->name('admin-delete-gallery-image');
            Route::post('/edit-general-details', [PropertyController::class, 'editGeneralDetails'])->name('admin-edit-general-details');

            Route::post('/submit-property', [PropertyController::class, 'submitProperty'])->name('admin-submit-property');
            Route::post('/edit-property-details', [PropertyController::class, 'editPropertyDetails'])->name('admin-edit-property-details');
            Route::post('/edit-additional-details', [PropertyController::class, 'editAdditionalDetails'])->name('admin-edit-additional-details');
            Route::get('/add-floor-plan/{id}', [PropertyController::class, 'addFloorPlan'])->name('admin-add-floor-plan');
            Route::post('/store-floor-plan', [PropertyController::class, 'storeFloorPlan'])->name('admin-store-floor-plan');
            Route::get('/edit-floor-plan/{id}', [PropertyController::class, 'editFloorPlan'])->name('admin-edit-floor-plan');
            Route::post('/update-floor-plan/{id}', [PropertyController::class, 'updateFloorPlan'])->name('admin-update-floor-plan');
            Route::delete('/delete-floor-plan/{id}', [PropertyController::class, 'deleteFloorPlan'])->name('admin-delete-floor-plan');
            Route::get('/search-property', [PropertyController::class, 'searchProperty'])->name('admin-search-property');
            Route::get('/fee-management', [PropertyController::class, 'feeManagement'])->name('admin-fee-management');
            Route::get('/get-cities-by-state-id/{id}', [PropertyController::class, 'getCitybyStateId'])->name('admin-getCitybyStateId');

            // States & Cities 
            Route::get('manage-states', [PropertyController::class, 'manageStates'])->name('admin-manage-states');
            Route::get('add-states', [PropertyController::class, 'addStates'])->name('admin-add-states');
            Route::get('edit-states/{id}', [PropertyController::class, 'editStates'])->name('admin-edit-states');
            Route::get('/manage-city', [PropertyController::class, 'manageCity'])->name('admin-manage-city');
            Route::post('/delete-city/{id}', [PropertyController::class, 'deletecity'])->name('admin-delete-city');
            Route::get('/edit-city/{id}', [PropertyController::class, 'editcity'])->name('admin-edit-city');
            Route::post('/update-city', [PropertyController::class, 'updatecity'])->name('admin-update-city');
            Route::get('/view-city/{id}', [PropertyController::class, 'viewcity'])->name('admin-view-city');
            Route::post('create-states', [PropertyController::class, 'createState'])->name('admin-create-state');
            Route::get('/add-cities', [PropertyController::class, 'addCity'])->name('admin-add-city');
            Route::post('/create-cities', [PropertyController::class, 'createCity'])->name('admin-create-city');
            Route::post('delete-state/{id}', [PropertyController::class, 'deleteStates'])->name('admin-delete-states');
            Route::post('update-states', [PropertyController::class, 'updateStates'])->name('admin-update-states');
            Route::post('/get-properties', [PropertyController::class, 'getProperty'])->name('admin-get-properties');

            // Property Display 
            Route::get('/property-display/{id}', [PropertyController::class, 'propertyDisplay'])->name('admin-property-display');
            Route::get('/property_{id}/renter_{rid}', [PropertyController::class, 'renterPropertyDisplay'])->name('admin-renter-property-display');



            Route::Post('/add-favorite', [PropertyController::class, 'addFavorite'])->name('admin-addfavorite');
            Route::Post('/is-favorite', [PropertyController::class, 'isFavorite'])->name('admin-isfavorite');

            Route::group(['middleware' => ['admin.permission:access_school_management']], function () {
                Route::get('/school-management', [PropertyController::class, 'schoolManagement'])->name('admin-school-management');
                Route::get('/add-school', [PropertyController::class, 'addSchool'])->name('admin-school-add');
                Route::post('/school-store', [PropertyController::class, 'schoolStore'])->name('admin-schoolManagement-store');
                Route::post('/delete-school/{id}', [PropertyController::class, 'deleteSchool'])->name('admin-delete-school');
                Route::post('/school-management/{id}', [PropertyController::class, 'schoolDelete']);
                Route::post('/school-management/selected', [PropertyController::class, 'schoolSelected'])->name('admin-schoolManagement-deleteSelected');
            });

            Route::get('pets-management', [PropertyController::class, 'petsManagement'])->name('admin-pets-management');
            Route::get('edit-pets/{id}', [PropertyController::class, 'editPets'])->name('admin-edit-pets');

        });

        // Admin Manager Section 
        Route::get('/manager/get-managers-list', [ResourceSectionController::class, 'getManagerList']);



        Route::group(['prefix' => 'administration'], function () {
            Route::get('/manage-my-agents', [AdministrationController::class, 'manageMyAgents'])->name('admin-manage-my-agents');
            Route::get('/add-admin', [AdministrationController::class, 'addAdminUsers'])->name('admin-add-admin-users');
            Route::get('/edit-admin/{id}', [AdministrationController::class, 'editAdminUsers'])->name('admin-edit-admin-users');
            Route::post('admin-delete-agent/{id}', [AdministrationController::class, 'adminDeleteAgent'])->name('admin-delete-agent');
            Route::get('/my-office-report', [AdministrationController::class, 'myOfficeReport'])->name('admin-my-office-report');
            Route::get('/manage-source', [AdministrationController::class, 'manageSource'])->name('admin-manage-source');
            Route::get('/delete-source', [AdministrationController::class, 'deleteSource'])->name('admin-delete-source');
            Route::get('/add-source', [AdministrationController::class, 'createSource'])->name('admin-add-source');

            Route::post('/store-admin-agent', [AdminDashboardController::class, 'storeAgents'])->name('admin-store-agents');
            Route::post('/edit-admin-agent/{id}', [AdminDashboardController::class, 'editAgents'])->name('admin-edit-agents');
        });

        // Content Management 
        Route::group(['prefix' => 'settings'], function () {
            Route::get('section-management', [SettingsController::class, 'sectionManagement'])->name('section-management');
            Route::get('pages-management', [SettingsController::class, 'pagesManagement'])->name('pages-management');
            Route::get('footer-management', [SettingsController::class, 'footerManagement'])->name('admin-footer-management');
            Route::get('slider-management', [SettingsController::class, 'sliderManagerPage'])->name('admin-slider-management');
            Route::get('add-housing',[SettingsController::class,'addHousing'])->name('admin-add-housing');
            Route::get('menu-management', [SettingsController::class, 'menuManagement'])->name('menu-management');
            
            
            
            Route::post('update-about-us', [SettingsController::class, 'updateAboutUs'])->name('admin-update-about-us');
            Route::post('contact-update', [SettingsController::class, 'contactUsUpdate'])->name('admin-contact-update');
            Route::post('create-housing',[SettingsController::class,'createHousing'])->name('admin-create-housing');
            Route::get('add-manager-terms',[SettingsController::class,'addManagerTerms'])->name('admin-add-manager-terms');
            Route::post('create-manager-terms',[SettingsController::class,'createManagerTerms'])->name('admin-create-manager-terms');
            Route::get('add-terms',[SettingsController::class,'addTerms'])->name('admin-add-terms');
            Route::post('create-terms',[SettingsController::class,'createTerms'])->name('admin-create-terms');
            
            Route::post('update-terms', [SettingsController::class, 'updateTerms'])->name('admin-update-terms');
            Route::post('update-equal-housing', [SettingsController::class, 'updateEqualHousing'])->name('admin-update-equal-housing');
            Route::post('update-manager-terms', [SettingsController::class, 'updateManagerTerms'])->name('admin-update-manager-terms');
            Route::get('add-slider-image', [SettingsController::class, 'addSliderImage'])->name('admin-add-slider-image');
            Route::post('store-slider-image', [SettingsController::class, 'store'])->name('admin-store-slider-image');
            Route::get('edit-slider-image/{id}', [SettingsController::class, 'editSliderImage'])->name('admin-edit-slider-image');
            Route::post('update-slider-image/{id}', [SettingsController::class, 'updateSliderImage'])->name('admin-update-slider-image');
            Route::post('delete-slider-image/{id}', [SettingsController::class, 'deleteSliderImage'])->name('admin-delete-slider-image');
            Route::post('slider-status/{id}', [SettingsController::class, 'changeStatus'])->name('admin-slider-status');
            Route::post('add-features', [SettingsController::class, 'addFeatures'])->name('add-feature');
            Route::get('edit-our-features/{id}', [SettingsController::class, 'editOurFeatures'])->name('edit-feature');
            Route::post('update-features/{id}', [SettingsController::class, 'updateFeatures'])->name('update-feature');
            Route::post('delete-features/{id}', [SettingsController::class, 'deleteFeature'])->name('delete-feature');
            Route::post('update-counter', [SettingsController::class, 'updateCounter'])->name('update-counter');
            Route::post('update-titles', [SettingsController::class, 'updateTitle'])->name('update-titles');
            Route::get('menu-management', [SettingsController::class, 'manuManagement'])->name('admin-menu-management');
            Route::get('general-settings', [SettingsController::class, 'generalSettings'])->name('admin-general-settings');
            
            Route::post('update-section-title', [SettingsController::class, 'updateSectionTitle'])->name('admin-update-section-titles');
            Route::post('update-appearence', [SettingsController::class, 'updateAppearence'])->name('admin-update-appearence');
            Route::post('update-site-names', [SettingsController::class, 'updateSiteName'])->name('admin-update-sitenames');
            Route::post('update-logo', [SettingsController::class, 'updateLogo'])->name('admin-update-logo');
            Route::post('update-contactus-cms', [SettingsController::class, 'updateContactUsCMS'])->name('admin-update-contactusCMS');
            Route::post('update-mail-settings', [SettingsController::class, 'updateMailSettings'])->name('admin-update-mail-settings');
            
            Route::post('delete-manager-terms/{id}', [SettingsController::class, 'deleteManagerTerms'])->name('admin-delete-manager-terms');
            Route::post('delete-terms/{id}', [SettingsController::class, 'deleteTerms'])->name('admin-delete-terms');
            Route::post('delete-equal-housing/{id}', [SettingsController::class, 'deleteEqualHousing'])->name('admin-delete-equal-housing');
        });




    });
});
