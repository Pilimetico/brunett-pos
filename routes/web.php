<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SaleController;

// Authentication
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    // Escritorio / Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']); // Alias for convenience

    // Configuración
    Route::get('configuracion', [SettingController::class, 'index'])->name('settings.index');
    Route::post('configuracion', [SettingController::class, 'update'])->name('settings.update');
    Route::get('configuracion/metodos-pago', [SettingController::class, 'index'])->name('settings.payments');
    Route::post('configuracion/metodos-pago/{method}', [SettingController::class, 'updatePaymentMethod'])->name('settings.payments.update');
    
    Route::resource('configuracion/ciudades', CityController::class)->names('cities')->parameters(['ciudades' => 'city']);
    Route::resource('configuracion/bodegas', WarehouseController::class)->names('warehouses')->parameters(['bodegas' => 'warehouse']);

    // Inventario
    Route::get('inventario/kardex', [InventoryController::class, 'kardex'])->name('inventory.kardex');
    Route::get('inventario/ajustes', [InventoryController::class, 'adjustments'])->name('inventory.adjustments');
    Route::post('inventario/ajustes', [InventoryController::class, 'storeAdjustment'])->name('inventory.adjustments.store');
    Route::get('inventario/transferencias', [InventoryController::class, 'transfers'])->name('inventory.transfers');
    Route::post('inventario/transferencias', [InventoryController::class, 'storeTransfer'])->name('inventory.transfers.store');
    
    Route::resource('inventario', ProductController::class)->names('products')->parameters(['inventario' => 'product']);
    Route::resource('categorias', CategoryController::class)->names('categories')->parameters(['categorias' => 'category']);
    Route::resource('marcas', BrandController::class)->names('brands')->parameters(['marcas' => 'brand']);
    Route::resource('proveedores', SupplierController::class)->names('suppliers')->parameters(['proveedores' => 'supplier']);
    Route::resource('compras', PurchaseController::class)->names('purchases')->parameters(['compras' => 'purchase']);

    // Clientes
    Route::resource('clientes', CustomerController::class)->names('customers')->parameters(['clientes' => 'customer']);
    Route::post('clientes/{customer}/make-socio', [CustomerController::class, 'makeSocio'])->name('customers.make-socio');

    // Punto de Venta (POS)
    Route::get('punto-de-venta', [PosController::class, 'index'])->name('pos.index');
    Route::get('api/pos/products', [PosController::class, 'searchProducts']);
    Route::get('api/pos/customers', [PosController::class, 'searchCustomers']);
    Route::post('api/pos/customers', [PosController::class, 'createCustomer']);
    Route::post('api/pos/checkout', [PosController::class, 'store']);
    Route::get('ventas/{sale}/ticket', [SaleController::class, 'ticket'])->name('sales.ticket');

    // Cajas (Boxes)
    Route::resource('cajas', BoxController::class)->names('boxes')->parameters(['cajas' => 'box']);
    Route::post('cajas/{box}/close', [BoxController::class, 'close'])->name('boxes.close');
    Route::post('cajas/open', [BoxController::class, 'open'])->name('boxes.open');
    Route::post('cajas/movimiento', [BoxController::class, 'addMovement'])->name('boxes.movement');

    // Tienda Online (Sync)
    Route::get('tienda-online', [SyncController::class, 'index'])->name('sync.index');
    Route::post('tienda-online/stock', [SyncController::class, 'syncStock'])->name('sync.stock');
    Route::get('tienda-online/pedidos', [SyncController::class, 'fetchOrders'])->name('sync.orders');

    // Pedidos WhatsApp
    Route::resource('pedidos-whatsapp', OrderController::class)->names('orders')->parameters(['pedidos-whatsapp' => 'order']);
    Route::post('pedidos-whatsapp/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    // Gastos
    Route::resource('gastos', ExpenseController::class)->names('expenses')->parameters(['gastos' => 'expense']);

    // Autorizaciones
    Route::get('autorizaciones', [AuthorizationController::class, 'index'])->name('authorizations.index');
    Route::post('autorizaciones', [AuthorizationController::class, 'store'])->name('authorizations.store');
    Route::put('autorizaciones/{authRequest}', [AuthorizationController::class, 'update'])->name('authorizations.update');

    // Auditoría
    Route::get('auditoria', [AuditController::class, 'index'])->name('audit.index');

    // Reportes
    Route::get('reportes', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reportes/ventas', [ReportController::class, 'salesReport'])->name('reports.sales');
    Route::get('reportes/inventario', [ReportController::class, 'inventoryReport'])->name('reports.inventory');
    // Seguridad y Usuarios (Superadmin Panel)
    Route::resource('usuarios', \App\Http\Controllers\UserController::class)->names('users')->parameters(['usuarios' => 'user']);
    Route::resource('roles', \App\Http\Controllers\RoleController::class)->names('roles')->parameters(['roles' => 'role']);
});
