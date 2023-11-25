<?php

use App\Http\Controllers\ConsumerInfoController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\EncoderController;
use App\Http\Livewire\Chat\CreateChat;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\WaterBillingController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ReadingSheetController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\BillingRateController;
use App\Http\Controllers\TreasurerReceiptController;
use App\Http\Controllers\BillingStatementController;
use App\Http\Controllers\PenaltyRateController;
use App\Http\Controllers\BillingMonthController;
use App\Http\Controllers\DiscountRateController;
use App\Http\Controllers\AccountReceivableController;
use App\Http\Controllers\ConsumerLedgerController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\MiscellaneousItemController;
use App\Http\Controllers\CustomerMiscellaneousController;
use App\Http\Controllers\AgingAccountController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
//for all view
    Route::post('/login', [UserController::class, 'loginuser']);
    Route::post('/initial',[UserController::class, 'admin'])->name('initial');

    //for all profile view
    Route::post('/superadminprofile/update', [ProfileController::class, 'SuperAdminProfile_update'])->name('superadminprofile/update');
    Route::get('/superadmin',[ProfileController::class, 'index']);
    Route::post('superadmin/upload/update', [ProfileController::class, 'superadmin_upload_update']);

    Route::get('/reading', [ReadingController::class, 'viewReading'])->name('reading_table.view');
    //monthly billing summary web
    Route::get('/monthly-billing-sum', [ReportsController::class, 'monthSummaryBilling']);
    Route::get('/monthlybillingSummary.view', [ReportsController::class, 'monthSummaryBilling'])->name('monthlybillingSummary.view');
    Route::get('/each-customer-cluster', [ReportsController::class, 'getClusterData'])->name('each-customer-cluster');
    //for master list
    Route::get('/master-list', [ReportsController::class, 'viewMasterlist'])->name('master-list');
    //for reading sheet
    Route::get('/billing.reading-sheet', [ReadingSheetController::class, 'sheet']);
    //for admin or super and encoder view only
    Route::get('/edit/reading/{id}/',[ReadingController::class, 'editreading']);
    Route::post('/reading/update/',[ReadingController::class, 'updateReading'])->name('reading.update');
    Route::delete('deleteReading/{id}', [ReadingController::class, 'readingDelete']);
    //billing statement
    Route::get('/billing-statement',[BillingStatementController::class,'index'])->name('billing-statement');
    Route::get('/billingstatement/edit/{id}/',[BillingStatementController::class, 'viewBillingStatement']);
    Route::get('/billingstatement-data',[BillingStatementController::class] ,'getBillingStatementData');
    //consumer ledger for treasurer and admin
    Route::get('/consumer-ledger', [ConsumerLedgerController::class, 'consumerLedger'])->name('consumer-ledger');
    Route::get('/collection.perConsumer-ledger/{account_id}', [ConsumerLedgerController::class, 'perConsumer'])
    ->name('collection.perConsumer-ledger');
    //account receivable for admin andtreasurer 
   Route::get('/treasurer-account-receivables', [AccountReceivableController::class, 'index'])->name('treasurer-account-receivables');
   Route::get('/collection.perUserAccount-receivables/{account_id}', [AccountReceivableController::class, 'perUserAccRec'])
    ->name('collection.perUserAccount-receivables');
    //abstract of receipt
    Route::get('/collection.receipt',[TreasurerReceiptController::class, 'AbstractReceipt'])->name('collection.receipt');
    //abstract of collection
    Route::get('/collection.AbstractCollection',[TreasurerReceiptController::class, 'AbstractCollection'])->name('collection.AbstractCollectiont');
    //Aging of Accounts
    Route::get('/reports.aging-account-list',[AgingAccountController::class, 'indexAging'])->name('reports.aging-account-list');
    //monthly collection
    Route::get('/monthly-collection', [ReportsController::class, 'monthSummaryCollection'])->name('monthly-collection');
    Route::get('/monthly-collection/grand', [ReportsController::class, 'grandTotal'])->name('monthly-collection-grand');
    //for superadmin
