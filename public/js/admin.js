/* global axios, Swal */

const app = new Vue({
    el: '#app',
    data() {
        return {
            productData: false,
            productName: 'New Product',
            productPrice: 0,
            productDescription: '',
            productStock: 0,
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
        saveProduct() {
            this.productErrors = [];
            axios.post('/products', this.setProductData()).then(response => {
                let result = response.data;
                if (result.status === 2) {
                    this.products = result.products;
                    this.resetProductData();
                    $('#productModal').modal("hide");;
                    this.showSuccessMessage('Product Saved');
                } else {
                    this.productErrors = result.errors;
                }
            }).catch(error => {
                console.log(error);
            });
        },
        setProductData() {
            let dataForm = new FormData();
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
        validString(item) {
            if (item && item.length) {
                return true;
            } else {
                return false;
            }
        }
    }
});