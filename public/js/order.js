/* global axios, Swal */

const app = new Vue({
    el: '#app',
    data() {
        return {
            orderData: false,
            orderProduct: null,
            orderSelected: null,
            orderUser: null,
            orderQuantity: 0,
            orders: [],
            products: [],
            suppliers: [],
            orderErrors: {}
        };
    },
    mounted: function () {
        this.getOrders();
        this.getProducts();
        this.getSuppliers();
    },
    methods: {
        getOrders() {
            axios.get('/get-orders')
                    .then(response => {
                        this.orders = response.data;
                    }).catch(error => {
                console.log(error);
            }).finally(() => this.orderData = true);
        },
        getSuppliers() {
            axios.get('/suppliers')
                    .then(response => {
                        this.suppliers = response.data;
                        if (this.suppliers.length) {
                            this.orderUser = this.suppliers[0].id;
                        }
                    }).catch(error => {
                console.log(error);
            });
        },
        saveOrder() {
            this.orderErrors = [];
            let reqPath = '/orders';
            let orderForm = this.setOrderData();
            if (this.orderSelected) {
                reqPath = '/order-update';
                orderForm = this.setOrderData(this.orderSelected);
            }
            axios.post(reqPath, orderForm).then(response => {
                let result = response.data;
                if (result.status === 2) {
                    this.orders = result.orders;
                    this.resetOrderData();
                    $('#orderModal').modal("hide");
                    ;
                    this.showSuccessMessage('Order Saved');
                } else {
                    this.orderErrors = result.errors;
                }
            }).catch(error => {
                console.log(error);
            });
        },
        getSingleOrder(orderID) {
            this.orderSelected = orderID;
            axios.get('/orders/' + orderID)
                    .then(response => {
                        let order = response.data;
                        this.orderProduct = order.product_id;
                        this.orderUser = order.user_id;
                        this.orderQuantity = order.quantity;
                    }).catch(error => {
                console.log(error);
            });
        },
        getProducts() {
            axios.get('/products')
                    .then(response => {
                        this.products = response.data;
                        if (this.products.length) {
                            this.orderProduct = this.products[0].id;
                        }
                    }).catch(error => {
                console.log(error);
            });
        },
        deleteOrder(orderIndex) {
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
                    let order = this.orders[orderIndex];
                    let dataForm = new FormData();
                    dataForm.append('order_id', order.id);
                    axios.post('/order-delete', dataForm)
                            .then(response => {
                                let result = response.data;
                                if (result.status === 2) {
                                    if (orderIndex > -1) {
                                        this.orders.splice(orderIndex, 1);
                                    }
                                    this.showSuccessMessage('Order Deleted');
                                }
                            }).catch(error => {
                        console.log(error);
                    });
                }
            });
        },
        setOrderData(orderID = 0) {
            let dataForm = new FormData();
            if (orderID) {
                dataForm.append('order_id', orderID);
            }
            dataForm.append('product_id', this.orderProduct);
            dataForm.append('user_id', this.orderUser);
            dataForm.append('quantity', this.orderQuantity);
            return dataForm;
        },
        resetOrderData() {
            this.orderSelected = null;
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