Route::middleware('isSuperadmin')->group(function(){ 
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/get-chart-data', [App\Http\Controllers\HomeController::class, 'getChartData'])->name('get-chart-data');
    //notification
    // Route::get('/get-latest-notification-count', [App\Http\Controllers\HomeController::class, 'getLatestNotificationCount'])->name('get-latest-notification-count');
    // Route::get('/mark-notifications-as-viewed', [App\Http\Controllers\HomeController::class, 'markNotificationsAsViewed'])->name('mark-notifications-as-viewed');
    //library
    Route::get('/library', function () {
        return view('library.addlibrary');
    });
    //  crud that can only found in admin and superadmin

    Route::post('/verify-password',[UserController::class, 'verifyPassword'])->name('verify-password');
    Route::post('/superadmin-select-status',[UserController::class, 'updateStatus'])->name('superadmin-select-status');
    Route::get('/user.superAdmin',[UserController::class, 'index'])->name('superAdmin.view');
    Route::post('/add',[UserController::class, 'create']);
    Route::get('/superAdmin/edit/{id}/',[UserController::class, 'edit']);
    Route::post('/superAdmin/update/',[UserController::class, 'update'])->name('superAdmin.update');
    Route::delete('delete/{id}', [UserController::class, 'softDelete']);
    Route::post('register',[ConsumerInfoController::class, 'create']);
    Route::get('/superAdmincustomer',[ConsumerInfoController::class, 'store'])->name('superAdmincustomer.view');
    Route::get('/getCustomerInfo/{id}',[ConsumerInfoController::class, 'getCustomerInfo']);
    Route::get('/customersuperAdmin/edit/{id}/',[ConsumerInfoController::class, 'edit']);
    Route::post('/customersuperAdmin/update/',[ConsumerInfoController::class, 'update'])->name('customersuperAdmin.update');
    Route::delete('superadmincustomerdelete/{id}', [ConsumerInfoController::class, 'customerdeleteInSuperadmin']);
    Route::post('addcategory', [LibraryController::class, 'store'])->name('addcategory');
    Route::get('/addedlibrary',[LibraryController::class, 'show'])->name('addlibrary.view');
    Route::get('/category/edit/{id}/',[LibraryController::class, 'edit']);
    Route::post('/category/update/',[LibraryController::class, 'update'])->name('category.update');
    Route::delete('superadmincategorydelete/{id}', [LibraryController::class, 'categoryDelete']);
    Route:: get('/reportLogs',[ReportsController::class, 'showReport'])->name('reports.reportLogs');
    Route::get('/get-meter-brands', [LibraryController::class, 'namebrand']);
    Route::get('/noreload', [LibraryController::class, 'no_reload']);
    Route::get('/edit_norefresh', [LibraryController::class, 'view_norefresh']);
    //billing rate web
    Route::post('/add-billingrate', [BillingRateController::class, 'addBillingRate']);
    Route::get('/about-rate', [BillingRateController::class, 'indexBillingRate'])->name('addBillingRate.view');
    Route::get('/billingrate/edit/{id}/',[BillingRateController::class, 'editBillingrate']);
    Route::post('/bilingrate/update/',[BillingRateController::class, 'updateBillingrate'])->name('bilingrate/update');
    Route::delete('deleteBillingrate/{id}', [BillingRateController::class, 'billingrateDelete']);
    //penalty rate
    Route::post('/add-penaltyRate', [PenaltyRateController::class, 'addPenaltyRate']);
    Route::get('/about-penaltyrate', [PenaltyRateController::class, 'indexPenaltyRate'])->name('addPenaltyRate.view');
    Route::get('/penalty/edit/{id}/',[PenaltyRateController::class, 'editPenaltyrate']);
    Route::put('/penaltyrate/update/',[PenaltyRateController::class, 'updatePenaltyrate'])->name('penaltyrate/update');
    Route::delete('deletePenaltyrate/{id}', [PenaltyRateController::class, 'penaltyrateDelete']);
    //discount rate
    Route::post('/add-discountRate', [DiscountRateController::class, 'addDiscountRate']);
    Route::get('/about-discountate', [DiscountRateController::class, 'indexDiscountRate'])->name('addDiscountRate.view');
    Route::get('/discount/edit/{id}/',[DiscountRateController::class, 'editDiscountrate']);
    Route::put('/discountrate/update/',[DiscountRateController::class, 'updateDiscountrate'])->name('discountrate/update');
    Route::delete('deleteDiscountrate/{id}', [DiscountRateController::class, 'discountrateDelete']);

    //bill month
    Route::post('/add/billmonth', [BillingMonthController::class, 'create']);
    Route::get('/billingmonth', [BillingMonthController::class, 'store'])->name('billingmonth');
    Route::post('/activate-status', [BillingMonthController::class, 'activate'])->name('activate-status');
    Route::post('/deactivate-status', [BillingMonthController::class, 'deactivate'])->name('deactivate-status');
    Route::get('/check-status-exists',  [BillingMonthController::class, 'checkStatusExists']);
    Route::get('/billingmonth/edit/{id}/',[BillingMonthController::class, 'editbillingmonth']);
    Route::put('/billingmonth/update/',[BillingMonthController::class, 'updateBillingMonth'])->name('billingmonth/update');
    Route::get('/show-billmonth/{id}', [BillingMonthController::class, 'show'])->name('show-billmonth');
    Route::delete('deleteBillingmonth/{id}', [BillingMonthController::class, 'billingMonthDelete']);
    //holiday
    Route::post('/add-holiday', [HolidayController::class, 'create']);
    Route::get('/holiday.view', [HolidayController::class, 'index'])->name('holiday.view');
    Route::get('/holiday/edit/{id}/', [HolidayController::class, 'edit']);
    Route::put('/holiday/update', [HolidayController::class, 'update'])->name('holiday/update');
    Route::delete('deleteHoliday/{id}', [HolidayController::class, 'deleteHoliday']);
    //add miscellaneous item
    Route::post('/add-miscell', [MiscellaneousItemController::class, 'create']);
    Route::get('/addmiscell.view', [MiscellaneousItemController::class, 'index'])->name('addmiscell.view');
    Route::get('/miscell/edit/{id}/', [MiscellaneousItemController::class, 'edit']);
    Route::put('/MiscellItem/update', [MiscellaneousItemController::class, 'update'])->name('MiscellItem/update');
    Route::delete('deleteItem/{id}', [MiscellaneousItemController::class, 'deleteItem']);
    //add customer miscellaneous item
    Route::get('/billing.miscellaneous_list', [MiscellaneousItemController::class, 'store'])->name('billing.miscellaneous_list');
    Route::post('/customer-item', [CustomerMiscellaneousController::class, 'create']);
    Route::get('/list-addeditems/{account_id}', [CustomerMiscellaneousController::class, 'ListAddedItems'])->name('list-addeditems');
    //Disconnection notice
    Route::get('/disconnection-notice',[ConsumerInfoController::class, 'disconnectionForm'])->name('disconnection-notice');
    Route::get('/billing.disconnection-list',[ConsumerInfoController::class, 'filterDisconnectionNotices'])->name('disconnection-list');
});

