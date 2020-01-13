@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span style="font-size: 20px; font-weight: 600;">Products</span>
                    <button class="btn btn-dark float-right" @click="resetProductData()" data-toggle="modal" data-target="#productModal">
                        Add Product
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, index) in products" :key="index">
                                <td v-text="index+1"></td>
                                <td v-text="product.name"></td>
                                <td v-text="product.description"></td>
                                <td v-text="product.price"></td>
                                <td v-text="product.stock"></td>
                                <td>
                                    <button class="btn btn-warning" @click="getSingleProduct(product.id)"
                                            data-toggle="modal" data-target="#productModal">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger" @click="deleteProduct(index)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-show="!productData" class="loader"></div>
                </div>
            </div>
        </div>
    </div>
    
    
</div>
<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel" v-if="validString(productName)" v-text="productName"></h5>
        <h5 class="modal-title" id="productModalLabel" v-else>New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <label>Name</label>
              <input type="text" v-model="productName" class="form-control" placeholder="Product Name">
              <div v-show="validString(productErrors.name)">
                  <span class="d-block p-2 text-danger" v-for="(error, index) in productErrors.name" :key="index" v-text="error"></span>
              </div>
          </div>
          <div class="form-group">
              <label>Price</label>
              <input type="text" v-model="productPrice" class="form-control" placeholder="Product Price">
              <div v-show="validString(productErrors.price)">
                  <span class="d-block p-2 text-danger" v-for="(error, index) in productErrors.price" :key="index" v-text="error"></span>
              </div>
          </div>
          <div class="form-group">
              <label>Stock</label>
              <input type="number" v-model="productStock" class="form-control" placeholder="Product Stock">
              <div v-show="validString(productErrors.stock)">
                  <span class="d-block p-2 text-danger" v-for="(error, index) in productErrors.stock" :key="index" v-text="error"></span>
              </div>
          </div>
          <div class="form-group">
              <label>Description</label>
              <textarea v-model="productDescription" rows="3" class="form-control"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" @click="saveProduct">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
@endpush
