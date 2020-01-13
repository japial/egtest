@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
               <div class="card">
                <div class="card-header">
                    <span style="font-size: 20px; font-weight: 600;">Orders</span>
                </div>

                <div class="card-body h-400-scroll">
                    <h3 v-if="orderData && !orders.length" class="text-center">No Order Available</h3>
                    <table v-else class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Received</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order, index) in orders" :key="index">
                                <td v-text="index+1"></td>
                                <td v-text="order.name"></td>
                                <td v-text="order.description"></td>
                                <td v-text="order.quantity"></td>
                                <td>
                                    <span v-if="order.received" class="badge badge-success">YES</span>
                                    <span v-else class="badge badge-info">NO</span>
                                </td>
                                <td>
                                    <button class="btn btn-success" @click="deliveredOrder(index)">Delivered</button>
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
@endsection
@push('scripts')
    <script src="{{ asset('js/supplier.js') }}"></script>
@endpush