//for encoder view
Route::middleware('isEncoder')->group(function(){
    Route::get('/billing.encoder-billing', [EncoderController::class, 'index'])->name('billing.encoder-billing');    
    Route::get('/input',[EncoderController::class, 'create']); 

});
//for treasurer view
Route::middleware('isTreasurer')->group(function(){
    Route::get('/collection.treasurer-receipt', [TreasurerReceiptController::class, 'index'])->name('collection.treasurer-receipt');
    Route::get('/collection.treasureMakeReceipt/{account_id}', [TreasurerReceiptController::class, 'makeReceipt'])->name('collection.treasureMakeReceipt');
    Route::get('/receivableAlreadyAddedToReceipt', [TreasurerReceiptController::class, 'alreadyInReceipt'])->name('receivableAlreadyAddedToReceipt');
    Route::get('/create-receipt', [TreasurerReceiptController::class, 'createReceipt']);
    Route::get('/create-penalty/{account_id}', [TreasurerReceiptController::class, 'makePenalty']);
    Route::get('/view', [TreasurerReceiptController::class, 'receivable']);
    Route::post('/addedToReceipt', [TreasurerReceiptController::class, 'AddedToReceipt']);
    Route::post('/backToReceivable', [TreasurerReceiptController::class, 'updateToReceivable']);
    Route::delete('deleteDisc/{id}', [TreasurerReceiptController::class, 'discountDelete']);
});
//for Assessor view
Route::middleware('isAssessor')->group(function(){
    // Route::get('/master-list', [ReportsController::class, 'viewMasterlist'])->name('master-list');
});