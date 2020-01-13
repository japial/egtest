/* global axios, Swal */

const app = new Vue({
    el: '#app',
    data() {
        return {
            productData: false,
            productName: '',
            productPrice: 0,
            productDescription: '',
            productStock: 0,
            productSelected: null,
            products: [],
            productErrors: {}
        };
    },
    mounted: function () {
        this.getProducts();
    },
    methods: {
        getProducts() {
            axios.get('/products')
                    .then(response => {
                        this.products = response.data;
                    }).catch(error => {
                console.log(error);
            }).finally(() => this.productData = true);
        },
        getSingleProduct(productID) {
            this.productSelected = productID;
            axios.get('/products/' + productID)
                    .then(response => {
                        let product = response.data;
                        this.productName = product.name;
                        this.productPrice = product.price;
                        this.productDescription = product.description;
                        this.productStock = product.stock;
                    }).catch(error => {
                console.log(error);
            });
        },
        saveProduct() {
            this.productErrors = [];
            let reqPath = '/products';
            let productForm = this.setProductData();
            if (this.productSelected) {
                reqPath = '/product-update';
                productForm = this.setProductData(this.productSelected);
            }
            axios.post(reqPath, productForm).then(response => {
                let result = response.data;
                if (result.status === 2) {
                    this.products = result.products;
                    this.resetProductData();
                    $('#productModal').modal("hide");
                    ;
                    this.showSuccessMessage('Product Saved');
                } else {
                    this.productErrors = result.errors;
                }
            }).catch(error => {
                console.log(error);
            });
        },
        deleteProduct(product_index) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    let product = this.products[product_index];
                    let dataForm = new FormData();
                    dataForm.append('product_id', product.id);
                    axios.post('/product-delete', dataForm)
                            .then(response => {
                                let result = response.data;
                                if (result.status === 2) {
                                    if (product_index > -1) {
                                        this.products.splice(product_index, 1);
                                    }
                                    this.showSuccessMessage('Product Deleted');
                                } else {
                                    this.showErrorMessage("This Product Have Order");
                                }
                            }).catch(error => {
                        console.log(error);
                    });
                }
            });
        },
        setProductData(productID = 0) {
            let dataForm = new FormData();
            if (productID) {
                dataForm.append('product_id', productID);
            }
            dataForm.append('name', this.productName);
            dataForm.append('price', this.productPrice);
            dataForm.append('stock', this.productStock);
            dataForm.append('description', this.productDescription);
            return dataForm;
        },
        resetProductData() {
            this.productName = '';
            this.productPrice = 0;
            this.productStock = 0;
            this.productDescription = '';
            this.productSelected = null;
        },
        showSuccessMessage(message) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        },
        showErrorMessage(message) {
            Swal.fire({
                icon: 'error',
                title: 'Sorry!',
                text: message
            });
        },
        validString(item) {
            if (item && item.length) {
                return true;
            } else {
                return false;
            }
        }
    }
});