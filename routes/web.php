<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserLogin;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\CustomerController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\RectifyController;
use App\Http\Controllers\Admin\SurrenderController;
use App\Http\Controllers\Admin\UserSetupController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\NewCustomerController;
use App\Http\Controllers\User\GenerateDemandController;
use App\Http\Controllers\Admin\CounterWiseCollectionController;
use App\Http\Controllers\SupportTicketController;


Route::middleware(['guest'])->group(function () {

  Route::get('/', [UserLogin::class, 'login_index'])->name('login');
  Route::post('/User/Login', [UserLogin::class, 'process_login']);
  Route::get('/User/ForgotPassword', [UserLogin::class, 'forgot_pass_index'])->name('forgot-pass');
});

Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  Route::get('/complaints', [SupportTicketController::class, 'index'])->name('support.tickets');
  Route::post('/complaints', [SupportTicketController::class, 'store'])->name('support.tickets.store');
  Route::get('/complaints/{number}', [SupportTicketController::class, 'show'])->name('support.tickets.show');
  Route::get('/dashboard/recent-collections', [DashboardController::class, 'recentCollections'])->name('dashboard.recent.collections');

  //generate demand
  Route::get('/generate-demand',        [GenerateDemandController::class, 'index'])->name('generate.demand');
  Route::get('/generate-demand/search', [GenerateDemandController::class, 'search'])->name('generate.demand.search');
  Route::post('/generate-demand/store', [GenerateDemandController::class, 'generate'])->name('generate.demand.store');

  //DEMAND COLLECTION
  Route::get('/demand/collection', [TransactionController::class, 'index'])->name('demand.collection');
  Route::get('/demand/search', [TransactionController::class, 'search'])->name('demand.search');
  Route::post('/demand/collect', [TransactionController::class, 'collect'])->name('demand.collect');

  //rectify payment
  Route::get('/rectify',        [RectifyController::class, 'index'])->name('rectify');
  Route::post('/rectify/save',  [RectifyController::class, 'save'])->name('rectify.save');
  Route::get('/rectify/search', [RectifyController::class, 'search'])->name('rectify.search');

  //bill print
  Route::get('/bill-print',        [TransactionController::class, 'billPrint'])->name('bill.print');
  Route::get('/bill-print/search', [TransactionController::class, 'billPrintSearch'])->name('bill.print.search');



  //CUSTOMER REGISTER
  Route::get('/report/customer-register', [ReportController::class, 'customerRegister'])->name('report.customer.register');
  Route::get('/report/customer-register/data', [ReportController::class, 'customerRegisterData'])->name('report.customer.register.data');


  // Customer Ledger
  Route::get('/customer/ledger',      [ReportController::class, 'customerLedger'])->name('customer.ledger');
  Route::get('/customer/ledger/data', [ReportController::class, 'customerLedgerData'])->name('customer.ledger.data');

  /// Renewal Register
  Route::get('/report/renewal-register',      [ReportController::class, 'renewalRegister'])->name('report.renewal.register');
  Route::get('/report/renewal-register/data', [ReportController::class, 'renewalRegisterData'])->name('report.renewal.register.data');

  // Collection Register
  Route::get('/report/collection-register',      [ReportController::class, 'collectionRegister'])->name('report.collection.register');
  Route::get('/report/collection-register/data', [ReportController::class, 'collectionRegisterData'])->name('report.collection.register.data');

  // Due Register
  Route::get('/report/due-register',      [ReportController::class, 'dueRegister'])->name('report.due.register');
  Route::get('/report/due-register/data', [ReportController::class, 'dueRegisterData'])->name('report.due.register.data');

  Route::get('/report/commission-register',      [CommissionController::class, 'counterCommissionRegister'])->name('report.commission.register');
  Route::get('/report/commission-register/data', [CommissionController::class, 'counterCommissionData'])->name('report.commission.register.data');

  Route::get('/Logout', [UserLogin::class, 'logout'])->name('logout');


  //admin



  Route::get('/admin/new-customer', [NewCustomerController::class, 'index'])->name('admin.new.customer');
  Route::post('/admin/new-customer/store', [NewCustomerController::class, 'store'])->name('admin.new.customer.store');
  Route::get('/admin/new-customer/search', [NewCustomerController::class, 'search'])->name('admin.new.customer.search');
  Route::get('/admin/new-customer/export', [NewCustomerController::class, 'export'])->name('admin.new.customer.export');
  Route::post('/admin/new-customer/update', [NewCustomerController::class, 'update'])->name('admin.new.customer.update');
  Route::post('/admin/new-customer/delete', [NewCustomerController::class, 'delete'])->name('admin.new.customer.delete');





  Route::get('/admin/counter', [CounterController::class, 'index'])->name('admin.counter');
  Route::post('/admin/counter/save', [CounterController::class, 'save'])->name('admin.counter.save');
  Route::post('counter/delete', [CounterController::class, 'delete'])->name('admin.counter.delete');


  Route::get('/admin/zone', [ZoneController::class, 'index'])->name('admin.zone');
  Route::post('/admin/zone/save', [ZoneController::class, 'save'])->name('admin.zone.save');
  Route::post('zone/delete', [ZoneController::class, 'delete'])->name('admin.zone.delete');



  Route::get('/admin/package', [PackageController::class, 'index'])->name('admin.package');
  Route::post('/admin/package/save', [PackageController::class, 'save'])->name('admin.package.save');
  Route::post('/admin/package/delete', [PackageController::class, 'delete'])->name('admin.package.delete');


  Route::get('/admin/rectify', [RectifyController::class, 'index'])->name('admin.rectify');
  Route::post('/admin/rectify/save', [RectifyController::class, 'save'])->name('admin.rectify.save');
  Route::get('/admin/rectify/search', [RectifyController::class, 'search'])->name('admin.rectify.search');


  Route::get('/admin/surrender', [SurrenderController::class, 'index'])->name('admin.surrender');
  Route::post('/admin/surrender/save', [SurrenderController::class, 'save'])->name('admin.surrender.save');
  Route::get('/admin/surrender/search', [SurrenderController::class, 'search'])->name('admin.surrender.search');





  Route::get('/admin/user-setup', [UserSetupController::class, 'index'])->name('admin.user.setup');
  Route::post('/admin/user-setup/save', [UserSetupController::class, 'save'])->name('admin.user.setup.save');
  Route::post('/admin/user-setup/delete', [UserSetupController::class, 'delete'])->name('admin.user.setup.delete');





  Route::get('/admin/commission-register',          [CommissionController::class, 'commissionRegister'])->name('admin.commission.register');
  Route::get('/admin/commission-register/summary',  [CommissionController::class, 'commissionRegisterSummary'])->name('admin.commission.register.summary');
  Route::get('/admin/commission-register/detail',   [CommissionController::class, 'commissionRegisterDetail'])->name('admin.commission.register.detail');





  Route::get('/admin/counter-wise-collection',       [CounterWiseCollectionController::class, 'index'])->name('admin.counterwisecollection');
  Route::get('/admin/counter-wise-collection/data',  [CounterWiseCollectionController::class, 'data'])->name('admin.counterwisecollection.data');


  Route::get('/admin/commission-payout',          [CommissionController::class, 'commissionPayout'])->name('admin.commission.payout');
  Route::get('/admin/commission-payout/due',      [CommissionController::class, 'getCommissionDue'])->name('admin.commission.payout.due');
  Route::post('/admin/commission-payout/save',    [CommissionController::class, 'saveCommissionPayout'])->name('admin.commission.payout.save');
  Route::get('/admin/commission-payout/history',  [CommissionController::class, 'getPayoutHistory'])->name('admin.commission.payout.history');



  Route::get('/admin/commission-register-counter',      [CommissionController::class, 'counterCommissionRegisterAdmin'])->name('admin.commission.register.counter');
  Route::get('/admin/commission-register-counter/data', [CommissionController::class, 'counterCommissionRegisterAdminData'])->name('admin.commission.register.counter.data');


  // Admin Demand Generation
  Route::get('/admin/generate-demand',        [GenerateDemandController::class, 'index'])->name('admin.generate.demand');
  Route::get('/admin/generate-demand/search', [GenerateDemandController::class, 'search'])->name('admin.generate.demand.search');
  Route::post('/admin/generate-demand/store', [GenerateDemandController::class, 'generate'])->name('admin.generate.demand.store');
  Route::post('/admin/generate-demand/delete', [GenerateDemandController::class, 'destroy'])->name('admin.generate.demand.delete');

  // Admin Demand Collection
  Route::get('/admin/demand/collection', [TransactionController::class, 'index'])->name('admin.demand.collection');
  Route::get('/admin/demand/search',     [TransactionController::class, 'search'])->name('admin.demand.search');
  Route::post('/admin/demand/collect',   [TransactionController::class, 'collect'])->name('admin.demand.collect');




  Route::get('/admin/user-setup/menus',       [UserSetupController::class, 'getMenus'])->name('admin.user.setup.menus');
  Route::post('/admin/user-setup/menus/save', [UserSetupController::class, 'saveMenus'])->name('admin.user.setup.menus.save');


  Route::get('/admin/report/renewal-register',      [ReportController::class, 'adminRenewalRegister'])->name('admin.report.renewal.register');
Route::get('/admin/report/renewal-register/data', [ReportController::class, 'adminRenewalRegisterData'])->name('admin.report.renewal.register.data');

Route::get('/admin/report/collection-register',      [ReportController::class, 'adminCollectionRegister'])->name('admin.report.collection.register');
Route::get('/admin/report/collection-register/data', [ReportController::class, 'adminCollectionRegisterData'])->name('admin.report.collection.register.data');

Route::get('/admin/report/due-register',      [ReportController::class, 'adminDueRegister'])->name('admin.report.due.register');
Route::get('/admin/report/due-register/data', [ReportController::class, 'adminDueRegisterData'])->name('admin.report.due.register.data');

Route::get('/admin/customer/ledger',      [ReportController::class, 'adminCustomerLedger'])->name('admin.customer.ledger');
Route::get('/admin/customer/ledger/data', [ReportController::class, 'adminCustomerLedgerData'])->name('admin.customer.ledger.data');



});
