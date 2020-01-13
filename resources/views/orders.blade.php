@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span style="font-size: 20px; font-weight: 600;">Orders</span>
                    <button class="btn btn-dark float-right" @click="resetOrderData()" data-toggle="modal" data-target="#orderModal">
                        Add Order
                    </button>
                </div>

                <div class="card-body h-400-scroll">
                    <h3 v-if="orderData && !orders.length" class="text-center">No Order Available</h3>
                    <table v-else class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Quantity</th>
                                <th>Received</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order, index) in orders" :key="index">
                                <td v-text="index+1"></td>
                                <td v-text="order.name"></td>
                                <td v-text="order.supplier"></td>
                                <td v-text="order.quantity"></td>
                                <td>
                                    <span v-if="order.received" class="badge badge-success">YES</span>
                                    <span v-else class="badge badge-info">NO</span>
                                </td>
                                <td>
                                    <button class="btn btn-warning" @click="getSingleOrder(order.id)"
                                            data-toggle="modal" data-target="#orderModal">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger" @click="deleteOrder(index)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-show="!orderData" class="loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Product</label>
                    <select v-model="orderProduct" class="form-control">
                        <option v-for="(product, index) in products" :key="index" :value="product.id" v-text="product.name"></option>
                    </select>
                    <div v-show="validString(orderErrors.product_id)">
                        <span class="d-block p-2 text-danger" v-for="(error, index) in orderErrors.product_id" :key="index" v-text="error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <select v-model="orderUser" class="form-control">
                        <option v-for="(supplier, index) in suppliers" :key="index" :value="supplier.id" v-text="supplier.name"></option>
                    </select>
                    <div v-show="validString(orderErrors.user_id)">
                        <span class="d-block p-2 text-danger" v-for="(error, index) in orderErrors.user_id" :key="index" v-text="error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" v-model="orderQuantity" class="form-control">
                    <div v-show="validString(orderErrors.quantity)">
                        <span class="d-block p-2 text-danger" v-for="(error, index) in orderErrors.quantity" :key="index" v-text="error"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="saveOrder">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ asset('js/order.js') }}"></script>
@endpush
