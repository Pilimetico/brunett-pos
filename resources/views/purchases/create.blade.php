@extends('layouts.app')

@section('title', 'Nueva Compra - Brunett')
@section('page_title', 'Registrar Ingreso de Mercadería')

@section('content')

<div class="panel" x-data="purchaseForm()">
    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem; background: #f8fafc; padding: 1.5rem; border-radius: 8px;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Proveedor *</label>
                <select name="supplier_id" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
                    <option value="">Seleccione un proveedor</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Factura / Documento # *</label>
                <input type="text" name="invoice_number" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Fecha de Compra *</label>
                <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; margin-bottom: 1rem;">Productos a Ingresar</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Producto</th>
                        <th>Cantidad</th>
                        <th>Costo Unitario</th>
                        <th>Subtotal</th>
                        <th style="text-align: right;"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, index) in items" :key="index">
                        <tr>
                            <td>
                                <select :name="'items['+index+'][product_id]'" x-model="item.product_id" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 4px;">
                                    <option value="">Seleccione producto</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" :name="'items['+index+'][quantity]'" x-model="item.quantity" step="0.01" min="0.01" required style="width: 80px; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 4px;">
                            </td>
                            <td>
                                <input type="number" :name="'items['+index+'][unit_cost]'" x-model="item.unit_cost" step="0.01" min="0" required style="width: 100px; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 4px;">
                            </td>
                            <td>
                                <span x-text="'$' + (item.quantity * item.unit_cost).toFixed(2)"></span>
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
                    Total Compra: <strong style="color: var(--brand-primary);" x-text="'$' + total.toFixed(2)"></strong>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('purchases.index') }}" class="btn">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Confirmar e Ingresar Stock</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function purchaseForm() {
    return {
        items: [{ product_id: '', quantity: 1, unit_cost: 0 }],
        get total() {
            return this.items.reduce((sum, item) => sum + (item.quantity * item.unit_cost), 0);
        },
        addItem() {
            this.items.push({ product_id: '', quantity: 1, unit_cost: 0 });
            this.$nextTick(() => lucide.createIcons());
        },
        removeItem(index) {
            this.items.splice(index, 1);
        }
    }
}
</script>

@endsection
