@extends('layouts.app')

@section('title', 'Nuevo Pedido WhatsApp - Brunett')
@section('page_title', 'Registrar Pedido WhatsApp')

@section('content')

<div class="panel" x-data="orderForm()">
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem; background: #f8fafc; padding: 1.5rem; border-radius: 8px;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Cliente *</label>
                <select name="customer_id" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    <option value="">Seleccione un cliente</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Dirección de Envío</label>
                <input type="text" name="shipping_address" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; margin-bottom: 1rem;">Productos a Reservar</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th style="text-align: right;"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, index) in items" :key="index">
                        <tr>
                            <td>
                                <select :name="'items['+index+'][product_id]'" x-model="item.product_id" @change="updatePrice(index)" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 4px;">
                                    <option value="">Seleccione producto</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->pvp1 }}">{{ $product->name }} (Stock: {{ $product->stock }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" :name="'items['+index+'][quantity]'" x-model="item.quantity" step="1" min="1" required style="width: 80px; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 4px;">
                            </td>
                            <td>
                                <input type="number" :name="'items['+index+'][price]'" x-model="item.price" step="0.01" required style="width: 100px; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 4px;">
                            </td>
                            <td>
                                <span x-text="'$' + (item.quantity * item.price).toFixed(2)"></span>
                            </td>
                            <td style="text-align: right;">
                                <button type="button" @click="removeItem(index)" style="background: transparent; color: #dc2626; border: none; cursor: pointer;"><i data-lucide="trash-2" style="width: 18px;"></i></button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            
            <button type="button" @click="addItem()" class="btn" style="margin-top: 1rem; background: white; border: 1px dashed var(--brand-primary); color: var(--brand-primary);">
                <i data-lucide="plus" style="width: 16px;"></i> Agregar otro producto
            </button>
        </div>

        <div style="border-top: 2px solid var(--border-color); padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="width: 50%;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Notas / Observaciones</label>
                <textarea name="notes" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px; height: 80px;"></textarea>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 1.2rem; margin-bottom: 1rem;">
                    Total Pedido: <strong style="color: var(--brand-primary);" x-text="'$' + total.toFixed(2)"></strong>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('orders.index') }}" class="btn">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Pedido y Reservar Stock</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function orderForm() {
    return {
        items: [{ product_id: '', quantity: 1, price: 0 }],
        get total() {
            return this.items.reduce((sum, item) => sum + (item.quantity * item.price), 0);
        },
        addItem() {
            this.items.push({ product_id: '', quantity: 1, price: 0 });
            this.$nextTick(() => lucide.createIcons());
        },
        removeItem(index) {
            this.items.splice(index, 1);
        },
        updatePrice(index) {
            const select = event.target;
            const price = select.options[select.selectedIndex].dataset.price;
            this.items[index].price = price || 0;
        }
    }
}
</script>

@endsection
