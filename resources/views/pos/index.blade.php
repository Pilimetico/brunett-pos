@extends('layouts.app')

@section('title', 'POS - Brunett Ecuador')
@section('page_title', 'Punto de Venta Local')
@section('page_subtitle', 'Terminal de facturación rápida')

@section('content')

<div x-data="posSystem()" class="pos-wrapper" style="display: grid; grid-template-columns: 1fr 380px; gap: 2rem; height: calc(100vh - 180px);">
    
    <!-- Left Column: Search & Products -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- Search Bar -->
        <div class="panel" style="padding: 1rem; position: relative;">
            <div style="display: flex; align-items: center; border: 2px solid var(--brand-secondary); border-radius: 8px; overflow: hidden; background: white;">
                <i data-lucide="search" style="color: var(--text-muted); margin-left: 1rem;"></i>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="searchProducts" 
                       placeholder="Buscar por código de barras o nombre..." 
                       style="flex: 1; padding: 1rem; border: none; outline: none; font-size: 1.1rem; font-family: var(--font-body);">
                <button @click="searchQuery=''; searchResults=[]" class="btn-icon" style="border: none; background: transparent;"><i data-lucide="x"></i></button>
            </div>
            
            <!-- Search Results Dropdown -->
            <div x-show="searchResults.length > 0" @click.away="searchResults = []" 
                 style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid var(--border-color); border-radius: 8px; box-shadow: var(--shadow-lg); z-index: 50; max-height: 400px; overflow-y: auto; margin-top: 0.5rem;">
                <template x-for="product in searchResults" :key="product.id">
                    <div @click="addToCart(product)" style="padding: 1rem; border-bottom: 1px solid var(--border-color); cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#F3F5F9'" onmouseout="this.style.backgroundColor='white'">
                        <div>
                            <div style="font-weight: 600;" x-text="product.name"></div>
                            <div style="font-size: 0.85rem; color: var(--text-secondary);" x-text="'Stock: ' + product.stock + ' | ' + product.code"></div>
                        </div>
                        <div style="color: var(--brand-primary); font-weight: 700; font-size: 1.1rem;" x-text="'$' + parseFloat(product.pvp1).toFixed(2)"></div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Cart Table -->
        <div class="panel" style="flex: 1; display: flex; flex-direction: column; padding: 0; overflow: hidden;">
            <div style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-color); background: #f8fafc;">
                <h3 style="font-size: 1rem; color: var(--brand-primary);">Detalle de Venta</h3>
            </div>
            <div style="flex: 1; overflow-y: auto;">
                <table class="data-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="padding-left: 1.5rem;">Artículo</th>
                            <th style="width: 120px;">Precio</th>
                            <th style="width: 100px;">Cant.</th>
                            <th style="width: 100px; text-align: right;">Subtotal</th>
                            <th style="width: 60px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr x-show="cart.length === 0">
                            <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted);">El carrito está vacío. Escanea un producto.</td>
                        </tr>
                        <template x-for="(item, index) in cart" :key="index">
                            <tr>
                                <td style="padding-left: 1.5rem;">
                                    <div style="font-weight: 500;" x-text="item.product.name"></div>
                                    <div style="font-size: 0.8rem; color: var(--text-secondary);" x-text="item.product.code"></div>
                                </td>
                                <td>
                                    <select x-model="item.price_level" @change="updateItemPrice(index)" style="padding: 0.3rem; border-radius: 4px; border: 1px solid var(--border-color); font-size: 0.85rem; width: 100%;">
                                        <option value="pvp1" x-text="'Normal: $' + parseFloat(item.product.pvp1).toFixed(2)"></option>
                                        <option value="pvp2" x-text="'Cant: $' + parseFloat(item.product.pvp2).toFixed(2)"></option>
                                        <option value="pvp3" x-text="'Mayor: $' + parseFloat(item.product.pvp3).toFixed(2)"></option>
                                        <option value="pvp4" x-text="'Socio: $' + parseFloat(item.product.pvp4).toFixed(2)"></option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" x-model.number="item.quantity" @input="updateTotals()" min="1" style="width: 60px; padding: 0.3rem; text-align: center; border: 1px solid var(--border-color); border-radius: 4px;">
                                </td>
                                <td style="text-align: right; font-weight: 600;" x-text="'$' + (item.unit_price * item.quantity).toFixed(2)"></td>
                                <td style="text-align: center;">
                                    <button @click="removeFromCart(index)" class="btn-icon" style="color: var(--brand-danger); padding: 0.3rem;"><i data-lucide="trash-2" style="width: 16px;"></i></button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Sidebar Checkout -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- Customer Selection -->
        <div class="panel" style="padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3 style="font-size: 1rem; color: var(--brand-primary);">Cliente</h3>
                <button @click="showCustomerModal = true" class="btn-icon" style="padding: 0.3rem;"><i data-lucide="user-plus" style="width: 16px;"></i></button>
            </div>
            
            <div x-show="!selectedCustomer" style="position: relative;">
                <input type="text" x-model="customerQuery" @input.debounce.300ms="searchCustomers" placeholder="Buscar cliente..." style="width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 6px;">
                
                <div x-show="customerResults.length > 0" @click.away="customerResults = []" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid var(--border-color); border-radius: 6px; box-shadow: var(--shadow-md); z-index: 40; margin-top: 0.3rem;">
                    <template x-for="customer in customerResults" :key="customer.id">
                        <div @click="selectCustomer(customer)" style="padding: 0.8rem; border-bottom: 1px solid var(--border-color); cursor: pointer; hover:background: #f3f5f9;">
                            <div style="font-weight: 500;" x-text="customer.first_name + ' ' + (customer.last_name || '')"></div>
                            <div style="font-size: 0.8rem; color: var(--text-secondary);" x-text="customer.document_number"></div>
                        </div>
                    </template>
                </div>
            </div>

            <div x-show="selectedCustomer" style="background: var(--bg-main); padding: 1rem; border-radius: 6px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="font-weight: 600;" x-text="selectedCustomer ? selectedCustomer.first_name : ''"></div>
                    <div style="font-size: 0.8rem; color: var(--brand-accent);" x-show="selectedCustomer && selectedCustomer.type === 'socio_brunett'"><i data-lucide="star" style="width: 12px; display: inline;"></i> Socio Brunett</div>
                </div>
                <button @click="selectedCustomer = null" class="btn-icon" style="padding: 0.3rem;"><i data-lucide="x" style="width: 16px;"></i></button>
            </div>
        </div>

        <!-- Totals & Payment -->
        <div class="panel" style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
            <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 1.1rem; color: var(--text-secondary);">
                    <span>Subtotal</span>
                    <span x-text="'$' + subtotal.toFixed(2)"></span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 1.1rem; color: var(--brand-accent);">
                    <span>Descuento</span>
                    <span x-text="'-$' + discount.toFixed(2)"></span>
                </div>
                <div style="border-top: 2px dashed var(--border-color); margin: 1rem 0;"></div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <span style="font-size: 1.4rem; font-weight: 600;">TOTAL</span>
                    <span style="font-size: 2.2rem; font-weight: 700; color: var(--brand-primary); font-family: var(--font-heading);" x-text="'$' + total.toFixed(2)"></span>
                </div>

                <!-- Payment Methods -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 1.5rem;">
                    <button @click="paymentMethod = 'cash'" :class="{'btn-primary': paymentMethod === 'cash', 'btn': true}" style="background: paymentMethod === 'cash' ? '' : 'var(--bg-main)'; color: paymentMethod === 'cash' ? '' : 'var(--text-primary)'; border: 1px solid var(--border-color);">
                        Efectivo
                    </button>
                    <button @click="paymentMethod = 'card'" :class="{'btn-primary': paymentMethod === 'card', 'btn': true}" style="background: paymentMethod === 'card' ? '' : 'var(--bg-main)'; color: paymentMethod === 'card' ? '' : 'var(--text-primary)'; border: 1px solid var(--border-color);">
                        Tarjeta / Transf.
                    </button>
                </div>
                
                <div x-show="paymentMethod === 'cash'" style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Recibido ($)</label>
                    <input type="number" x-model.number="cashReceived" style="width: 100%; padding: 1rem; font-size: 1.2rem; font-weight: bold; border: 1px solid var(--border-color); border-radius: 6px;">
                    <div style="margin-top: 0.5rem; display: flex; justify-content: space-between; font-weight: 600; color: var(--text-secondary);">
                        <span>Cambio:</span>
                        <span x-text="'$' + Math.max(0, cashReceived - total).toFixed(2)" :style="cashReceived >= total ? 'color: var(--brand-accent);' : 'color: var(--brand-danger);'"></span>
                    </div>
                </div>
            </div>

            <button @click="checkout()" class="btn btn-primary" style="width: 100%; padding: 1.2rem; font-size: 1.1rem; border-radius: 12px; display: flex; justify-content: center; align-items: center; gap: 0.5rem;" :disabled="cart.length === 0 || (paymentMethod === 'cash' && cashReceived < total)">
                <i data-lucide="check-circle"></i> Cobrar e Imprimir Ticket
            </button>

            <!-- Acceso rápido a Salida de Caja (Requisito PDF 4) -->
            <div style="margin-top: 1rem; text-align: center;">
                <a href="{{ route('boxes.index') }}" target="_blank" style="color: var(--brand-warning); font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.8rem; background: var(--bg-main); border-radius: 8px;">
                    <i data-lucide="arrow-down-circle" style="width: 18px;"></i> Registrar Salida de Dinero
                </a>
            </div>
        </div>

    </div>

    <!-- Quick Customer Modal -->
    <div x-show="showCustomerModal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 100;">
        <div class="panel" style="width: 450px; padding: 2rem;">
            <h3 style="margin-bottom: 1.5rem;">Registro Rápido de Cliente</h3>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.3rem; font-size: 0.85rem;">Nombres *</label>
                <input type="text" x-model="newCustomer.first_name" style="width: 100%; padding: 0.6rem; border: 1px solid var(--border-color); border-radius: 4px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.3rem; font-size: 0.85rem;">Cédula / RUC</label>
                <input type="text" x-model="newCustomer.document_number" style="width: 100%; padding: 0.6rem; border: 1px solid var(--border-color); border-radius: 4px;">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.3rem; font-size: 0.85rem;">Tipo</label>
                <select x-model="newCustomer.type" style="width: 100%; padding: 0.6rem; border: 1px solid var(--border-color); border-radius: 4px;">
                    <option value="normal">Normal</option>
                    <option value="socio_brunett">Socio Brunett</option>
                </select>
            </div>
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button @click="showCustomerModal = false" class="btn">Cancelar</button>
                <button @click="quickRegisterCustomer()" class="btn btn-primary" :disabled="!newCustomer.first_name">Registrar y Seleccionar</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function posSystem() {
    return {
        searchQuery: '',
        searchResults: [],
        customerQuery: '',
        customerResults: [],
        selectedCustomer: null,
        cart: [],
        subtotal: 0,
        discount: 0,
        total: 0,
        paymentMethod: 'cash',
        cashReceived: 0,
        showCustomerModal: false,
        newCustomer: { first_name: '', document_number: '', type: 'normal' },

        async searchProducts() {
            if (this.searchQuery.length < 2) {
                this.searchResults = [];
                return;
            }
            try {
                const response = await fetch(`/api/pos/products?q=${this.searchQuery}`);
                this.searchResults = await response.json();
            } catch (e) { console.error(e); }
        },

        async searchCustomers() {
            if (this.customerQuery.length < 2) {
                this.customerResults = [];
                return;
            }
            try {
                const response = await fetch(`/api/pos/customers?q=${this.customerQuery}`);
                this.customerResults = await response.json();
            } catch (e) { console.error(e); }
        },

        async quickRegisterCustomer() {
            try {
                const response = await fetch('/api/pos/customers', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.newCustomer)
                });
                const data = await response.json();
                if (data.success) {
                    this.selectCustomer(data.customer);
                    this.showCustomerModal = false;
                    this.newCustomer = { first_name: '', document_number: '', type: 'normal' };
                } else {
                    alert('Error al registrar cliente.');
                }
            } catch (e) { alert('Error de conexión.'); }
        },

        selectCustomer(customer) {
            this.selectedCustomer = customer;
            this.customerQuery = '';
            this.customerResults = [];
            if (customer.type === 'socio_brunett') {
                this.cart.forEach((item, index) => {
                    item.price_level = 'pvp4';
                    this.updateItemPrice(index);
                });
            }
        },

        addToCart(product) {
            let defaultPvp = 'pvp1';
            if (this.selectedCustomer && this.selectedCustomer.type === 'socio_brunett') {
                defaultPvp = 'pvp4';
            }
            const existingIndex = this.cart.findIndex(i => i.product.id === product.id && i.price_level === defaultPvp);
            if (existingIndex > -1) {
                this.cart[existingIndex].quantity++;
            } else {
                this.cart.push({
                    product: product,
                    quantity: 1,
                    price_level: defaultPvp,
                    unit_price: parseFloat(product[defaultPvp])
                });
            }
            this.searchQuery = '';
            this.searchResults = [];
            this.updateTotals();
            setTimeout(() => { document.querySelector('input[x-model="searchQuery"]').focus(); }, 100);
        },

        updateItemPrice(index) {
            const item = this.cart[index];
            item.unit_price = parseFloat(item.product[item.price_level]);
            this.updateTotals();
        },

        removeFromCart(index) {
            this.cart.splice(index, 1);
            this.updateTotals();
        },

        updateTotals() {
            this.cart.forEach((item) => {
                if (this.selectedCustomer && this.selectedCustomer.type === 'socio_brunett') {
                    item.price_level = 'pvp4';
                } else {
                    if (item.quantity >= 12) item.price_level = 'pvp3';
                    else if (item.quantity >= 3) item.price_level = 'pvp2';
                    else item.price_level = 'pvp1';
                }
                item.unit_price = parseFloat(item.product[item.price_level]);
            });

            this.subtotal = this.cart.reduce((sum, item) => sum + (item.unit_price * item.quantity), 0);
            this.total = this.subtotal - this.discount;
            if (this.cashReceived === 0) this.cashReceived = this.total;
        },

        async checkout() {
            if (this.cart.length === 0) return;
            const payload = {
                customer_id: this.selectedCustomer ? this.selectedCustomer.id : null,
                items: this.cart.map(i => ({
                    product_id: i.product.id,
                    quantity: i.quantity,
                    price_level: i.price_level,
                    unit_price: i.unit_price
                })),
                payments: [{ method: this.paymentMethod, amount: this.total }]
            };
            try {
                const response = await fetch('/api/pos/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });
                const data = await response.json();
                if (data.success) {
                    alert('Venta guardada.');
                    this.cart = [];
                    this.selectedCustomer = null;
                    this.updateTotals();
                    this.cashReceived = 0;
                } else { alert('Error: ' + data.message); }
            } catch (e) { alert('Error de conexión.'); }
        }
    }
}
</script>
@endpush
@endsection
